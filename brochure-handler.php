<?php
session_start();
require_once __DIR__ . '/includes/leads.php';

header('Content-Type: application/json; charset=utf-8');

function aem_brochure_reply($ok, $message, $status = 200)
{
    http_response_code($status);
    echo json_encode(['ok' => $ok, 'message' => $message, 'url' => $ok ? aem_clean_url(BROCHURE_FILE) : null, 'filename' => $ok ? BROCHURE_DOWNLOAD_NAME : null]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    aem_brochure_reply(false, 'Invalid request.', 405);
}

// Only accept submissions sent from this site
$origin = (string) ($_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '');
$host = (string) ($_SERVER['HTTP_HOST'] ?? '');
if ($origin === '' || parse_url($origin, PHP_URL_HOST) . (parse_url($origin, PHP_URL_PORT) ? ':' . parse_url($origin, PHP_URL_PORT) : '') !== $host) {
    aem_brochure_reply(false, 'Invalid request.', 403);
}

if (trim((string) ($_POST['website'] ?? '')) !== '') {
    aem_brochure_reply(false, 'The form could not be submitted.', 400);
}

$name = trim(preg_replace('/\s+/', ' ', (string) ($_POST['name'] ?? '')));
$phone = trim((string) ($_POST['phone'] ?? ''));
$page = trim((string) ($_POST['page'] ?? ''));

if ($name === '' || mb_strlen($name) > 80) {
    aem_brochure_reply(false, 'Please enter your name.', 422);
}

$phoneDigits = preg_replace('/\D/', '', $phone);
if (!preg_match('/^\+?[\d\s\-()]{7,20}$/', $phone) || strlen($phoneDigits) < 10 || strlen($phoneDigits) > 15) {
    aem_brochure_reply(false, 'Please enter a valid contact number.', 422);
}

if (isset($_SESSION['last_brochure_submit']) && (time() - (int) $_SESSION['last_brochure_submit']) < 30) {
    aem_brochure_reply(false, 'Please wait a few moments before trying again.', 429);
}
$_SESSION['last_brochure_submit'] = time();

$subject = 'Brochure download lead: ' . $name;
$body = "A visitor downloaded the brochure.\n\n"
    . "Name: $name\n"
    . "Contact number: $phone\n"
    . 'Page: ' . ($page !== '' ? $page : '-') . "\n"
    . 'Date: ' . date('d M Y, h:i A') . "\n";

aem_save_lead('brochure', ['Name' => $name, 'Phone' => $phone, 'Page' => $page]);
aem_send_mail(EMAIL, $subject, $body);

aem_brochure_reply(true, 'Thank you! Your brochure download will start now.');
