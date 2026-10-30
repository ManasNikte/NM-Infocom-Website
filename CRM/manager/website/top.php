<?php
$section = [
    'role' => 'Manager',
    'sub_role' => 'website',
    'title' => 'Website Manager',
    'base' => '../../',
    'nav' => [
        ['dashboard.php', 'fas fa-chart-bar', 'Dashboard'],
        ['profile.php', 'fas fa-user', 'My Profile'],
        ['leave_portal.php', 'fas fa-calendar-alt', 'Leave Portal'],
        ['all_enquiries.php', 'fas fa-question-circle', 'Enquiries'],
        ['all_product.php', 'fas fa-box', 'Products'],
        ['nm_reviews.php', 'fas fa-star', 'NM Reviews'],
        ['contact_submits.php', 'fas fa-envelope', 'Contact Submits'],
        ['blogs.php', 'fas fa-blog', 'Blogs'],
        ['events.php', 'fas fa-calendar', 'Events'],
        ['nm_newsletter.php', 'fas fa-newspaper', 'NM Newsletter'],
        ['nm_web_data.php', 'fas fa-globe', 'NM Web Data'],
    ],
];
require __DIR__ . '/../../layout/top.php';
