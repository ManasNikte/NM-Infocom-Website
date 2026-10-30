<?php
// Sales manager: change a lead (status). Logic and validation: shared/lead_update.php
require_once __DIR__ . '/../../../config/auth.php';
crm_require_api(['Admin', 'Manager'], 'sales');
require_once __DIR__ . '/../../../shared/lead_update.php';
crm_lead_update('status');
