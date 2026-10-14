# Aditya Enterprises (AEM) PHP Website

This project is a plain PHP 8 website for Aditya Enterprises, a steel fabrication and industrial manufacturing business based in Mandideep, near Bhopal, MP.

## Folder structure

- `index.php` – Home page
- `about-us.php` – About page
- `categories.php` / `category.php` / `product.php` – Product categories and product pages (data in `data/services.php`)
- `services.php` / `service-detail.php` – old `/services` URLs, 301 redirect to `/categories` and `/category/{slug}`
- `gallery.php` – Gallery page with lightbox
- `blog.php` – Blog listing with pagination
- `blog-detail.php` – Dynamic blog detail route
- `contact-us.php` – Contact form page
- `contact-handler.php` – Enquiry submission handler
- `privacy-policy.php` – Privacy policy
- `404.php` – Custom 404 page
- `sitemap.php` – Dynamic XML sitemap
- `.htaccess` – URL rewriting and redirects
- `includes/` – shared layout and schema helpers
- `data/` – service, gallery and blog content arrays
- `assets/css/style.css` – stylesheet
- `assets/js/main.js` – JavaScript for navigation, FAQ and gallery
- `robots.txt`, `llms.txt`, `llms-full.txt` – SEO and AI discovery files

## Configuring phone, email and location

Edit the file `includes/config.php` and update the constants as needed:

- `SITE_URL`
- `PHONE_DISPLAY`
- `PHONE_LINK`
- `WHATSAPP_NUMBER`
- `EMAIL`
- `ADDRESS_STREET`
- `ADDRESS_CITY`
- `ADDRESS_DISTRICT`
- `ADDRESS_STATE`
- `ADDRESS_PIN`
- `BUSINESS_HOURS`

## Adding a new service

Open `data/services.php` and add a new item to the array. Each service item should include:

- `slug`
- `title`
- `seo_title`
- `meta_description`
- `category`
- `short`
- `quick_answer`
- `overview`
- `products`
- `features`
- `applications`
- `faqs`
- `image`

## Adding a new blog post

Open `data/blog.php` and add another item to the main array. Include:

- `slug`
- `title`
- `meta_description`
- `category`
- `date`
- `image`
- `excerpt`
- `related_services`
- `faqs`
- `content`

## Adding images

You can use remote image URLs or add your own files in a new folder such as `assets/images`. Update the relevant data arrays or image markup to point to the correct file.

## Enabling SMTP for the contact form

The current contact form uses PHP `mail()` by default for compatibility with shared hosting. To enable SMTP, replace the `@mail(...)` call in `contact-handler.php` with a mail library or SMTP configuration suited to your hosting environment such as PHPMailer.
# adityaaem
