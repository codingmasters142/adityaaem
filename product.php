<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/partials.php';

$category = aem_category($_GET['category'] ?? '');
$product = $category['products'][(string) ($_GET['slug'] ?? '')] ?? null;
$movedProducts = [ // coating products now have their own categories
    'industrial-repair-services/rubber-coating-service' => '/category/rubber-coating',
    'industrial-repair-services/plasma-coating' => '/category/plasma-coating',
    'polycarbonate-acrylic-products/silicon-rubber-cups' => '/category/silicone-products/silicon-rubber-cups',
    'polycarbonate-acrylic-products/teflon-hose-separator' => '/category/teflon-products/teflon-hose-separator',
];
$movedTo = $movedProducts[($_GET['category'] ?? '') . '/' . ($_GET['slug'] ?? '')] ?? null;
if (!$product && $movedTo) {
    header('Location: ' . aem_href($movedTo), true, 301);
    exit;
}
if (!$product) {
    require __DIR__ . '/404.php';
    exit;
}
aem_csrf_token(); // start the session before any output

$productUrl = aem_url(ltrim($product['url'], '/'));
$categoryUrl = aem_url(ltrim($category['url'], '/'));
$page_title = $product['name'] . ' | ' . $category['title'] . ' | Aditya Enterprises';
$details = $product['details'];
$features = $details['features'] ?? $category['features'];
$page_description = !empty($details['description'])
    ? $details['description'] . ' Supplied across India by Aditya Enterprises.'
    : 'Enquire about ' . $product['name'] . ' from Aditya Enterprises (AEM), part of our ' . $category['title'] . ' range. ' . $category['short'] . ' Supplied across India.';
$page_keywords = implode(', ', [$product['name'], $category['title'], 'Aditya Enterprises', 'AEM']);
$canonical = $productUrl;
$og_image = aem_absolute_image($product['image']);
$active_nav = 'categories';
$schema = [
    breadcrumb_schema([
        'Home' => aem_url(''),
        'Categories' => aem_url('categories'),
        $category['title'] => $categoryUrl,
        $product['name'] => $productUrl,
    ]),
    [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product['name'],
        'image' => aem_absolute_image($product['image']),
        'description' => $page_description,
        'category' => $category['title'],
        'url' => $productUrl,
        'brand' => ['@type' => 'Brand', 'name' => SITE_NAME],
        'manufacturer' => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => SITE_URL],
    ],
];
$related = array_slice(array_filter($category['products'], function ($item) use ($product) {
    return $item['slug'] !== $product['slug'];
}), 0, 8);

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'Categories' => '/categories', $category['title'] => $category['url'], $product['name'] => null]); ?>
        </div>
    </section>

    <section class="page-content">
        <div class="container product-layout">
            <div class="product-media">
                <img src="<?= aem_safe_text($product['image']); ?>" alt="<?= aem_safe_text($product['name']); ?>" width="1200" height="800" fetchpriority="high">
            </div>
            <div class="product-summary">
                <span class="tag"><?= aem_safe_text($category['category']); ?></span>
                <h1><?= aem_safe_text($product['name']); ?></h1>
                <?php if (!empty($details['description'])): ?>
                    <p class="lead"><?= aem_safe_text($details['description']); ?></p>
                <?php else: ?>
                    <p class="lead"><?= aem_safe_text($product['name']); ?> is part of our <a href="<?= aem_safe_text(aem_href($category['url'])); ?>"><?= aem_safe_text($category['title']); ?></a> range. <?= aem_safe_text($category['overview']); ?></p>
                <?php endif; ?>
                <div class="product-actions">
                    <a class="btn btn-whatsapp" href="<?= aem_safe_text(aem_product_whatsapp_url($product['name'])); ?>" target="_blank" rel="noopener"><?= aem_icon_whatsapp(); ?> WhatsApp Enquiry</a>
                    <a class="btn btn-secondary" href="tel:<?= PHONE_LINK ?>">Call <?= PHONE_DISPLAY ?></a>
                </div>
                <div class="product-meta">
                    <div><strong>Category:</strong> <a href="<?= aem_safe_text(aem_href($category['url'])); ?>"><?= aem_safe_text($category['title']); ?></a></div>
                    <div><strong>Customisation:</strong> Size, material and finish made to your requirement</div>
                    <div><strong>Supply:</strong> Across India</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-alt">
        <div class="container content-grid">
            <div class="grid grid-2">
                <div class="info-panel">
                    <h2>Features &amp; Benefits</h2>
                    <ul class="check-list">
                        <?php foreach ($features as $feature): ?>
                            <li><?= aem_safe_text($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="info-panel">
                    <h2>Applications</h2>
                    <ul class="chip-list">
                        <?php foreach ($category['applications'] as $application): ?>
                            <li><?= aem_safe_text($application); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php if (!empty($details['sizes'])): ?>
                    <div class="info-panel">
                        <h2>Available Sizes</h2>
                        <ul class="check-list">
                            <?php foreach ($details['sizes'] as $size): ?>
                                <li><strong><?= aem_safe_text($size['part']); ?></strong>: <?= aem_safe_text($size['size']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <aside class="sidebar-card">
                <h3>Request a Quote</h3>
                <?php aem_enquiry_form($product['name'], 'prd'); ?>
            </aside>
        </div>
    </section>

    <?php if ($related): ?>
        <section>
            <div class="container">
                <div class="section-head-row">
                    <div class="section-header">
                        <h2>More in <?= aem_safe_text($category['title']); ?></h2>
                    </div>
                    <a class="btn btn-secondary" href="<?= aem_safe_text(aem_href($category['url'])); ?>">View All <?= count($category['products']); ?> Products</a>
                </div>
                <div class="product-grid">
                    <?php foreach ($related as $item) { aem_product_card($item); } ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php aem_cta_band('Interested in ' . aem_safe_text($product['name']) . '?', 'Message us on WhatsApp or call for details and pricing.'); ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
