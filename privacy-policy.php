<?php
require_once __DIR__ . '/includes/config.php';
$page_title = 'Privacy Policy | Aditya Enterprises';
$page_description = 'Privacy policy for Aditya Enterprises website form submissions and contact enquiries.';
$page_keywords = 'privacy policy, contact form data, Aditya Enterprises';
$canonical = aem_url('privacy-policy');
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'Privacy Policy' => null]); ?>
            <h1>Privacy Policy</h1>
        </div>
    </section>

    <section class="page-content">
        <div class="container prose">
            <p>We collect information submitted through our enquiry form, including name, phone number, email address and message details. This information is used only to respond to your enquiry, provide a quotation or contact you regarding our products and services.</p>
            <p>We do not sell or share your personal information with third parties for marketing purposes. We retain the information only for the period needed to answer your enquiry and support our business communication.</p>
            <p>If you want your information removed from our records, please contact us at <a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a> and we will process your request.</p>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
