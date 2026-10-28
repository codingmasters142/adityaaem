<?php
require_once __DIR__ . '/catalog.php';
?>
<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-about">
            <a href="<?= BASE_PATH; ?>/" class="footer-brand" aria-label="Aditya Enterprises home">
                <img class="brand-logo" src="<?= aem_clean_url(LOGO_FILE); ?>" alt="Aditya Enterprises (AEM) logo" width="48" height="48" loading="lazy">
                <span class="brand-name">Aditya Enterprises</span>
            </a>
            <p>We make steel fabrication, SS furniture, storage racks and material handling equipment, and we do machining, plasma coating and rubber coating work. Our customers are all over the world.</p>
            <a class="btn btn-whatsapp btn-sm" href="<?= aem_safe_text(aem_whatsapp_url()); ?>" target="_blank" rel="noopener"><?= aem_icon_whatsapp(); ?> Enquire on WhatsApp</a>
            <?= aem_social_list('social-links', true); ?>
        </div>
        <div>
            <h3>Quick Links</h3>
            <ul class="footer-links">
                <li><a href="<?= BASE_PATH; ?>/about-us">About Us</a></li>
                <li><a href="<?= BASE_PATH; ?>/categories">Product Categories</a></li>
                <li><a href="<?= BASE_PATH; ?>/clients">Our Valuable Clients</a></li>
                <li><a href="<?= BASE_PATH; ?>/gallery">Gallery</a></li>
                <li><a href="<?= BASE_PATH; ?>/blog">Blog</a></li>
                <li><a href="<?= BASE_PATH; ?>/contact-us">Contact Us</a></li>
            </ul>
        </div>
        <div>
            <h3>Popular Categories</h3>
            <ul class="footer-links">
                <?php foreach (array_slice(aem_categories(), 0, 7) as $footerCategory): ?>
                    <li><a href="<?= aem_safe_text(aem_href($footerCategory['url'])); ?>"><?= aem_safe_text($footerCategory['title']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h3>Contact</h3>
            <ul class="footer-links contact-links">
                <li><a href="https://maps.google.com/?q=<?= rawurlencode(ADDRESS_FULL); ?>" target="_blank" rel="noopener"><?= ADDRESS_STREET ?>,<br><?= ADDRESS_CITY ?>, <?= ADDRESS_STATE ?> <?= ADDRESS_PIN ?>, India</a></li>
                <li><a href="tel:<?= PHONE_LINK ?>"><?= PHONE_DISPLAY ?></a></li>
                <li><a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a></li>
                <li>Mon – Sat, 9:30 AM – 6:30 PM</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p>© <?= aem_current_year(); ?> <?= SITE_NAME ?>. All Rights Reserved. (Powered by <a class="credit-link" href="https://codingmedia.in/" target="_blank" rel="noopener">Coding Media</a>)</p>
            <a href="<?= BASE_PATH; ?>/privacy-policy">Privacy Policy</a>
        </div>
    </div>
</footer>

<div class="floating-actions" aria-label="Quick actions">
    <a href="<?= aem_safe_text(aem_whatsapp_url()); ?>" class="float-btn whatsapp" target="_blank" rel="noopener" aria-label="Chat on WhatsApp" title="Chat on WhatsApp">
        <?= aem_icon_whatsapp(); ?>
    </a>
    <a href="tel:<?= PHONE_LINK ?>" class="float-btn call" aria-label="Call Aditya Enterprises" title="Call Aditya Enterprises">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.62 10.79a15.35 15.35 0 0 0 6.59 6.59l2.2-2.2a1.12 1.12 0 0 1 1.1-.27c1.2.39 2.5.6 3.82.6a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.85 21 3 13.15 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.32.21 2.62.6 3.82a1.12 1.12 0 0 1-.27 1.1l-2.21 2.21Z"/></svg>
    </a>
</div>

<dialog class="brochure-modal" id="brochure-modal" aria-labelledby="brochure-title">
    <button class="brochure-close" type="button" aria-label="Close" data-brochure-close>&times;</button>
    <span class="eyebrow">Free download</span>
    <h2 id="brochure-title">Get Our Company Brochure</h2>
    <p>Share your name and contact number and the brochure will download right away.</p>
    <form class="brochure-form" action="<?= BASE_PATH; ?>/brochure-handler.php" method="post" novalidate>
        <div class="honeypot">
            <label for="brochure-website">Leave this empty</label>
            <input id="brochure-website" name="website" type="text" tabindex="-1" autocomplete="off">
        </div>
        <div class="form-field">
            <label for="brochure-name">Name</label>
            <input id="brochure-name" name="name" type="text" maxlength="80" autocomplete="name" required>
        </div>
        <div class="form-field">
            <label for="brochure-phone">Contact Number</label>
            <input id="brochure-phone" name="phone" type="tel" inputmode="tel" maxlength="20" autocomplete="tel" placeholder="Your mobile number" required>
        </div>
        <p class="brochure-status" role="status" aria-live="polite"></p>
        <button class="btn btn-primary btn-block" type="submit"><?= aem_icon_download(); ?> Download Brochure</button>
    </form>
</dialog>

</body>
</html>
