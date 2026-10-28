<?php
require_once __DIR__ . '/includes/catalog.php';
$posts = require __DIR__ . '/data/blog.php';

$urls = [
    '/',
    '/about-us',
    '/categories',
    '/clients',
    '/gallery',
    '/blog',
    '/contact-us',
    '/privacy-policy',
];

foreach (aem_categories() as $category) {
    $urls[] = $category['url'];
    foreach ($category['products'] as $product) {
        $urls[] = $product['url'];
    }
}
foreach ($posts as $post) {
    $urls[] = '/blog/' . $post['slug'];
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
foreach (array_unique($urls) as $path) {
    echo '  <url><loc>' . htmlspecialchars(rtrim(SITE_URL . $path, '/'), ENT_QUOTES, 'UTF-8') . '</loc></url>' . PHP_EOL;
}
echo '</urlset>' . PHP_EOL;
