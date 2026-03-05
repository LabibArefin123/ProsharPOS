<?php

return [
    'text' => 'Product Management',
    'icon' => 'fas fa-box',
    'submenu' => [

        // Master Data
        [
            'text' => 'Category List',
            'route' => 'categories.index',
            'can' => 'categories.index',
            'active' => ['categories*'],
        ],
        [
            'text' => 'Brand List',
            'route' => 'brands.index',
            'can' => 'brands.index',
            'active' => ['brands*'],
        ],
        [
            'text' => 'Unit List',
            'route' => 'units.index',
            'can' => 'units.index',
            'active' => ['units*'],
        ],
        [
            'text' => 'Warranty List',
            'route' => 'warranties.index',
            'can' => 'warranties.index',
            'active' => ['warranties*'],
        ],
        [
            'text' => 'Storage List',
            'route' => 'storages.index',
            'can' => 'storages.index',
            'active' => ['storages*'],
        ],

        // Product
        [
            'text' => 'Product List',
            'route' => 'products.index',
            'can' => 'products.index',
            'active' => ['products*'],
        ],

        // Inventory
        [
            'text' => 'Product Stock',
            'route' => 'products.stock',
            'can' => 'products.stock',
            'active' => ['products/stock*'],
        ],

        // Quality / Service
        [
            'text' => 'Product Inspection List',
            'route' => 'product_inspections.index',
            'can' => 'product_inspections.index',
            'active' => ['product_inspections*'],
        ],

    ],
];
