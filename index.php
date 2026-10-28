<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/partials.php';
$categories = aem_categories();
$clients = aem_clients();
$blogs = require __DIR__ . '/data/blog.php';

$page_title = 'Steel Fabrication & Industrial Manufacturer in India | Aditya Enterprises (AEM)';
$page_description = 'Aditya Enterprises (AEM) – steel fabricator & industrial manufacturer serving customers across India. SS furniture, material handling equipment, storage racks, PEB & machining.';
$page_keywords = 'steel fabrication, industrial manufacturing, India, SS furniture, storage racks, material handling, PEB, machining';
$canonical = aem_url('');
$og_image = aem_url('assets/images/og-image.svg');
$active_nav = 'home';
$schema = organization_schema();
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="hero" style="--hero-image: url('<?= aem_clean_url('assets/images/hero-banner.jpg'); ?>');">
        <div class="container hero-inner">
            <div class="hero-copy">
                <span class="eyebrow">Manufacturing &amp; Fabrication</span>
                <h1>Leading Steel Fabrication &amp; Industrial Manufacturing Company in India</h1>
                <p>Aditya Enterprises (AEM) specializes in heavy steel fabrication, stainless steel industrial furniture, material handling equipment, storage systems, and precision machining, serving industries across India with 100% in-house manufacturing.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="<?= BASE_PATH; ?>/categories">Explore Categories <?= aem_icon_arrow(); ?></a>
                    <a class="btn btn-whatsapp" href="<?= aem_safe_text(aem_whatsapp_url()); ?>" target="_blank" rel="noopener"><?= aem_icon_whatsapp(); ?> Enquire on WhatsApp</a>
                </div>
            </div>
            <div class="hero-logo" aria-hidden="true">
                <span class="hero-ring ring-1"></span>
                <span class="hero-ring ring-2"></span>
                <span class="hero-ring ring-3"><i></i><i></i><i></i></span>
                <span class="hero-pulse"></span>
                <img src="<?= aem_clean_url(LOGO_FILE); ?>" alt="" width="259" height="242" fetchpriority="high">
            </div>
            <?php $supplyCountries = ['India', 'USA', 'Dubai (UAE)', 'United Kingdom', 'Australia', 'Singapore', 'Saudi Arabia', 'South Africa']; ?>
            <div class="supply-strip">
                <span class="supply-label">We supply to</span>
                <div class="supply-marquee">
                    <div class="supply-track">
                        <?php foreach ([false, true] as $isCopy): ?>
                            <ul class="supply-list"<?= $isCopy ? ' aria-hidden="true"' : ''; ?>>
                                <?php foreach ($supplyCountries as $country): ?>
                                    <li><?= aem_safe_text($country); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $statsVariant = in_array($_GET['stats'] ?? '', ['1', '2', '3'], true) ? $_GET['stats'] : '1'; // TEMP: ?stats=1|2|3 to compare designs ?>
    <section class="stats-strip stats-v<?= $statsVariant; ?>" aria-label="Company highlights">
        <div class="container">
            <div class="stats-grid">
                <?php $stats = [
                    ['value' => '500', 'label' => 'Product categories', 'icon' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>'],
                    ['value' => '2500+', 'label' => 'Products & services', 'icon' => '<path d="M21 8l-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8M12 13v8"/>'],
                    ['value' => '500+', 'label' => 'Valuable clients', 'icon' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.5a3.5 3.5 0 0 1 0 7M18 14a6 6 0 0 1 3.5 6"/>'],
                    ['value' => '100%', 'label' => 'In-house facility', 'icon' => '<path d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6"/>'],
                ]; ?>
                <?php foreach ($stats as $stat): ?>
                    <div class="stat">
                        <span class="stat-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><?= $stat['icon']; ?></svg></span>
                        <div>
                            <strong><?= aem_safe_text($stat['value']); ?></strong>
                            <span><?= aem_safe_text($stat['label']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section-categories">
        <div class="container">
            <div class="section-header center">
                <span class="eyebrow">What we make</span>
                <h2>Product Categories</h2>
                <p>From stainless steel lab furniture to pallet trucks, storage racks and pre-engineered buildings, we design, fabricate and finish everything under one roof.</p>
            </div>
            <div class="grid grid-3">
                <?php
                // Featured categories first, then the rest up to 6 cards (2 full rows).
                // Hidden ones are still listed on the /categories page.
                $featured = ['steel-fabrication', 'machining-work', 'tool-cabinets', 'shredding-machine', 'stainless-steel-furniture', 'teflon-products'];
                $hidden = ['polycarbonate-acrylic-products', 'plasma-coating', 'material-handling-equipment', 'rubber-coating', 'pre-engineered-buildings', 'office-furniture', 'pallets-bins-trolleys', 'storage-racks'];
                $categories = array_values(array_filter($categories, function ($c) use ($hidden) {
                    return !in_array($c['slug'], $hidden, true);
                }));
                usort($categories, function ($a, $b) use ($featured) {
                    $ia = array_search($a['slug'], $featured, true);
                    $ib = array_search($b['slug'], $featured, true);
                    return ($ia === false ? PHP_INT_MAX : $ia) <=> ($ib === false ? PHP_INT_MAX : $ib);
                });
                foreach (array_slice($categories, 0, 6) as $category) { aem_category_card($category); }
                ?>
            </div>
            <div class="section-actions">
                <a class="btn btn-secondary" href="<?= BASE_PATH; ?>/categories">View All Categories</a>
            </div>
        </div>
    </section>

    <section class="section-brand">
        <div class="container split">
            <div class="split-media">
                <img src="<?= aem_clean_url('assets/images/about-cnc-machining.jpg'); ?>" alt="CNC lathe machining at AEM" loading="lazy" width="1200" height="728">
                <div class="floating-card"><strong>100%</strong><span>In-house fabrication, machining &amp; finishing</span></div>
            </div>
            <div>
                <span class="eyebrow">About AEM</span>
                <h2>Your Dependable Steel Fabrication Partner</h2>
                <p>AEM is into the business of industrial steel fabrication with 100% in-house facility and process capabilities. We provide engineering solutions to industries such as cement, power plants, automobiles, metal construction, chemical, rubber, oil &amp; gas and architectural fabrication.</p>
                <p>Our main strength is heavy steel fabrication and supply. This includes machining and assembly of steel structures, material handling equipment and sheet metal components.</p>
                <a class="btn btn-primary" href="<?= BASE_PATH; ?>/about-us">Know More About Us</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-header center">
                <span class="eyebrow">Why AEM</span>
                <h2>Why Industries Choose Aditya Enterprises</h2>
            </div>
            <div class="grid grid-3">
                <?php $reasons = [
                    ['title' => '100% In-house Facility', 'text' => 'Fabrication, machining, finishing and assembly under one roof for better quality control and faster turnaround.', 'icon' => '<path d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6"/>'],
                    ['title' => 'Built to Your Specification', 'text' => 'We fabricate to your drawings, dimensions and material grade, in SS 304/316 or mild steel.', 'icon' => '<path d="M4 20l4-1 11-11-3-3L5 16l-1 4ZM14 7l3 3"/>'],
                    ['title' => 'Expert & Professional Team', 'text' => 'Skilled technicians and engineers oversee every project from design to installation.', 'icon' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.5a3.5 3.5 0 0 1 0 7M18 14a6 6 0 0 1 3.5 6"/>'],
                    ['title' => 'Quality You Can Inspect', 'text' => 'Conformance with client specifications and recognised standards, with continual improvement of our processes.', 'icon' => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z"/><path d="M8.5 12l2.5 2.5 4.5-5"/>'],
                    ['title' => 'Competitive Pricing', 'text' => 'Fair, transparent quotations without compromising on material or workmanship.', 'icon' => '<path d="M20 12l-8 8-9-9V3h8l9 9Z"/><circle cx="7.5" cy="7.5" r="1.5"/>'],
                    ['title' => 'On-time Delivery & Support', 'text' => 'Adherence to delivery schedules, careful packing and dependable after-sales support.', 'icon' => '<path d="M3 7h11v9H3zM14 10h4l3 3v3h-7"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>'],
                ]; ?>
                <?php foreach ($reasons as $reason): ?>
                    <div class="feature-item">
                        <div class="icon-box"><svg viewBox="0 0 24 24" aria-hidden="true"><?= $reason['icon']; ?></svg></div>
                        <h3><?= aem_safe_text($reason['title']); ?></h3>
                        <p><?= aem_safe_text($reason['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section-tint">
        <div class="container">
            <div class="section-header center">
                <span class="eyebrow">Trusted by industry</span>
                <h2>Our Valuable Clients</h2>
                <p>Leading manufacturers, food brands, banks and public-sector organisations rely on AEM for fabrication and storage solutions.</p>
            </div>
            <?php aem_client_grid(array_slice($clients, 0, 12)); ?>
            <div class="section-actions">
                <a class="btn btn-secondary" href="<?= BASE_PATH; ?>/clients">View All Clients</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-header center">
                <span class="eyebrow">Sectors</span>
                <h2>Industries We Serve</h2>
            </div>
            <ul class="chip-list" style="justify-content: center;">
                <?php foreach (['Cement', 'Power Plants', 'Automobile', 'Metal Construction', 'Chemical', 'Rubber', 'Oil & Gas', 'Food & Beverage', 'Pharmaceuticals', 'Textile & Yarn', 'Banking & Offices', 'Architectural Fabrication'] as $industry): ?>
                    <li><?= aem_safe_text($industry); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="section-tint">
        <div class="container">
            <div class="section-header center">
                <span class="eyebrow">How we work</span>
                <h2>Our Process</h2>
            </div>
            <div class="grid grid-4">
                <?php $steps = [
                    ['title' => 'Requirement & Drawing', 'text' => 'Share your requirement, drawing or sample.'],
                    ['title' => 'Design & Quotation', 'text' => 'We confirm material, dimensions and finish and send a clear quote.'],
                    ['title' => 'Fabrication & Quality Check', 'text' => 'Manufactured in-house and inspected before dispatch.'],
                    ['title' => 'Delivery & Installation', 'text' => 'Packed safely, delivered on schedule and installed where required.'],
                ]; ?>
                <?php foreach ($steps as $index => $step): ?>
                    <div class="process-step">
                        <div class="step-no"><?= $index + 1; ?></div>
                        <h3><?= aem_safe_text($step['title']); ?></h3>
                        <p><?= aem_safe_text($step['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head-row">
                <div class="section-header">
                    <span class="eyebrow">Insights</span>
                    <h2>Latest from our Blog</h2>
                </div>
                <a class="btn btn-secondary" href="<?= BASE_PATH; ?>/blog">View All Posts</a>
            </div>
            <div class="blog-grid">
                <?php foreach (array_slice($blogs, 0, 3) as $post): ?>
                    <article class="card blog-card">
                        <div class="card-media">
                            <img src="<?= aem_safe_text(aem_image_src($post['image'])); ?>" alt="<?= aem_safe_text($post['title']); ?>" loading="lazy" width="1200" height="800">
                        </div>
                        <div class="card-body">
                            <div class="meta-row">
                                <span><?= aem_safe_text($post['category']); ?></span>
                                <span aria-hidden="true">•</span>
                                <time datetime="<?= aem_safe_text($post['date']); ?>"><?= aem_safe_text($post['date']); ?></time>
                            </div>
                            <h3><a class="stretched-link" href="<?= BASE_PATH; ?>/blog/<?= aem_safe_text($post['slug']); ?>"><?= aem_safe_text($post['title']); ?></a></h3>
                            <p><?= aem_safe_text($post['excerpt']); ?></p>
                            <div class="card-footer"><span class="explore-cue" aria-hidden="true">Read more <?= aem_icon_arrow(); ?></span></div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-header center">
                <span class="eyebrow">FAQ</span>
                <h2>Frequently Asked Questions</h2>
            </div>
            <div class="faq-list center">
                <?php $faqs = [
                    ['question' => 'What does Aditya Enterprises (AEM) manufacture?', 'answer' => 'AEM manufactures stainless steel industrial furniture (lockers, work tables, lab cupboards), material handling equipment (pallet trucks, stackers, trolleys), storage racks, pallets and bins, tool cabinets, pre-engineered building structures, and offers machining, sheet metal and fabrication services.'],
                    ['question' => 'Where is Aditya Enterprises located?', 'answer' => 'Our facility is at ' . ADDRESS_FULL . ', India. We serve customers across India.'],
                    ['question' => 'Do you make custom fabrication as per drawing?', 'answer' => 'Yes. We fabricate to your drawings, sizes and material grade, including SS 304, SS 316 and mild steel with powder coating.'],
                    ['question' => 'Which industries do you serve?', 'answer' => 'Cement, power plants, automobile, chemical, rubber, oil & gas, food & beverage, pharmaceuticals, textile, banking and construction, among others.'],
                    ['question' => 'Do you supply across India?', 'answer' => 'Yes, we supply across India. Contact us with your location and requirement for a delivery estimate.'],
                    ['question' => 'How can I get a quotation?', 'answer' => 'Call or WhatsApp ' . PHONE_DISPLAY . ', email ' . EMAIL . ', or fill in the enquiry form on our Contact page.'],
                ]; ?>
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="faq-item <?= $index === 0 ? 'active' : ''; ?>">
                        <button class="faq-question" type="button" aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>">
                            <span><?= aem_safe_text($faq['question']); ?></span>
                            <span aria-hidden="true">+</span>
                        </button>
                        <div class="faq-answer"><?= aem_safe_text($faq['answer']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php aem_cta_band(); ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
