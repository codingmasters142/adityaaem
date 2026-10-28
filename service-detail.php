<?php
// Old URLs: /services/{slug} now live under /category/{slug}
require_once __DIR__ . '/includes/catalog.php';
$slug = (string) ($_GET['slug'] ?? '');
$moved = ['machining-items' => 'machining-work']; // services that were merged into an existing category
$category = aem_category($moved[$slug] ?? $slug);
if (!$category) {
    require __DIR__ . '/404.php';
    exit;
}
header('Location: ' . aem_href($category['url']), true, 301);
exit;
