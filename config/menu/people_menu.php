<?php

return [
    'text'    => 'People Management',
    'icon'    => 'fas fa-people-group',
    'submenu' => [
        [
            'text' => 'Customer List',
            'route' => 'customers.index',
            'can' => 'customers.index',
            'active' => ['customers*'],
        ],
        [
            'text' => 'Suppliers List',
            'route' => 'suppliers.index',
            'can' => 'suppliers.index',
            'active' => ['suppliers*'],
        ],
        [
            'text' => 'Manufacturer List',
            'route' => 'manufacturers.index',
            'can' => 'manufacturers.index',
            'active' => ['manufacturers*'],
        ],
    ],
];
