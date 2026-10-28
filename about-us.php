<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/partials.php';
$categories = aem_categories();
$clients = aem_clients();

$page_title = 'About Aditya Enterprises (AEM) | Steel Fabrication Company in India';
$page_description = 'Learn about Aditya Enterprises (AEM), a fast-growing steel fabrication company with a 100% in-house facility serving cement, power, automobile and other industries across India.';
$page_keywords = 'about Aditya Enterprises, AEM, steel fabrication company India, industrial steel fabrication';
$canonical = aem_url('about-us');
$active_nav = 'about';
$schema = [
    breadcrumb_schema(['Home' => aem_url(''), 'About Us' => $canonical]),
    [
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        'name' => 'About Aditya Enterprises',
        'url' => $canonical,
        'mainEntity' => organization_schema(),
    ],
];
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container">
            <?= aem_breadcrumbs(['Home' => '/', 'About Us' => null]); ?>
            <h1>About Us</h1>
            <p class="lead">Aditya Enterprises (AEM) is a manufacturing and fabrication company that Indian industry can count on.</p>
        </div>
    </section>

    <section class="page-content">
        <div class="container split">
            <div>
                <span class="eyebrow">Who we are</span>
                <h2>Industrial Steel Fabrication with a 100% In-house Facility</h2>
                <p>AEM is into the business of industrial steel fabrication with 100% in-house facility and process capabilities. Aditya Enterprises is one of the leading and fast-growing steel fabrication companies, providing engineering solutions to industries such as cement, power plants, automobiles, metal construction, chemical, rubber, oil &amp; gas and architectural fabrication.</p>
                <p>Our team consists of highly skilled and experienced professionals dedicated to precision, innovation and efficiency. From designing systems to executing and managing projects, our team ensures excellence at every stage.</p>
                <ul class="trust-row">
                    <li>Expert &amp; Professional</li>
                    <li>Professional Approach</li>
                    <li>Satisfaction Guarantee</li>
                </ul>
            </div>
            <div class="split-media">
                <img src="<?= aem_clean_url('assets/images/about-sheet-metal-work.jpg'); ?>" alt="Steel fabrication work at AEM" width="905" height="506" fetchpriority="high">
                <div class="floating-card"><strong><?= count($categories); ?> categories</strong><span><?= aem_product_count(); ?>+ products &amp; services</span></div>
            </div>
        </div>
    </section>

    <section class="section-alt" id="founders">
        <div class="container">
            <div class="section-header center">
                <span class="eyebrow">Leadership</span>
                <h2>Meet Our Founders</h2>
                <p>The people behind Aditya Enterprises, who guide every project from the first drawing to the final delivery.</p>
            </div>
            <div class="founder-grid">
                <article class="founder-card">
                    <div class="founder-photo">
                        <img src="<?= aem_clean_url('assets/images/founders/azad-jain.jpg'); ?>" alt="Mr. Azad Jain, Founder of Aditya Enterprises" width="603" height="754" loading="lazy">
                    </div>
                    <div class="founder-body">
                        <h3>Mr. Azad Jain</h3>
                        <span class="founder-role">Founder</span>
                        <span class="founder-degree">Established AEM in 2008</span>
                        <p>Mr. Azad Jain founded Aditya Enterprises in 2008 and built it on a simple promise: honest work, sound engineering and on-time delivery. His hands-on experience in steel fabrication shapes the quality standards the company follows today.</p>
                    </div>
                </article>
                <article class="founder-card">
                    <div class="founder-photo">
                        <img src="<?= aem_clean_url('assets/images/founders/aditya-jain.jpg'); ?>" alt="Aditya Jain, Co-Founder of Aditya Enterprises" width="603" height="754" loading="lazy">
                    </div>
                    <div class="founder-body">
                        <h3>Aditya Jain</h3>
                        <span class="founder-role">Co-Founder</span>
                        <span class="founder-degree">B.Tech, Mechanical Engineering</span>
                        <p>Aditya Jain, a mechanical engineer by training, leads day-to-day operations and customer relationships at AEM. He works closely with clients to understand their requirements and makes sure every order is built to drawing and delivered on schedule.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="grid grid-2">
                <div class="info-panel">
                    <h2>Our Core Competency</h2>
                    <p>Our core competency lies in heavy steel fabrication and supply, including:</p>
                    <ul class="check-list">
                        <li>Machining and assembly of steel structures</li>
                        <li>Material handling equipment</li>
                        <li>Sheet metal works and sheet metal components</li>
                        <li>Stainless steel industrial and laboratory furniture</li>
                        <li>Storage racks, pallets, bins and trolleys</li>
                        <li>Pre-engineered building (PEB) structures</li>
                    </ul>
                </div>
                <div class="info-panel">
                    <h2>Our Strengths</h2>
                    <ul class="check-list cols-2">
                        <li>Compliance with client specifications</li>
                        <li>Setting new quality standards</li>
                        <li>Surpassing client expectations</li>
                        <li>Conformance with international standards</li>
                        <li>Constant upgradation of processes and infrastructure</li>
                        <li>Competent production team</li>
                        <li>Efficient project management</li>
                        <li>Competitive pricing</li>
                        <li>Adherence to delivery schedules</li>
                        <li>Innovative packing and assembly practices</li>
                        <li>Continual improvement</li>
                        <li>Unwavering support service</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section-alt">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">Product range</span>
                <h2>What We Manufacture</h2>
                <p>Have a look at our product categories. Everything is made in our own workshop and can be built to your drawing.</p>
            </div>
            <div class="category-grid">
                <?php foreach ($categories as $category) { aem_category_card($category); } ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="grid grid-3" style="margin-bottom: 40px;">
                <div class="feature-item">
                    <div class="icon-box"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/></svg></div>
                    <h3>Our Vision</h3>
                    <p>To be a trusted name in turnkey engineering, known for quality, honesty and fresh thinking, and to build long relationships with our customers based on trust.</p>
                </div>
                <div class="feature-item">
                    <div class="icon-box"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></svg></div>
                    <h3>Our Mission</h3>
                    <p>Deliver high-quality products and services at fair pricing with timely execution, creating a sustainable and technologically advanced future by continuously exceeding industry standards.</p>
                </div>
                <div class="feature-item">
                    <div class="icon-box"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></svg></div>
                    <h3>Our Commitment</h3>
                    <p>Our technical staff oversees project execution and management, ensuring smooth operations and timely delivery, backed by a commitment to quality, professionalism and customer satisfaction.</p>
                </div>
            </div>

            <div class="info-panel">
                <h2>Key Facts</h2>
                <table class="facts-table">
                    <tbody>
                        <tr><th scope="row">Company</th><td>Aditya Enterprises</td></tr>
                        <tr><th scope="row">Short name</th><td>AEM</td></tr>
                        <tr><th scope="row">Established</th><td>2008</td></tr>
                        <tr><th scope="row">Business type</th><td>Manufacturer &amp; Fabricator (Industrial Steel)</td></tr>
                        <tr><th scope="row">Facility</th><td>100% in-house fabrication, machining &amp; finishing</td></tr>
                        <tr><th scope="row">Service area</th><td>Customers across India</td></tr>
                        <tr><th scope="row">Address</th><td><?= ADDRESS_FULL ?>, India</td></tr>
                        <tr><th scope="row">Materials</th><td>Stainless steel (SS 304/316), mild steel, aluminium, polycarbonate/acrylic</td></tr>
                        <tr><th scope="row">Industries</th><td>Cement, Power, Automobile, Chemical, Rubber, Oil &amp; Gas, Food, Pharma, Textile</td></tr>
                        <tr><th scope="row">Phone / WhatsApp</th><td><a href="tel:<?= PHONE_LINK ?>"><?= PHONE_DISPLAY ?></a></td></tr>
                        <tr><th scope="row">Email</th><td><a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="section-alt" id="clients">
        <div class="container">
            <div class="section-head-row">
                <div class="section-header">
                    <span class="eyebrow">Trusted by industry</span>
                    <h2>Our Valuable Clients</h2>
                    <p>Our consistent record of successful project completion has earned us the confidence of a growing list of esteemed clients.</p>
                </div>
            </div>
            <?php aem_client_grid($clients); ?>
        </div>
    </section>

    <?php aem_cta_band(); ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
