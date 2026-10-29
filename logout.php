<?php
require_once __DIR__ . '/CRM/config/auth.php';

// Clear the CRM session cookie with the same attributes it was set with.
setcookie('token', '', crm_cookie_options(time() - 3600));
header('Location: CRM/index.html');
exit();
