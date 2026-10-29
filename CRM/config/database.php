<?php
// The CRM uses the site-wide connection settings; keeping a single Database class
// avoids "Cannot declare class Database" when both paths get loaded.
require_once __DIR__ . '/../../config/database.php';
