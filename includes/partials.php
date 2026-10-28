<?php
require_once __DIR__ . '/catalog.php';
require_once __DIR__ . '/schema.php';

function aem_category_card(array $category, $headingTag = 'h3')
{
    $url = aem_safe_text(aem_href($category['url']));
    $count = count($category['products']);
    ?>
    <article class="card category-card" data-category="<?= aem_safe_text($category['category']); ?>">
        <div class="card-media">
            <img src="<?= aem_safe_text($category['image']); ?>" alt="<?= aem_safe_text($category['title']); ?>" loading="lazy" width="800" height="600">
            <span class="media-badge"><?= $count; ?> <?= $count === 1 ? 'product' : 'products'; ?></span>
        </div>
        <div class="card-body">
            <span class="tag"><?= aem_safe_text($category['category']); ?></span>
            <<?= $headingTag; ?>><a class="stretched-link" href="<?= $url; ?>"><?= aem_safe_text($category['title']); ?></a></<?= $headingTag; ?>>
            <p><?= aem_safe_text($category['short']); ?></p>
            <div class="card-footer">
                <span class="explore-cue" aria-hidden="true">Explore category <?= aem_icon_arrow(); ?></span>
            </div>
        </div>
    </article>
    <?php
}

// Gallery tiles: each item needs 'src' (ready to output), 'title' and optional 'category'.
function aem_gallery_grid(array $items, $filterable = false)
{
    ?>
    <div class="gallery-grid"<?= $filterable ? ' data-filter-grid' : ''; ?>>
        <?php foreach ($items as $item): ?>
            <figure class="gallery-card" data-gallery-item data-src="<?= aem_safe_text($item['src']); ?>" data-title="<?= aem_safe_text($item['title']); ?>"<?= isset($item['category']) ? ' data-category="' . aem_safe_text($item['category']) . '"' : ''; ?>>
                <img src="<?= aem_safe_text($item['src']); ?>" alt="<?= aem_safe_text($item['title']); ?>" loading="lazy" width="800" height="800">
                <figcaption><?= aem_safe_text($item['title']); ?></figcaption>
            </figure>
        <?php endforeach; ?>
    </div>
    <?php
}

function aem_gallery_lightbox()
{
    ?>
    <div class="gallery-lightbox" aria-modal="true" role="dialog">
        <div class="lightbox-inner">
            <button class="lightbox-close" type="button" aria-label="Close gallery" data-lightbox-close>&times;</button>
            <div class="lightbox-controls">
                <button type="button" aria-label="Previous image" data-lightbox-prev>&#8249;</button>
                <button type="button" aria-label="Next image" data-lightbox-next>&#8250;</button>
            </div>
            <img src="" alt="" data-lightbox-image>
            <div class="lightbox-caption" data-lightbox-caption></div>
        </div>
    </div>
    <?php
}

function aem_product_card(array $product, $headingTag = 'h3')
{
    ?>
    <article class="card product-card">
        <div class="card-media">
            <img src="<?= aem_safe_text($product['image']); ?>" alt="<?= aem_safe_text($product['name']); ?>" loading="lazy" width="800" height="600">
        </div>
        <div class="card-body">
            <<?= $headingTag; ?>><a class="stretched-link" href="<?= aem_safe_text(aem_href($product['url'])); ?>"><?= aem_safe_text($product['name']); ?></a></<?= $headingTag; ?>>
            <p><?= aem_safe_text($product['category_title']); ?></p>
            <div class="card-footer">
                <a class="btn btn-whatsapp btn-sm" href="<?= aem_safe_text(aem_product_whatsapp_url($product['name'])); ?>" target="_blank" rel="noopener" aria-label="Enquire about <?= aem_safe_text($product['name']); ?> on WhatsApp">
                    <?= aem_icon_whatsapp(); ?> WhatsApp Enquiry
                </a>
            </div>
        </div>
    </article>
    <?php
}

function aem_client_grid(array $clients)
{
    ?>
    <ul class="client-grid" role="list">
        <?php foreach ($clients as $client): ?>
            <li class="client-card">
                <?php if ($client['logo']): ?>
                    <img src="<?= aem_safe_text(aem_clean_url($client['logo'])); ?>" alt="<?= aem_safe_text($client['name']); ?> logo" loading="lazy" width="140" height="56">
                <?php else: ?>
                    <span class="client-name"><?= aem_safe_text($client['name']); ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
}

function aem_cta_band($title = 'Have a requirement? Let&apos;s build it.', $text = 'Share your drawing or requirement and get a quick quotation.')
{
    ?>
    <section>
        <div class="container">
            <div class="cta-band">
                <div class="cta-inner">
                    <div>
                        <h2><?= $title; ?></h2>
                        <p><?= $text; ?></p>
                    </div>
                    <div class="cta-actions">
                        <a class="btn btn-primary" href="<?= aem_safe_text(aem_whatsapp_url()); ?>" target="_blank" rel="noopener"><?= aem_icon_whatsapp(); ?> Enquire on WhatsApp</a>
                        <a class="btn btn-secondary" href="tel:<?= PHONE_LINK ?>">Call <?= PHONE_DISPLAY ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}

function aem_enquiry_form($subject, $idPrefix = 'enq')
{
    $p = aem_safe_text($idPrefix);
    ?>
    <form action="<?= BASE_PATH; ?>/contact-handler.php" method="post">
        <input type="hidden" name="csrf" value="<?= aem_safe_text(aem_csrf_token()); ?>">
        <input type="hidden" name="service" value="<?= aem_safe_text($subject); ?>">
        <div class="honeypot">
            <label for="<?= $p; ?>-website">Leave this empty</label>
            <input id="<?= $p; ?>-website" name="website" type="text" tabindex="-1" autocomplete="off">
        </div>
        <div class="form-field">
            <label for="<?= $p; ?>-name">Name</label>
            <input id="<?= $p; ?>-name" name="name" type="text" autocomplete="name" required>
        </div>
        <div class="form-field">
            <label for="<?= $p; ?>-phone">Phone</label>
            <input id="<?= $p; ?>-phone" name="phone" type="tel" autocomplete="tel" required>
        </div>
        <div class="form-field">
            <label for="<?= $p; ?>-email">Email</label>
            <input id="<?= $p; ?>-email" name="email" type="email" autocomplete="email" required>
        </div>
        <div class="form-field">
            <label for="<?= $p; ?>-message">Requirement</label>
            <textarea id="<?= $p; ?>-message" name="message" required>Interested in <?= aem_safe_text($subject); ?>.</textarea>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Send Enquiry</button>
    </form>
    <?php
}
