<?php
require_once __DIR__ . '/config.php';

/**
 * Product categories (from data/services.php) with each product name expanded
 * into a record that has its own slug, URL and image.
 *
 * To give a product its own photo, add to its category in data/services.php:
 *   'product_images' => ['Pallet Truck' => 'assets/images/products/pallet-truck.jpg'],
 */
function aem_categories()
{
    static $categories = null;
    if ($categories !== null) {
        return $categories;
    }

    $raw = require __DIR__ . '/../data/services.php';
    $gallery = require __DIR__ . '/../data/gallery.php';
    $categories = [];

    foreach ($raw as $category) {
        $products = [];
        foreach ($category['products'] as $name) {
            $slug = aem_slugify($name);
            $products[$slug] = [
                'name' => $name,
                'slug' => $slug,
                'image' => aem_image_src($category['product_images'][$name] ?? aem_gallery_image_for($name, $gallery) ?: $category['image']),
                'category_slug' => $category['slug'],
                'category_title' => $category['title'],
                'url' => '/category/' . $category['slug'] . '/' . $slug,
                'details' => $category['product_details'][$name] ?? [],
            ];
        }
        $category['image'] = aem_image_src($category['image']);
        $category['product_names'] = $category['products'];
        $category['products'] = $products;
        $category['url'] = '/category/' . $category['slug'];
        $categories[$category['slug']] = $category;
    }

    return $categories;
}

// Local image paths (assets/...) get the site folder prefix; full URLs pass through.
function aem_image_src($src)
{
    return preg_match('#^(https?:)?//#', (string) $src) ? $src : aem_clean_url($src);
}

// Absolute URL of an image returned by aem_image_src() (for og:image and schema).
function aem_absolute_image($src)
{
    $src = (string) $src;
    if (preg_match('#^(https?:)?//#', $src)) {
        return $src;
    }
    return aem_url(BASE_PATH !== '' && strpos($src, BASE_PATH . '/') === 0 ? substr($src, strlen(BASE_PATH)) : $src);
}

function aem_category($slug)
{
    $categories = aem_categories();
    return $categories[(string) $slug] ?? null;
}

function aem_product_count()
{
    $total = 0;
    foreach (aem_categories() as $category) {
        $total += count($category['products']);
    }
    return $total;
}

// Use a gallery photo when its title clearly names the same product.
function aem_gallery_image_for($productName, array $gallery)
{
    $needle = aem_slugify($productName);
    foreach ($gallery as $item) {
        $title = aem_slugify($item['title']);
        if ($title === $needle || strpos($title, $needle) !== false) {
            return $item['image'];
        }
    }
    return null;
}

function aem_clients()
{
    $clients = require __DIR__ . '/../data/clients.php';
    foreach ($clients as &$client) {
        $client['logo'] = null;
        foreach (['svg', 'png', 'webp', 'jpg'] as $ext) {
            $file = 'assets/images/clients/' . aem_slugify($client['name']) . '.' . $ext;
            if (is_file(__DIR__ . '/../' . $file)) {
                $client['logo'] = $file;
                break;
            }
        }
    }
    return $clients;
}
