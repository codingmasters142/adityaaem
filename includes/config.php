<?php

define('SITE_NAME', 'Aditya Enterprises');
define('SITE_SHORT', 'AEM');
define('SITE_URL', 'https://adityaaem.in');
define('PHONE_DISPLAY', '+91 62329 90925');
define('PHONE_LINK', '+916232990925');
define('WHATSAPP_NUMBER', '916232990925');
define('WHATSAPP_MSG', 'Hello Aditya Enterprises, I would like to enquire about your products/services.');
define('EMAIL', 'aditya602jain@gmail.com');
define('ADDRESS_STREET', '18-B, Sector-D, Industrial Area');
define('ADDRESS_CITY', 'Mandideep');
define('ADDRESS_DISTRICT', 'Raisen');
define('ADDRESS_STATE', 'Madhya Pradesh');
define('ADDRESS_PIN', '462046');
define('ADDRESS_COUNTRY', 'IN');
define('GEO_LAT', '23.0950');
define('GEO_LNG', '77.5300');
define('BUSINESS_HOURS', 'Mo-Sa 09:30-18:30');
define('ADDRESS_FULL', ADDRESS_STREET . ', ' . ADDRESS_CITY . ', ' . ADDRESS_STATE . ' ' . ADDRESS_PIN);
define('LOGO_FILE', 'assets/images/logo.png');
define('BROCHURE_FILE', 'assets/brochure/AEM-Catalouge.pdf.pdf');
define('BROCHURE_DOWNLOAD_NAME', 'AEM-Catalogue.pdf'); // file name the visitor's download is saved as
// Social accounts: paste the full profile URL. An empty value hides that icon everywhere.
define('FACEBOOK_URL', 'https://www.facebook.com/profile.php?id=61595744136185');
define('INSTAGRAM_URL', 'https://www.instagram.com/aem_aditya/');
define('LINKEDIN_URL', 'https://www.linkedin.com/in/aditya-enterprises-aba40720a');
define('YOUTUBE_URL', 'https://www.youtube.com/@adityaenterprises2304');

// Lead emails are sent through a real mailbox (SMTP) so Gmail does not mark them as fake.
// Mailbox passwords and the /leads page password live in includes/secrets.php (not in git).
// Copy includes/secrets.example.php to includes/secrets.php and fill it in.
if (is_file(__DIR__ . '/secrets.php')) {
    require __DIR__ . '/secrets.php';
}
defined('SMTP_HOST') || define('SMTP_HOST', '');       // e.g. smtp.hostinger.com; empty = fall back to PHP mail()
defined('SMTP_PORT') || define('SMTP_PORT', 465);      // 465 = SSL
defined('SMTP_USER') || define('SMTP_USER', '');       // full mailbox address, e.g. info@adityaaem.in
defined('SMTP_PASS') || define('SMTP_PASS', '');
defined('MAIL_FROM') || define('MAIL_FROM', SMTP_USER !== '' ? SMTP_USER : 'noreply@adityaaem.in');
defined('LEADS_PASSWORD') || define('LEADS_PASSWORD', ''); // empty = /leads page is locked

// Subfolder the site runs in: '' on the live server, '/aditya-aem' on localhost
$aemDocRoot = rtrim(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: ''), '/');
$aemAppRoot = str_replace('\\', '/', realpath(__DIR__ . '/..'));
define('BASE_PATH', ($aemDocRoot !== '' && stripos($aemAppRoot, $aemDocRoot) === 0) ? rtrim(substr($aemAppRoot, strlen($aemDocRoot)), '/') : '');

function aem_url($path = '')
{
    $path = ltrim((string) $path, '/');
    return SITE_URL . ($path !== '' ? '/' . $path : '');
}

function aem_clean_url($path = '')
{
    $path = ltrim((string) $path, '/');
    return BASE_PATH . '/' . $path;
}

function aem_current_year()
{
    return (int) date('Y');
}

function aem_format_phone($phone)
{
    return htmlspecialchars((string) $phone, ENT_QUOTES, 'UTF-8');
}

function aem_safe_text($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

function aem_href($url)
{
    $url = (string) $url;
    return (strpos($url, '/') === 0 && strpos($url, '//') !== 0) ? BASE_PATH . $url : $url;
}

function aem_slugify($text)
{
    $text = strtolower(trim((string) $text));
    $text = str_replace('&', ' and ', $text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function aem_whatsapp_url($message = WHATSAPP_MSG)
{
    return 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . rawurlencode((string) $message);
}

function aem_product_whatsapp_url($productName)
{
    return aem_whatsapp_url('Hello, I am interested in ' . $productName . '. Please share more details and pricing.');
}

function aem_csrf_token()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf_token'];
}

function aem_icon_whatsapp()
{
    return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.9 9.9 0 0 0 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2Zm5.8 14.03c-.25.69-1.44 1.32-1.98 1.37-.53.05-1.03.24-3.47-.72-2.93-1.16-4.79-4.15-4.93-4.35-.14-.19-1.18-1.57-1.18-2.99 0-1.42.75-2.12 1.01-2.41.27-.29.58-.36.78-.36l.56.01c.18.01.42-.07.66.5.25.59.84 2.04.91 2.19.07.15.12.32.02.51-.1.2-.15.32-.29.49-.15.17-.31.38-.44.51-.15.15-.3.3-.13.6.17.29.76 1.26 1.64 2.04 1.13 1 2.08 1.31 2.38 1.46.29.15.47.12.64-.07.17-.2.74-.86.94-1.16.2-.29.39-.24.66-.15.27.1 1.71.81 2 .96.29.15.49.22.56.34.07.12.07.69-.18 1.38Z"/></svg>';
}

function aem_icon_download()
{
    return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 4v11M7 10l5 5 5-5M5 20h14"/></svg>';
}

function aem_icon_arrow()
{
    return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>';
}

// Social profiles: ['Facebook' => ['url' => ..., 'icon' => svg], ...]
// Only profiles with a URL set, unless $withFallback: then a missing URL falls back to the platform's home page.
function aem_social_links($withFallback = false)
{
    $icons = [
        'Facebook' => [FACEBOOK_URL ?: ($withFallback ? 'https://www.facebook.com/' : ''), '<path fill="currentColor" d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.87.25-1.46 1.5-1.46h1.6V4.45A21 21 0 0 0 14.27 4.3c-2.3 0-3.87 1.4-3.87 3.98v2.22H7.8v3h2.6V21h3.1Z"/>'],
        'Instagram' => [INSTAGRAM_URL ?: ($withFallback ? 'https://www.instagram.com/' : ''), '<path fill="none" stroke="currentColor" stroke-width="1.9" d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Z"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.9"/><circle cx="17.3" cy="6.7" r="1.2" fill="currentColor"/>'],
        'LinkedIn' => [LINKEDIN_URL ?: ($withFallback ? 'https://www.linkedin.com/' : ''), '<path fill="currentColor" d="M6.94 8.5H3.56V20h3.38V8.5ZM5.25 3a1.96 1.96 0 1 0 0 3.92 1.96 1.96 0 0 0 0-3.92ZM20.44 13.4c0-3.1-1.65-4.55-3.86-4.55a3.33 3.33 0 0 0-3.02 1.66V8.5h-3.37V20h3.37v-5.7c0-1.5.28-2.95 2.14-2.95 1.83 0 1.86 1.71 1.86 3.05V20h3.38v-6.6Z"/>'],
        'YouTube' => [YOUTUBE_URL ?: ($withFallback ? 'https://www.youtube.com/' : ''), '<path fill="currentColor" d="M21.6 7.2a2.5 2.5 0 0 0-1.76-1.77C18.27 5 12 5 12 5s-6.27 0-7.84.43A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.76 1.77C5.73 19 12 19 12 19s6.27 0 7.84-.43a2.5 2.5 0 0 0 1.76-1.77A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8ZM10 15V9l5.2 3L10 15Z"/>'],
    ];
    $links = [];
    foreach ($icons as $name => [$url, $path]) {
        if ($url !== '') {
            $links[$name] = ['url' => $url, 'icon' => '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . $path . '</svg>'];
        }
    }
    return $links;
}

function aem_social_list($class = 'social-links', $withFallback = false)
{
    $links = aem_social_links($withFallback);
    if (!$links) {
        return '';
    }
    $html = '<ul class="' . aem_safe_text($class) . '">';
    foreach ($links as $name => $link) {
        $html .= '<li><a href="' . aem_safe_text($link['url']) . '" target="_blank" rel="noopener" aria-label="Aditya Enterprises on ' . $name . '" title="' . $name . '">' . $link['icon'] . '</a></li>';
    }
    return $html . '</ul>';
}

// Breadcrumb trail: ['Label' => '/path', ..., 'Current page' => null]
function aem_breadcrumbs(array $trail)
{
    $html = '<nav class="breadcrumbs" aria-label="Breadcrumb"><ol>';
    foreach ($trail as $label => $url) {
        $html .= $url === null
            ? '<li aria-current="page">' . aem_safe_text($label) . '</li>'
            : '<li><a href="' . aem_safe_text(aem_href($url)) . '">' . aem_safe_text($label) . '</a></li>';
    }
    return $html . '</ol></nav>';
}
