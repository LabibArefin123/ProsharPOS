<?php

return [
    'text'    => 'Report Management',
    'icon'    => 'fas fa-file',
    'submenu' => [

        [
            'text' => 'Invoice Daily Report',
            'route' => 'report.invoice.daily',
            'can' => 'report.invoice.daily',
        ],
        [
            'text' => 'Invoice Monthly Report',
            'route' => 'report.invoice.monthly',
            'can' => 'report.invoice.monthly',
        ],

        [
            'text' => 'Challan Daily Report',
            'route' => 'report.challan.daily',
            'can' => 'report.challan.daily',
        ],
        [
            'text' => 'Challan Monthly Report',
            'route' => 'report.challan.monthly',
            'can' => 'report.challan.monthly',
        ],

        [
            'text' => 'Purchase Daily Report',
            'route' => 'report.purchase.daily',
            'can' => 'report.purchase.daily',
        ],
        [
            'text' => 'Purchase Monthly Report',
            'route' => 'report.purchase.monthly',
            'can' => 'report.purchase.monthly',
        ],

    ],
];
