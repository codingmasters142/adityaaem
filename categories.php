<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/partials.php';
$categories = aem_categories();

$page_title = 'Product Categories – Industrial Fabrication & Storage Products | AEM';
$page_description = 'Browse all AEM product categories: SS furniture, lockers, pallet trucks, stackers, storage racks, pallets & bins, tool cabinets, PEB, machining and more. Supplied across India.';
$page_keywords = 'industrial products, steel fabrication, stainless steel furniture, pallet trucks, storage racks, PEB, machining';
$canonical = aem_url('categories');
$active_nav = 'categories';
$position = 0;
$schema = [
    breadcrumb_schema(['Home' => aem_url(''), 'Categories' => $canonical]),
    [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => 'Aditya Enterprises Product Categories',
        'itemListElement' => array_values(array_map(function ($category) use (&$position) {
            return [
                '@type' => 'ListItem',
                'position' => ++$position,
                'name' => $category['title'],
                'url' => aem_url(ltrim($category['url'], '/')),
            ];
        }, $categories)),
    ],
];
$groups = array_values(array_unique(array_column($categories, 'category')));
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'Categories' => null]); ?>
            <h1>Product Categories</h1>
            <p class="lead">Everything we design, fabricate and supply. Each product is built to your specification in our own facility and delivered to customers across India.</p>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <div class="toolbar">
                <div class="filter-list" role="group" aria-label="Filter categories" style="margin-bottom: 0;">
                    <button class="filter-chip active" type="button" data-filter="all" aria-pressed="true">All</button>
                    <?php foreach ($groups as $group): ?>
                        <button class="filter-chip" type="button" data-filter="<?= aem_safe_text($group); ?>" aria-pressed="false"><?= aem_safe_text($group); ?></button>
                    <?php endforeach; ?>
                </div>
                <p class="result-count"><?= count($categories); ?> categories · <?= aem_product_count(); ?> products</p>
            </div>
            <div class="category-grid" data-filter-grid>
                <?php foreach ($categories as $category) { aem_category_card($category, 'h2'); } ?>
            </div>
        </div>
    </section>

    <?php aem_cta_band('Can&apos;t find what you need?', 'We fabricate to drawing. Send us your requirement and we will quote quickly.'); ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
