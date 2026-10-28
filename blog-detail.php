<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/catalog.php';
require_once __DIR__ . '/includes/schema.php';
$posts = require __DIR__ . '/data/blog.php';
$services = require __DIR__ . '/data/services.php';

$slug = $_GET['slug'] ?? '';
$post = null;
foreach ($posts as $entry) {
    if ($entry['slug'] === $slug) {
        $post = $entry;
        break;
    }
}

if (!$post) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$relatedPosts = array_filter($posts, function ($item) use ($post) {
    return $item['slug'] !== $post['slug'];
});
$relatedPosts = array_slice($relatedPosts, 0, 3);

preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $post['content'], $headings);
$toc = [];
foreach ($headings[1] as $heading) {
    $toc[] = trim(strip_tags($heading));
}

$page_title = $post['title'];
$page_description = $post['meta_description'];
$page_keywords = $post['category'];
$canonical = aem_url('blog/' . $post['slug']);
$schema = article_schema($post);
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'Blog' => '/blog', $post['title'] => null]); ?>
            <h1><?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="meta-row">
                <span><?= htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span>•</span>
                <time datetime="<?= htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?></time>
                <span>•</span>
                <span><?= max(1, (int) round(str_word_count(strip_tags($post['content'])) / 200)); ?> min read</span>
            </div>
        </div>
    </section>

    <section class="page-content">
        <div class="container content-grid">
            <article class="prose">
                <img src="<?= htmlspecialchars(aem_image_src($post['image']), ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($post['image_alt'] ?? $post['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" width="1200" height="800">
                <?= str_replace('href="/', 'href="' . BASE_PATH . '/', $post['content']); // site-relative links work in the localhost subfolder too ?>

                <?php if (!empty($post['faqs'])): ?>
                    <h2>FAQs</h2>
                    <div class="faq-list">
                        <?php foreach ($post['faqs'] as $index => $faq): ?>
                            <div class="faq-item <?= $index === 0 ? 'active' : ''; ?>">
                                <button class="faq-question" type="button">
                                    <span><?= htmlspecialchars($faq['question'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span>+</span>
                                </button>
                                <div class="faq-answer"><?= htmlspecialchars($faq['answer'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <aside class="sidebar-card">
                <h3>Table of Contents</h3>
                <ul>
                    <?php foreach ($toc as $heading): ?>
                        <li><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
                <div style="margin-top: 20px; display: grid; gap: 10px;">
                    <a class="btn btn-secondary" href="<?= aem_safe_text(aem_whatsapp_url('I would like to discuss ' . $post['title'])); ?>" target="_blank" rel="noopener">Share on WhatsApp</a>
                    <a class="btn btn-secondary" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= rawurlencode(aem_url('blog/' . $post['slug'])); ?>" target="_blank" rel="noopener">Share on LinkedIn</a>
                    <a class="btn btn-secondary" href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode(aem_url('blog/' . $post['slug'])); ?>" target="_blank" rel="noopener">Share on Facebook</a>
                    <button class="btn btn-secondary" type="button" onclick="navigator.clipboard.writeText(location.href)">Copy Link</button>
                </div>
                <div style="margin-top: 20px;">
                    <h3>Related categories</h3>
                    <?php foreach ($post['related_services'] as $slug): ?>
                        <?php $service = null; foreach ($services as $candidate) { if ($candidate['slug'] === $slug) { $service = $candidate; break; } } ?>
                        <?php if ($service): ?>
                            <p><a href="<?= BASE_PATH; ?>/category/<?= htmlspecialchars($service['slug'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8'); ?></a></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </aside>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-header">
                <h2>Related posts</h2>
            </div>
            <div class="blog-grid">
                <?php foreach ($relatedPosts as $related): ?>
                    <article class="card blog-card">
                        <div class="card-media"><img src="<?= htmlspecialchars(aem_image_src($related['image']), ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($related['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" width="1200" height="800"></div>
                        <div class="card-body">
                            <div class="meta-row">
                                <span><?= htmlspecialchars($related['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span>•</span>
                                <time datetime="<?= htmlspecialchars($related['date'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($related['date'], ENT_QUOTES, 'UTF-8'); ?></time>
                            </div>
                            <h3><a class="stretched-link" href="<?= BASE_PATH; ?>/blog/<?= htmlspecialchars($related['slug'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($related['title'], ENT_QUOTES, 'UTF-8'); ?></a></h3>
                            <p><?= htmlspecialchars($related['excerpt'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="card-footer"><span class="explore-cue" aria-hidden="true">Read more <?= aem_icon_arrow(); ?></span></div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
