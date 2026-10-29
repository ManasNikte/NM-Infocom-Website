<?php
$section = [
    'role' => 'Manager',
    'sub_role' => 'purchase',
    'title' => 'Purchase Manager',
    'base' => '../../',
    'nav' => [
        ['dashboard.php', 'fas fa-chart-bar', 'Dashboard'],
        ['profile.php', 'fas fa-user', 'My Profile'],
        ['leave_portal.php', 'fas fa-calendar-alt', 'Leave Portal'],
        ['vendors.php', 'fas fa-truck', 'Vendors'],
        ['purchaseorders.php', 'fas fa-file-invoice', 'Purchase Orders'],
        ['emp_list.php', 'fas fa-users', 'Employee List'],
    ],
];
require __DIR__ . '/../../layout/top.php';
