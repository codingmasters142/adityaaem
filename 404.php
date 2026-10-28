<?php
http_response_code(404);
require_once __DIR__ . '/includes/config.php';
$page_title = 'Page Not Found';
$page_description = 'The page you are looking for does not exist.';
$page_keywords = '404, page not found';
$robots = 'noindex';
$canonical = aem_url('404');
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <h1>Page Not Found</h1>
            <p class="lead">The page you are looking for doesn't exist or has moved.</p>
            <div class="page-hero-actions">
                <a class="btn btn-primary" href="<?= BASE_PATH; ?>/">Go to Home</a>
                <a class="btn btn-secondary" href="<?= BASE_PATH; ?>/categories">View Categories</a>
                <a class="btn btn-secondary" href="<?= BASE_PATH; ?>/contact-us">Contact Us</a>
            </div>
            <div style="margin-top:24px;">
                <h3>Popular categories</h3>
                <ul>
                    <li><a href="<?= BASE_PATH; ?>/category/steel-fabrication">Steel Fabrication</a></li>
                    <li><a href="<?= BASE_PATH; ?>/category/stainless-steel-furniture">Stainless Steel Furniture</a></li>
                    <li><a href="<?= BASE_PATH; ?>/category/material-handling-equipment">Material Handling Equipment</a></li>
                    <li><a href="<?= BASE_PATH; ?>/category/storage-racks">Storage Racks</a></li>
                    <li><a href="<?= BASE_PATH; ?>/category/pre-engineered-buildings">PEB Structures</a></li>
                </ul>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
