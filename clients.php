<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/partials.php';
$clients = aem_clients();

$page_title = 'Our Valuable Clients | Aditya Enterprises (AEM)';
$page_description = 'Aditya Enterprises (AEM) is trusted by leading companies including BHEL, ANDRITZ, Mahindra, Indian Railways, SBI, Parle and more for fabrication and storage solutions.';
$page_keywords = 'Aditya Enterprises clients, AEM clients, steel fabrication clients';
$canonical = aem_url('clients');
$active_nav = 'clients';
$schema = breadcrumb_schema(['Home' => aem_url(''), 'Our Valuable Clients' => $canonical]);
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'Our Valuable Clients' => null]); ?>
            <h1>Our Valuable Clients</h1>
            <p class="lead">Our consistent record of successful project completion has earned us the confidence of a growing list of esteemed clients across manufacturing, food &amp; beverage, banking, railways and public-sector organisations.</p>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <?php aem_client_grid($clients); ?>
        </div>
    </section>

    <?php aem_cta_band('Join our growing list of clients', 'Tell us what you need, whether it is fabrication, storage, material handling or machining.'); ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
