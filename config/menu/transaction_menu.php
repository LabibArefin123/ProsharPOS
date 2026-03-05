<?php

return [
    'text' => 'Transaction Management',
    'icon' => 'fas fa-exchange-alt',
    'submenu' => [

        // Purchase Transactions
        [
            'text' => 'Purchase List',
            'route' => 'purchases.index',
            'can' => 'purchases.index',
            'active' => ['purchases*'],
        ],
        [
            'text' => 'Purchase Return',
            'route' => 'purchase_returns.index',
            'can' => 'purchase_returns.index',
            'active' => ['purchase_returns*'],
        ],

        // Sales Transactions
        [
            'text' => 'Invoice List',
            'route' => 'invoices.index',
            'can' => 'invoices.index',
            'active' => ['invoices*'],
        ],
        [
            'text' => 'Sales Return',
            'route' => 'sales_returns.index',
            'can' => 'sales_returns.index',
            'active' => ['sales_returns*'],
        ],

        // Delivery
        [
            'text' => 'Challan List',
            'route' => 'challans.index',
            'can' => 'challans.index',
            'active' => ['challans*'],
        ],

        // Financial Transactions
        [
            'text' => 'Payment List',
            'route' => 'payments.index',
            'can' => 'payments.index',
            'active' => ['payments*'],
        ],
        [
            'text' => 'Supplier Payments',
            'route' => 'supplier_payments.index',
            'can' => 'supplier_payments.index',
            'active' => ['supplier_payments*'],
        ],

        // Internal Expense
        [
            'text' => 'Petty Cash List',
            'route' => 'petty_cashes.index',
            'can' => 'petty_cashes.index',
            'active' => ['petty_cashes*'],
        ],
    ],
];
