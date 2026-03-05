
<?php

return [
    'text' => 'POS',
    'icon' => 'fas fa-cash-register',
    'submenu' => [

        [
            'text' => 'New Sale',
            'route' => 'pos.index',
            'can' => 'pos.index',
            'active' => ['pos*'],
        ],

        [
            'text' => 'POS Orders',
            'route' => 'pos.orders',
            'can' => 'pos.orders',
            'active' => ['pos/orders*'],
        ],

    ],
];
