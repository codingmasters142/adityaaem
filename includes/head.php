<?php
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/schema.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="<?= htmlspecialchars($robots ?? 'index,follow', ENT_QUOTES, 'UTF-8'); ?>">
    <title><?= htmlspecialchars($page_title ?? SITE_NAME, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="keywords" content="<?= htmlspecialchars($page_keywords ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title ?? SITE_NAME, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($canonical ?? SITE_URL, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?= htmlspecialchars($og_image ?? aem_url('assets/images/og-image.svg'), ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title ?? SITE_NAME, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($page_description ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($og_image ?? aem_url('assets/images/og-image.svg'), ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical ?? SITE_URL, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= aem_clean_url(LOGO_FILE); ?>">
    <link rel="apple-touch-icon" href="<?= aem_clean_url(LOGO_FILE); ?>">
    <meta name="theme-color" content="#8C7377">
    <script>
        // Page loader: only on the first page of a visit (per browser tab session).
        (function () {
            var root = document.documentElement;
            try {
                if (sessionStorage.getItem('aem_loader_seen')) { return; }
                sessionStorage.setItem('aem_loader_seen', '1');
            } catch (e) { return; }
            root.classList.add('show-loader');
            var start = Date.now();
            function hide() { root.classList.add('loader-done'); }
            window.addEventListener('load', function () {
                setTimeout(hide, Math.max(0, 700 - (Date.now() - start))); // show at least 0.7s so it doesn't just flicker
            });
            setTimeout(hide, 6000); // never block the page for long on a slow connection
        })();
    </script>
    <link rel="stylesheet" href="<?= aem_clean_url('assets/css/style.css'); ?>?v=<?= filemtime(__DIR__ . '/../assets/css/style.css'); ?>">
    <script defer src="<?= aem_clean_url('assets/js/main.js'); ?>?v=<?= filemtime(__DIR__ . '/../assets/js/main.js'); ?>"></script>
    <?php if (!empty($schema)) { render_json_ld($schema); } ?>
</head>
<body>
<div class="page-loader" aria-hidden="true">
    <div class="page-loader-mark">
        <span class="page-loader-ring"></span>
        <img src="<?= aem_clean_url(LOGO_FILE); ?>" alt="" width="96" height="90">
    </div>
</div>
<a class="skip-link" href="#main-content">Skip to content</a>
