<?php
// Admin: change a lead (assign). Logic and validation: shared/lead_update.php
require_once __DIR__ . '/../../config/auth.php';
crm_require_api('Admin');
require_once __DIR__ . '/../../shared/lead_update.php';
crm_lead_update('assign');
