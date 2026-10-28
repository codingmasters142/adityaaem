<?php
require_once __DIR__ . '/includes/config.php';
$posts = require __DIR__ . '/data/blog.php';

$page = max(1, (int) ($_GET['page'] ?? 1));
$postsPerPage = 6;
$totalPosts = count($posts);
$totalPages = (int) ceil($totalPosts / $postsPerPage);
$page = min($page, max(1, $totalPages));
$start = ($page - 1) * $postsPerPage;
$visiblePosts = array_slice($posts, $start, $postsPerPage);

$page_title = 'Blog – Steel Fabrication & Industrial Storage Guides | AEM';
$page_description = 'Practical guides on stainless steel grades, storage racks, pallet trucks, tool cabinets and steel fabrication from the team at Aditya Enterprises.';
$page_keywords = 'industrial blog, steel fabrication guides, storage racking, pallet trucks, stainless steel';
$canonical = aem_url('blog' . ($page > 1 ? '?page=' . $page : ''));
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'Blog' => null]); ?>
            <h1>Insights &amp; Guides</h1>
            <p class="lead">Practical guidance on fabrication, storage and material handling from our workshop.</p>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <div class="blog-grid">
                <?php foreach ($visiblePosts as $post): ?>
                    <article class="card blog-card">
                        <div class="card-media"><img src="<?= htmlspecialchars(aem_image_src($post['image']), ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" width="1200" height="800"></div>
                        <div class="card-body">
                            <div class="meta-row">
                                <span><?= htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span>•</span>
                                <time datetime="<?= htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?></time>
                            </div>
                            <h3><a class="stretched-link" href="<?= BASE_PATH; ?>/blog/<?= htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></a></h3>
                            <p><?= htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="card-footer"><span class="explore-cue" aria-hidden="true">Read more <?= aem_icon_arrow(); ?></span></div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="pagination" aria-label="Blog pagination">
                <?php if ($page > 1): ?>
                    <a href="<?= BASE_PATH; ?>/blog?page=<?= $page - 1; ?>">Prev</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i === $page): ?>
                        <span class="current"><?= $i; ?></span>
                    <?php else: ?>
                        <a href="<?= BASE_PATH; ?>/blog?page=<?= $i; ?>"><?= $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="<?= BASE_PATH; ?>/blog?page=<?= $page + 1; ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
