<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');

// Dummy data array
$newsletters = [
    [
        'id' => 1,
        'name' => 'Alice Johnson',
        'email' => 'alice@example.com',
        'date_added' => '2024-01-10',
        'status' => 'subscribed'
    ],
    [
        'id' => 2,
        'name' => 'Bob Smith',
        'email' => 'bob@example.com',
        'date_added' => '2024-01-12',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 3,
        'name' => 'Charlie Brown',
        'email' => 'charlie@example.com',
        'date_added' => '2024-01-14',
        'status' => 'subscribed'
    ],
    [
        'id' => 4,
        'name' => 'David Green',
        'email' => 'david@example.com',
        'date_added' => '2024-01-16',
        'status' => 'subscribed'
    ],
    [
        'id' => 5,
        'name' => 'Eve White',
        'email' => 'eve@example.com',
        'date_added' => '2024-01-18',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 6,
        'name' => 'Frank Black',
        'email' => 'frank@example.com',
        'date_added' => '2024-01-20',
        'status' => 'subscribed'
    ],
    [
        'id' => 7,
        'name' => 'Grace White',
        'email' => 'grace@example.com',
        'date_added' => '2024-01-22',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 8,
        'name' => 'Hank Brown',
        'email' => 'hank@example.com',
        'date_added' => '2024-01-24',
        'status' => 'subscribed'
    ],
    [
        'id' => 9,
        'name' => 'Ivy Green',
        'email' => 'ivy@example.com',
        'date_added' => '2024-01-26',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 10,
        'name' => 'Jack Black',
        'email' => 'jack@example.com',
        'date_added' => '2024-01-28',
        'status' => 'subscribed'
    ],
    [
        'id' => 11,
        'name' => 'Karen White',
        'email' => 'karen@example.com',
        'date_added' => '2024-01-30',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 12,
        'name' => 'Leo Brown',
        'email' => 'leo@example.com',
        'date_added' => '2024-02-01',
        'status' => 'subscribed'
    ],
    [
        'id' => 13,
        'name' => 'Mia Green',
        'email' => 'mia@example.com',
        'date_added' => '2024-02-03',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 14,
        'name' => 'Nina Black',
        'email' => 'nina@example.com',
        'date_added' => '2024-02-05',
        'status' => 'subscribed'
    ],
    [
        'id' => 15,
        'name' => 'Oscar White',
        'email' => 'oscar@example.com',
        'date_added' => '2024-02-07',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 16,
        'name' => 'Paul Brown',
        'email' => 'paul@example.com',
        'date_added' => '2024-02-09',
        'status' => 'subscribed'
    ],
    [
        'id' => 17,
        'name' => 'Quinn Green',
        'email' => 'quinn@example.com',
        'date_added' => '2024-02-11',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 18,
        'name' => 'Rachel Black',
        'email' => 'rachel@example.com',
        'date_added' => '2024-02-13',
        'status' => 'subscribed'
    ],
    [
        'id' => 19,
        'name' => 'Sam White',
        'email' => 'sam@example.com',
        'date_added' => '2024-02-15',
        'status' => 'unsubscribed'
    ],
    [
        'id' => 20,
        'name' => 'Tina Brown',
        'email' => 'tina@example.com',
        'date_added' => '2024-02-17',
        'status' => 'subscribed'
    ]
];

echo json_encode($newsletters);
?>