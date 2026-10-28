<?php
// Private page: every enquiry and brochure download saved by the site. Password in includes/secrets.php.
session_start();
require_once __DIR__ . '/includes/leads.php';
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

$error = '';
if (isset($_POST['logout'])) {
    unset($_SESSION['leads_auth']);
    header('Location: ' . BASE_PATH . '/leads');
    exit;
}
if (isset($_POST['password'])) {
    $wait = 2 - (time() - (int) ($_SESSION['leads_last_try'] ?? 0)); // slow down password guessing
    if ($wait > 0) {
        sleep($wait);
    }
    $_SESSION['leads_last_try'] = time();
    if (LEADS_PASSWORD !== '' && hash_equals(LEADS_PASSWORD, (string) $_POST['password'])) {
        session_regenerate_id(true);
        $_SESSION['leads_auth'] = true;
        header('Location: ' . BASE_PATH . '/leads');
        exit;
    }
    $error = LEADS_PASSWORD === '' ? 'The leads page has no password yet. Set LEADS_PASSWORD in includes/secrets.php.' : 'Wrong password.';
}
$authed = !empty($_SESSION['leads_auth']) && LEADS_PASSWORD !== '';

$leads = $authed ? aem_read_leads() : [];
$filter = in_array($_GET['type'] ?? '', ['enquiry', 'brochure'], true) ? $_GET['type'] : '';
if ($filter) {
    $leads = array_values(array_filter($leads, function ($lead) use ($filter) {
        return $lead['type'] === $filter;
    }));
}

if ($authed && isset($_GET['csv'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="aem-leads-' . date('Y-m-d') . '.csv"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF"); // so Excel reads UTF-8
    fputcsv($out, ['Date', 'Type', 'Name', 'Phone', 'Email', 'Product / Category', 'Message', 'Page']);
    foreach ($leads as $lead) {
        $f = $lead['fields'];
        fputcsv($out, [$lead['date'], $lead['type'], $f['Name'] ?? '', $f['Phone'] ?? '', $f['Email'] ?? '', $f['Product / Category'] ?? '', $f['Message'] ?? '', $f['Page'] ?? '']);
    }
    exit;
}

$counts = ['all' => 0, 'enquiry' => 0, 'brochure' => 0];
foreach ($authed ? aem_read_leads() : [] as $lead) {
    $counts['all']++;
    $counts[$lead['type']] = ($counts[$lead['type']] ?? 0) + 1;
}
$e = 'aem_safe_text';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Leads | <?= SITE_NAME ?></title>
    <style>
        :root { --brand: #765E62; --ink: #24212A; --muted: #5F5A63; --line: #E8E3E4; --bg: #F8F4F5; }
        * { box-sizing: border-box; }
        body { margin: 0; font: 15px/1.5 system-ui, -apple-system, "Segoe UI", sans-serif; color: var(--ink); background: var(--bg); }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 24px 16px 48px; }
        header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 1.5rem; color: var(--brand); }
        .btn { display: inline-block; padding: 8px 14px; border: 1px solid var(--brand); border-radius: 8px; background: #fff; color: var(--brand); font: inherit; font-weight: 600; text-decoration: none; cursor: pointer; }
        .btn-primary { background: var(--brand); color: #fff; }
        .tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        .tabs a { padding: 6px 12px; border-radius: 999px; background: #fff; border: 1px solid var(--line); color: var(--ink); text-decoration: none; }
        .tabs a.on { background: var(--brand); border-color: var(--brand); color: #fff; }
        .lead { background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 16px 18px; margin-bottom: 12px; }
        .lead-top { display: flex; flex-wrap: wrap; gap: 8px 14px; align-items: baseline; margin-bottom: 8px; }
        .lead-top strong { font-size: 1.05rem; }
        .tag { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: 2px 8px; border-radius: 6px; background: #F1E9EA; color: var(--brand); }
        .tag.brochure { background: #E6F2EA; color: #17803F; }
        .date { color: var(--muted); font-size: .88rem; }
        dl { display: grid; grid-template-columns: max-content 1fr; gap: 4px 14px; margin: 0; }
        dt { color: var(--muted); }
        dd { margin: 0; overflow-wrap: anywhere; white-space: pre-line; }
        .empty, .login { background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 24px; }
        .login { max-width: 380px; margin: 60px auto; }
        .login input { width: 100%; padding: 10px 12px; margin: 8px 0 14px; border: 1px solid var(--line); border-radius: 8px; font: inherit; }
        .error { color: #B42318; margin: 0 0 10px; }
    </style>
</head>
<body>
<div class="wrap">
<?php if (!$authed): ?>
    <form class="login" method="post">
        <h1>Leads</h1>
        <p><?= SITE_NAME ?>: enquiries and brochure downloads.</p>
        <?php if ($error): ?><p class="error"><?= $e($error); ?></p><?php endif; ?>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required autofocus>
        <button class="btn btn-primary" type="submit">Log in</button>
    </form>
<?php else: ?>
    <header>
        <h1>Leads (<?= $counts['all']; ?>)</h1>
        <div>
            <a class="btn" href="?<?= $filter ? 'type=' . $filter . '&amp;' : ''; ?>csv=1">Download CSV</a>
            <form method="post" style="display:inline"><button class="btn" name="logout" value="1">Log out</button></form>
        </div>
    </header>
    <nav class="tabs">
        <a href="?" class="<?= $filter === '' ? 'on' : ''; ?>">All (<?= $counts['all']; ?>)</a>
        <a href="?type=enquiry" class="<?= $filter === 'enquiry' ? 'on' : ''; ?>">Enquiries (<?= $counts['enquiry']; ?>)</a>
        <a href="?type=brochure" class="<?= $filter === 'brochure' ? 'on' : ''; ?>">Brochure downloads (<?= $counts['brochure']; ?>)</a>
    </nav>
    <?php if (!$leads): ?>
        <div class="empty">No leads yet. New enquiries and brochure downloads will show up here.</div>
    <?php endif; ?>
    <?php foreach ($leads as $lead): $f = $lead['fields']; ?>
        <article class="lead">
            <div class="lead-top">
                <strong><?= $e($f['Name'] ?? '-'); ?></strong>
                <span class="tag <?= $e($lead['type']); ?>"><?= $lead['type'] === 'brochure' ? 'Brochure' : 'Enquiry'; ?></span>
                <span class="date"><?= $e(date('d M Y, h:i A', strtotime($lead['date']))); ?></span>
            </div>
            <dl>
                <?php foreach ($f as $label => $value): if ($label === 'Name' || $value === '') continue; ?>
                    <dt><?= $e($label); ?></dt>
                    <dd><?php if ($label === 'Phone'): ?><a href="tel:<?= $e(preg_replace('/[^\d+]/', '', $value)); ?>"><?= $e($value); ?></a><?php elseif ($label === 'Email'): ?><a href="mailto:<?= $e($value); ?>"><?= $e($value); ?></a><?php else: ?><?= $e($value); ?><?php endif; ?></dd>
                <?php endforeach; ?>
            </dl>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
</div>
</body>
</html>
