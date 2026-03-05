<?php

return [
    'text'    => 'Organization Menu',
    'icon'    => 'fas fa-cogs',
    // 'route'    => 'organization_menu',
    'submenu' => [

        [
            'text' => 'Organization List',
            'route' => 'organizations.index',
            'can' => 'organizations.index',
            'active' => ['organizations*'],
        ],
    ],
];
