<?php

return [
    'text'    => 'Setting Management',
    'icon'    => 'fas fa-cogs',
    'submenu' => [
        [
            'text' => 'User Category List',
            'route' => 'user_categories.index',
            'can' => 'user_categories.index',
            'active' => ['user_categories*'],
        ],
        [
            'text' => 'Role List',
            'route' => 'roles.index',
            'can' => 'roles.index',
            'active' => ['roles*'],
        ],

        [
            'text' => 'Permission List',
            'route' => 'permissions.index',
            'can' => 'permissions.index',
            'active' => ['permissions*'],
        ],
        [
            'text' => 'System User',
            'route' => 'system_users.index',
            'can' => 'system_users.index',
            'active' => ['system_users*'],
        ],
        [
            'text' => 'Company Profile',
            'route' => 'companies.index',
            'can' => 'companies.index',
            'active' => ['companies*'],
        ],
        [
            'text' => 'System Information',
            'route' => 'system_informations.index',
            'can' => 'system_informations.index',
            'active' => ['system_informations*'],
        ],
    ],

];
