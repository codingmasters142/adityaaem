<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/partials.php';
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

$status = $_SESSION['contact_status'] ?? '';
$message = $_SESSION['contact_message'] ?? '';
unset($_SESSION['contact_status'], $_SESSION['contact_message']);

$page_title = 'Contact Aditya Enterprises (AEM) | Enquiries from Across India';
$page_description = 'Contact AEM at 18-B, Sector-D, Industrial Area, Mandideep, MP 462046. Call/WhatsApp ' . PHONE_DISPLAY . ' or email aditya602jain@gmail.com for a quote.';
$page_keywords = 'contact Aditya Enterprises, AEM enquiry, steel fabrication quote';
$active_nav = 'contact';
$schema = breadcrumb_schema(['Home' => aem_url(''), 'Contact Us' => aem_url('contact-us')]);
$canonical = aem_url('contact-us');
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'Contact Us' => null]); ?>
            <h1>Contact Us</h1>
            <p class="lead">Send us your requirement or drawing and our team will reply with a clear quotation. We serve customers across India.</p>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <?php if ($status === 'success'): ?>
                <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php elseif ($status === 'error'): ?>
                <div class="alert alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <div class="contact-card-grid">
                <div class="contact-card">
                    <div class="icon-box"><svg viewBox="0 0 24 24"><path d="M5 4h7l3 5-3 2a13 13 0 0 0 6 6l2-3 5 3v7c-7 0-14-7-14-14Z"/></svg></div>
                    <h3>Call Us</h3>
                    <p><a href="tel:<?= PHONE_LINK ?>"><?= PHONE_DISPLAY ?></a></p>
                </div>
                <div class="contact-card">
                    <div class="icon-box"><svg viewBox="0 0 24 24"><path d="M20 15.5a7.5 7.5 0 0 1-2.5-.5 1.4 1.4 0 0 0-1.4.3l-1.7 1.7a14.3 14.3 0 0 1-6.4-6.4l1.7-1.7a1.4 1.4 0 0 0 .3-1.4A7.5 7.5 0 0 1 8.5 4H4a1 1 0 0 0-1 1C3 15.7 9.3 22 18 22a1 1 0 0 0 1-1v-4.5Z"/></svg></div>
                    <h3>WhatsApp</h3>
                    <p><a href="<?= aem_safe_text(aem_whatsapp_url()); ?>" target="_blank" rel="noopener"><?= PHONE_DISPLAY ?></a></p>
                </div>
                <div class="contact-card">
                    <div class="icon-box"><svg viewBox="0 0 24 24"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5z"/><path d="m5 7 7 6 7-6"/></svg></div>
                    <h3>Email</h3>
                    <p><a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a></p>
                </div>
                <div class="contact-card">
                    <div class="icon-box"><svg viewBox="0 0 24 24"><path d="M12 22s8-6.8 8-13a8 8 0 1 0-16 0c0 6.2 8 13 8 13Z"/><circle cx="12" cy="9" r="2.5"/></svg></div>
                    <h3>Visit Us</h3>
                    <p><a href="https://maps.google.com/?q=<?= rawurlencode(ADDRESS_FULL); ?>" target="_blank" rel="noopener">18-B, Sector-D, Industrial Area, Mandideep, Madhya Pradesh 462046, India</a></p>
                </div>
            </div>

            <div class="contact-grid">
                <div class="form-panel">
                    <h2>Send an Enquiry</h2>
                    <p>Business hours: Monday – Saturday, 9:30 AM – 6:30 PM (Sunday closed)</p>
                    <form action="<?= BASE_PATH; ?>/contact-handler.php" method="post">
                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="honeypot">
                            <label for="website">Leave this empty</label>
                            <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" required>
                            </div>
                            <div class="form-field">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="tel" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" required>
                            </div>
                            <div class="form-field">
                                <label for="service">Product Category</label>
                                <select id="service" name="service">
                                    <option value="">Select a category</option>
                                    <?php foreach (aem_categories() as $option): ?>
                                        <option><?= aem_safe_text($option['title']); ?></option>
                                    <?php endforeach; ?>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" placeholder="Tell us your requirement, drawing or quantity" required></textarea>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Send Enquiry</button>
                    </form>
                </div>
                <div class="map-box">
                    <iframe title="Aditya Enterprises location map" src="https://www.google.com/maps?q=Industrial%20Area%20Sector%20D%20Mandideep%20462046&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
