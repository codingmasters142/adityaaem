<?php

function render_json_ld(array $schema): void
{
    if (empty($schema)) {
        return;
    }

    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . PHP_EOL;
}

function organization_schema(): array
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => SITE_NAME,
        'url' => SITE_URL,
        'logo' => aem_url(LOGO_FILE),
        'telephone' => PHONE_LINK,
        'email' => EMAIL,
        'foundingDate' => '2008',
        'founder' => [
            ['@type' => 'Person', 'name' => 'Azad Jain'],
            ['@type' => 'Person', 'name' => 'Aditya Jain'],
        ],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => ADDRESS_STREET,
            'addressLocality' => ADDRESS_CITY,
            'addressRegion' => ADDRESS_STATE,
            'postalCode' => ADDRESS_PIN,
            'addressCountry' => ADDRESS_COUNTRY,
        ],
        'sameAs' => array_values(array_column(aem_social_links(), 'url')),
        'areaServed' => 'India',
    ];
    if (!$schema['sameAs']) {
        unset($schema['sameAs']);
    }
    return $schema;
}

function breadcrumb_schema(array $breadcrumbs): array
{
    $items = [];
    $position = 1;

    foreach ($breadcrumbs as $label => $url) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $label,
            'item' => $url,
        ];
        $position++;
    }

    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}

function faq_schema(array $items): array
{
    $questions = [];
    foreach ($items as $entry) {
        $questions[] = [
            '@type' => 'Question',
            'name' => $entry['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $entry['answer'],
            ],
        ];
    }

    return [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $questions,
    ];
}

function service_schema(array $service): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'serviceType' => $service['title'],
        'provider' => organization_schema(),
        'areaServed' => 'India',
        'description' => $service['meta_description'],
        'url' => aem_url('category/' . $service['slug']),
    ];
}

function article_schema(array $post): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post['title'],
        'description' => $post['meta_description'],
        'datePublished' => $post['date'],
        'author' => [
            '@type' => 'Organization',
            'name' => SITE_NAME,
        ],
        'publisher' => organization_schema(),
        'mainEntityOfPage' => aem_url('blog/' . $post['slug']),
    ];
}
