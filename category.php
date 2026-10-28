<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/partials.php';

$category = aem_category($_GET['slug'] ?? '');
if (!$category) {
    require __DIR__ . '/404.php';
    exit;
}
aem_csrf_token(); // start the session before any output

$categoryUrl = aem_url(ltrim($category['url'], '/'));
$page_title = $category['seo_title'];
$page_description = $category['meta_description'];
$page_keywords = implode(', ', array_merge([$category['title']], array_slice($category['product_names'], 0, 8)));
$canonical = $categoryUrl;
$og_image = aem_absolute_image($category['image']);
$active_nav = 'categories';
$position = 0;
$schema = [
    breadcrumb_schema(['Home' => aem_url(''), 'Categories' => aem_url('categories'), $category['title'] => $categoryUrl]),
    [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $category['title'],
        'description' => $category['meta_description'],
        'url' => $categoryUrl,
        'provider' => organization_schema(),
        'mainEntity' => [
            '@type' => 'ItemList',
            'itemListElement' => array_values(array_map(function ($product) use (&$position) {
                return [
                    '@type' => 'ListItem',
                    'position' => ++$position,
                    'name' => $product['name'],
                    'url' => aem_url(ltrim($product['url'], '/')),
                ];
            }, $category['products'])),
        ],
    ],
];
if (!empty($category['faqs'])) {
    $schema[] = faq_schema($category['faqs']);
}
$otherCategories = array_slice(array_filter(aem_categories(), function ($item) use ($category) {
    return $item['slug'] !== $category['slug'];
}), 0, 3);

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container category-hero">
            <div>
                <?= aem_breadcrumbs(['Home' => '/', 'Categories' => '/categories', $category['title'] => null]); ?>
                <h1><?= aem_safe_text($category['title']); ?></h1>
                <p class="lead"><?= aem_safe_text($category['quick_answer']); ?></p>
                <div class="page-hero-actions">
                    <a class="btn btn-primary" href="#products">View <?= count($category['products']); ?> Products</a>
                    <a class="btn btn-whatsapp" href="<?= aem_safe_text(aem_product_whatsapp_url($category['title'])); ?>" target="_blank" rel="noopener"><?= aem_icon_whatsapp(); ?> Enquire on WhatsApp</a>
                </div>
            </div>
            <div class="category-hero-media">
                <img src="<?= aem_safe_text($category['image']); ?>" alt="<?= aem_safe_text($category['title']); ?>" width="1200" height="800" fetchpriority="high">
            </div>
        </div>
    </section>

    <section class="page-content" id="products">
        <div class="container">
            <div class="toolbar">
                <div class="section-header" style="margin-bottom: 0;">
                    <h2>Products in <?= aem_safe_text($category['title']); ?></h2>
                    <p><?= aem_safe_text($category['overview']); ?></p>
                </div>
                <p class="result-count"><?= count($category['products']); ?> products</p>
            </div>
            <div class="product-grid">
                <?php foreach ($category['products'] as $product) { aem_product_card($product); } ?>
            </div>
        </div>
    </section>

    <section class="section-alt">
        <div class="container content-grid">
            <div>
                <div class="grid grid-2" style="margin-bottom: 32px;">
                    <div class="info-panel">
                        <h2>Features &amp; Benefits</h2>
                        <ul class="check-list">
                            <?php foreach ($category['features'] as $feature): ?>
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
                </div>

                <?php if (!empty($category['faqs'])): ?>
                    <h2>Frequently Asked Questions</h2>
                    <div class="faq-list">
                        <?php foreach ($category['faqs'] as $index => $faq): ?>
                            <div class="faq-item <?= $index === 0 ? 'active' : ''; ?>">
                                <button class="faq-question" type="button" aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>">
                                    <span><?= aem_safe_text($faq['question']); ?></span>
                                    <span aria-hidden="true">+</span>
                                </button>
                                <div class="faq-answer"><?= aem_safe_text($faq['answer']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="sidebar-card">
                <h3>Quick Enquiry</h3>
                <?php aem_enquiry_form($category['title'], 'cat'); ?>
                <div class="sidebar-actions">
                    <a class="btn btn-secondary" href="tel:<?= PHONE_LINK ?>">Call <?= PHONE_DISPLAY ?></a>
                </div>
            </aside>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head-row">
                <div class="section-header">
                    <h2>Explore Other Categories</h2>
                </div>
                <a class="btn btn-secondary" href="<?= BASE_PATH; ?>/categories">All Categories</a>
            </div>
            <div class="category-grid">
                <?php foreach ($otherCategories as $item) { aem_category_card($item); } ?>
            </div>
        </div>
    </section>

    <?php aem_cta_band('Need help with ' . aem_safe_text($category['title']) . '?', 'Share your requirement, drawing or quantity and get a quick quotation.'); ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
