<?php
require_once __DIR__ . '/catalog.php';

$navItems = [
    'home' => ['label' => 'Home', 'url' => '/'],
    'about' => ['label' => 'About Us', 'url' => '/about-us'],
    'categories' => ['label' => 'Categories', 'url' => '/categories', 'sub' => aem_categories(), 'all' => 'View all categories'],
    'gallery' => ['label' => 'Gallery', 'url' => '/gallery'],
    'contact' => ['label' => 'Contact Us', 'url' => '/contact-us'],
];
$active_nav = $active_nav ?? '';
?>
<header class="site-header">
    <div class="topbar">
        <div class="container topbar-inner">
            <span class="topbar-note">Serving Customers Across the World</span>
            <div class="topbar-links">
                <a href="tel:<?= PHONE_LINK ?>"><?= PHONE_DISPLAY ?></a>
                <a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a>
                <?= aem_social_list('social-links social-links-top'); ?>
            </div>
        </div>
    </div>
    <div class="container nav-wrap">
        <a href="<?= BASE_PATH; ?>/" class="brand" aria-label="Aditya Enterprises home">
            <img class="brand-logo" src="<?= aem_clean_url(LOGO_FILE); ?>" alt="Aditya Enterprises (AEM) logo" width="52" height="52">
            <span class="brand-text">
                <span class="brand-name">Aditya Enterprises</span>
                <span class="brand-sub">Steel Fabrication &amp; Manufacturing</span>
            </span>
        </a>

        <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="main-nav">
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav" id="main-nav" aria-label="Main navigation">
            <div class="nav-drawer-head">
                <a href="<?= BASE_PATH; ?>/" class="brand" aria-label="Aditya Enterprises home">
                    <img class="brand-logo" src="<?= aem_clean_url(LOGO_FILE); ?>" alt="" width="44" height="44">
                    <span class="brand-text">
                        <span class="brand-name">Aditya Enterprises</span>
                        <span class="brand-sub">Steel Fabrication &amp; Manufacturing</span>
                    </span>
                </a>
                <button class="nav-close" type="button" aria-label="Close menu" data-nav-close>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                </button>
            </div>
            <ul>
                <?php foreach ($navItems as $key => $item): ?>
                    <?php if (!empty($item['sub'])): ?>
                        <li class="has-sub">
                            <a href="<?= aem_safe_text(aem_href($item['url'])); ?>"<?= $key === $active_nav ? ' class="active"' : ''; ?>><?= aem_safe_text($item['label']); ?></a>
                            <button class="sub-toggle" type="button" aria-expanded="false" aria-controls="<?= $key; ?>-submenu" aria-label="Show <?= aem_safe_text(strtolower($item['label'])); ?>">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <div class="submenu" id="<?= $key; ?>-submenu">
                                <?php
                                $subGroups = [];
                                foreach ($item['sub'] as $subItem) {
                                    $subGroups[$subItem['category'] ?? 'More'][] = $subItem;
                                }
                                ?>
                                <div class="submenu-groups">
                                    <?php foreach ($subGroups as $subGroupName => $subGroupItems): ?>
                                        <div class="submenu-group">
                                            <span class="submenu-heading"><?= aem_safe_text($subGroupName); ?></span>
                                            <ul>
                                                <?php foreach ($subGroupItems as $subItem): ?>
                                                    <li><a href="<?= aem_safe_text(aem_href($subItem['url'])); ?>"><?= aem_safe_text($subItem['title']); ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a class="submenu-all" href="<?= aem_safe_text(aem_href($item['url'])); ?>"><?= aem_safe_text($item['all']); ?> <?= aem_icon_arrow(); ?></a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= aem_safe_text(aem_href($item['url'])); ?>"<?= $key === $active_nav ? ' class="active" aria-current="page"' : ''; ?>><?= aem_safe_text($item['label']); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <a class="btn btn-primary btn-nav" href="<?= aem_clean_url(BROCHURE_FILE); ?>" download="<?= aem_safe_text(BROCHURE_DOWNLOAD_NAME); ?>" data-brochure-open>
                <?= aem_icon_download(); ?>
                Download Brochure
            </a>
        </nav>
    </div>
</header>
