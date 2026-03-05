<?php

return [
    'text'    => 'Financial Management',
    'icon'    => 'fas fa-piggy-bank',
    'submenu' => [

        [
            'text'   => 'Bank Balance List',
            'route'  => 'bank_balances.index',
            'can'    => 'bank_balances.index',
            'active' => ['bank_balances*'],
        ],

        [
            'text'   => 'Bank Deposit List',
            'route'  => 'bank_deposits.index',
            'can'    => 'bank_deposits.index',
            'active' => ['bank_deposits*'],
        ],

        [
            'text'   => 'Bank Withdraw List',
            'route'  => 'bank_withdraws.index',
            'can'    => 'bank_withdraws.index',
            'active' => ['bank_withdraws*'],
        ],
    ],
];
