<?php

return [
    'text' => 'Product Management',
    'icon' => 'fas fa-box',
    'submenu' => [

        // Product (Most Used in POS)
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
        ],

        [
            'text' => 'Damage Product',
            'route' => 'product_damages.stock',
            'can' => 'product_damages.stock',
            'active' => ['product_damages*'],
        ],
        
        [
            'text' => 'Expired Product',
            'route' => 'product_expirys.stock',
            'can' => 'product_expirys.stock',
            'active' => ['product_expirys*'],
        ],

        [
            'text' => 'Stock Movement',
            'route' => 'stock_movements.index',
            'can' => 'stock_movements.index',
            'active' => ['stock_movements*'],
        ],

        // Quality / Service
        [
            'text' => 'Product Inspection List',
            'route' => 'product_inspections.index',
            'can' => 'product_inspections.index',
            'active' => ['product_inspections*'],
        ],

        // Warehouse / Storage
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

    ],
];
