<?php

return [
    'text' => 'Storage',
    'icon' => 'fas fa-warehouse',
    'submenu' => [

        [
            'text' => 'Warehouse List',
            'route' => 'warehouses.index',
            'can' => 'warehouses.index',
            'active' => ['warehouses*'],
        ],

        [
            'text' => 'Storage List',
            'route' => 'storages.index',
            'can' => 'storages.index',
            'active' => ['storages*'],
        ],

    ],
];
