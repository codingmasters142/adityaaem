<?php
session_start();
require_once __DIR__ . '/includes/leads.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_PATH . '/contact-us');
    exit;
}

if (!isset($_POST['csrf']) || !isset($_SESSION['csrf_token']) || hash_equals($_SESSION['csrf_token'], (string) $_POST['csrf']) === false) {
    $_SESSION['contact_status'] = 'error';
    $_SESSION['contact_message'] = 'Your enquiry could not be submitted. Please try again.';
    header('Location: ' . BASE_PATH . '/contact-us');
    exit;
}

$honeypot = trim((string) ($_POST['website'] ?? ''));
if ($honeypot !== '') {
    $_SESSION['contact_status'] = 'error';
    $_SESSION['contact_message'] = 'The form could not be submitted.';
    header('Location: ' . BASE_PATH . '/contact-us');
    exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$phone = trim((string) ($_POST['phone'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$service = trim((string) ($_POST['service'] ?? ''));

if ($name === '' || $phone === '' || $email === '' || $message === '') {
    $_SESSION['contact_status'] = 'error';
    $_SESSION['contact_message'] = 'Please fill in all required fields.';
    header('Location: ' . BASE_PATH . '/contact-us');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['contact_status'] = 'error';
    $_SESSION['contact_message'] = 'Please enter a valid email address.';
    header('Location: ' . BASE_PATH . '/contact-us');
    exit;
}

if (!isset($_SESSION['last_contact_submit']) || (time() - (int) $_SESSION['last_contact_submit']) > 30) {
    $_SESSION['last_contact_submit'] = time();
} else {
    $_SESSION['contact_status'] = 'error';
    $_SESSION['contact_message'] = 'Please wait a few moments before sending another enquiry.';
    header('Location: ' . BASE_PATH . '/contact-us');
    exit;
}

$page = (string) ($_SERVER['HTTP_REFERER'] ?? '');
aem_save_lead('enquiry', ['Name' => $name, 'Phone' => $phone, 'Email' => $email, 'Product / Category' => $service, 'Message' => $message, 'Page' => $page]);

$subject = 'New enquiry from ' . $name;
$body = "Name: $name\nPhone: $phone\nEmail: $email\nProduct / Category: $service\nPage: $page\n\nMessage:\n$message\n";
aem_send_mail(EMAIL, $subject, $body, $email);

$_SESSION['contact_status'] = 'success';
$_SESSION['contact_message'] = 'Thank you. Your enquiry has been submitted successfully. Our team will contact you shortly.';

// Open WhatsApp with the enquiry filled in, addressed to our number (the lead is already saved and emailed above).
$whatsappText = "New enquiry from website\n\nName: $name\nPhone: $phone\nEmail: $email"
    . ($service !== '' ? "\nProduct / Category: $service" : '')
    . "\n\nMessage:\n$message";
header('Location: ' . aem_whatsapp_url($whatsappText));
exit;
