<?php

return [
    'text' => 'Service Menu',
    'icon' => 'fas fa-tools',
    'submenu' => [

        // Product Inspection
        [
            'text' => 'Product Inspection',
            'route' => 'product_inspections.index',
            'can' => 'product_inspections.index',
            'active' => ['product_inspections*'],
        ],

        // // Repair Jobs
        // [
        //     'text' => 'Repair Jobs',
        //     'route' => 'repair_jobs.index',
        //     'can' => 'repair_jobs.index',
        //     'active' => ['repair_jobs*'],
        // ],

        // // Warranty Claims
        // [
        //     'text' => 'Warranty Claims',
        //     'route' => 'warranty_claims.index',
        //     'can' => 'warranty_claims.index',
        //     'active' => ['warranty_claims*'],
        // ],

    ],
];
