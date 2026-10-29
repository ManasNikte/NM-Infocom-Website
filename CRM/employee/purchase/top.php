<?php
$section = [
    'role' => 'Employee',
    'sub_role' => 'purchase',
    'title' => 'Purchase',
    'base' => '../../',
    'nav' => [
        ['main.php', 'fas fa-chart-bar', 'Dashboard'],
        ['profile.php', 'fas fa-user', 'My Profile'],
        ['leave_portal.php', 'fas fa-calendar-alt', 'Leave Portal'],
        ['vendors.php', 'fas fa-truck', 'Vendors'],
    ],
];
require __DIR__ . '/../../layout/top.php';
