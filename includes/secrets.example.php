<?php
// Copy this file to includes/secrets.php and fill in the values.
// secrets.php is ignored by git, so these passwords never reach GitHub.

// Mailbox the lead emails are sent from (create it in Hostinger: Emails -> Email Accounts).
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_PORT', 465);
define('SMTP_USER', 'info@adityaaem.in');
define('SMTP_PASS', 'your-mailbox-password');

// Password for the https://adityaaem.in/leads page (use a long one).
define('LEADS_PASSWORD', 'choose-a-long-password');
