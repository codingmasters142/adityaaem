<?php
require_once __DIR__ . '/config.php';

// Leads are stored one JSON object per line, in a folder the web server refuses to serve.
define('LEADS_FILE', __DIR__ . '/../storage/leads.jsonl');

/**
 * Save a lead so it is never lost, even when the email does not arrive.
 * $type is 'enquiry' or 'brochure'; $fields is a flat label => value array.
 */
function aem_save_lead($type, array $fields)
{
    $dir = dirname(LEADS_FILE);
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }
    $record = [
        'type' => $type,
        'date' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        'fields' => $fields,
    ];
    return @file_put_contents(LEADS_FILE, json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n", FILE_APPEND | LOCK_EX) !== false;
}

/** All saved leads, newest first. */
function aem_read_leads()
{
    if (!is_file(LEADS_FILE)) {
        return [];
    }
    $leads = [];
    foreach (file(LEADS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $lead = json_decode($line, true);
        if (is_array($lead)) {
            $leads[] = $lead;
        }
    }
    return array_reverse($leads);
}

/** Send a plain-text email: through the SMTP mailbox when configured, otherwise PHP mail(). */
function aem_send_mail($to, $subject, $body, $replyTo = '')
{
    if (SMTP_HOST !== '' && SMTP_USER !== '' && SMTP_PASS !== '') {
        return aem_smtp_send($to, $subject, $body, $replyTo);
    }
    if (!function_exists('mail')) {
        return false;
    }
    $headers = 'From: ' . SITE_NAME . ' <' . MAIL_FROM . ">\r\n"
        . ($replyTo !== '' ? 'Reply-To: ' . $replyTo . "\r\n" : '')
        . "Content-Type: text/plain; charset=UTF-8\r\n";
    return @mail($to, aem_mail_header_encode($subject), $body, $headers, '-f' . MAIL_FROM);
}

function aem_mail_header_encode($text)
{
    return preg_match('/[^\x20-\x7E]/', $text) ? '=?UTF-8?B?' . base64_encode($text) . '?=' : $text;
}

/** Minimal SMTP client (SSL on port 465, or STARTTLS on 587) with AUTH LOGIN. */
function aem_smtp_send($to, $subject, $body, $replyTo = '')
{
    $port = (int) SMTP_PORT;
    $remote = ($port === 465 ? 'ssl://' : 'tcp://') . SMTP_HOST . ':' . $port;
    $socket = @stream_socket_client($remote, $errno, $errstr, 15);
    if (!$socket) {
        error_log("AEM mail: cannot connect to $remote ($errstr)");
        return false;
    }
    stream_set_timeout($socket, 15);

    $read = function () use ($socket) {
        $reply = '';
        while (($line = fgets($socket, 515)) !== false) {
            $reply .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        return $reply;
    };
    $send = function ($command, $expect) use ($socket, $read) {
        fwrite($socket, $command . "\r\n");
        $reply = $read();
        if ((int) substr($reply, 0, 3) !== $expect) {
            throw new RuntimeException(trim($reply));
        }
        return $reply;
    };

    try {
        if ((int) substr($read(), 0, 3) !== 220) {
            throw new RuntimeException('no greeting');
        }
        $hostname = parse_url(SITE_URL, PHP_URL_HOST) ?: 'localhost';
        $send('EHLO ' . $hostname, 250);
        if ($port === 587) {
            $send('STARTTLS', 220);
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new RuntimeException('STARTTLS failed');
            }
            $send('EHLO ' . $hostname, 250);
        }
        $send('AUTH LOGIN', 334);
        $send(base64_encode(SMTP_USER), 334);
        $send(base64_encode(SMTP_PASS), 235);
        $send('MAIL FROM:<' . MAIL_FROM . '>', 250);
        $send('RCPT TO:<' . $to . '>', 250);
        $send('DATA', 354);

        $headers = [
            'Date: ' . date('r'),
            'From: ' . SITE_NAME . ' <' . MAIL_FROM . '>',
            'To: <' . $to . '>',
            'Subject: ' . aem_mail_header_encode($subject),
            'Message-ID: <' . bin2hex(random_bytes(12)) . '@' . $hostname . '>',
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
        ];
        if ($replyTo !== '') {
            $headers[] = 'Reply-To: ' . $replyTo;
        }
        // Normalise line endings and escape lines that start with a dot
        $text = preg_replace('/^\./m', '..', str_replace(["\r\n", "\r"], "\n", $body));
        $send(implode("\r\n", $headers) . "\r\n\r\n" . str_replace("\n", "\r\n", $text) . "\r\n.", 250);
        $send('QUIT', 221);
        fclose($socket);
        return true;
    } catch (RuntimeException $e) {
        error_log('AEM mail: SMTP error: ' . $e->getMessage());
        fclose($socket);
        return false;
    }
}
