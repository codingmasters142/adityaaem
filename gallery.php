<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/partials.php';
$gallery = array_map(function ($item) {
    return ['src' => aem_image_src($item['image']), 'title' => $item['title'], 'category' => $item['category']];
}, require __DIR__ . '/data/gallery.php');
$galleryGroups = array_values(array_unique(array_column($gallery, 'category')));

$page_title = 'Gallery – Fabrication Work & Products | Aditya Enterprises';
$page_description = 'See photos of AEM\'s plasma coating, rubber coating, machining, steel fabrication, SS furniture and storage work from our in-house facility, supplied across India.';
$page_keywords = 'AEM gallery, plasma coating, rubber coating, machining items, fabrication work, storage racks, stainless steel furniture, material handling';
$active_nav = 'gallery';
$canonical = aem_url('gallery');
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'Gallery' => null]); ?>
            <h1>Our Work Gallery</h1>
            <p class="lead">A look at the products we manufacture and the fabrication work we deliver.</p>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <div class="filter-list" role="group" aria-label="Gallery filters">
                <button class="filter-chip active" type="button" data-filter="all" aria-pressed="true">All</button>
                <?php foreach ($galleryGroups as $group): ?>
                    <button class="filter-chip" type="button" data-filter="<?= aem_safe_text($group); ?>" aria-pressed="false"><?= aem_safe_text($group); ?></button>
                <?php endforeach; ?>
            </div>
            <?php aem_gallery_grid($gallery, true); ?>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="cta-band">
                <div class="cta-inner">
                    <div>
                        <h2>Need a custom fabrication solution?</h2>
                        <p>Contact AEM for a detailed quotation.</p>
                    </div>
                    <div class="cta-actions">
                        <a class="btn btn-primary" href="<?= BASE_PATH; ?>/contact-us">Send Enquiry</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php aem_gallery_lightbox(); ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
