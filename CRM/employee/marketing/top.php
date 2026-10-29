<?php
$section = [
    'role' => 'Employee',
    'sub_role' => 'marketing',
    'title' => 'Marketing',
    'base' => '../../',
    'nav' => [
        ['main.php', 'fas fa-chart-bar', 'Dashboard'],
        ['profile.php', 'fas fa-user', 'My Profile'],
        ['leave_portal.php', 'fas fa-calendar-alt', 'Leave Portal'],
        ['leads.php', 'fas fa-bullseye', 'Leads'],
    ],
];
require __DIR__ . '/../../layout/top.php';
