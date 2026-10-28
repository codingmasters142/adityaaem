<?php
// Old URL: /services is now /categories
require_once __DIR__ . '/includes/config.php';
header('Location: ' . BASE_PATH . '/categories', true, 301);
exit;
