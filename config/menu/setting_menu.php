<?php

return [
    'text'    => 'Setting Management',
    'icon'    => 'fas fa-cogs',
    'submenu' => [

        // ================= USER & ACCESS =================
        [
            'text' => 'User & Access Control',
            'icon' => 'fas fa-users-cog',
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
            ],
        ],

        // ================= COMPANY & SYSTEM =================
        [
            'text' => 'Company & System',
            'icon' => 'fas fa-building',
            'submenu' => [
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
        ],

        // ================= SETTINGS =================
        [
            'text' => 'System Settings',
            'icon' => 'fas fa-sliders-h',
            'submenu' => [
                [
                    'text' => 'Settings',
                    'route' => 'settings.index',
                    'can' => 'settings.index',
                    'active' => ['settings*'],
                ],
                [
                    'text' => 'User Devices',
                    'route' => 'user_devices.index',
                    'can' => 'user_devices.index',
                    'active' => ['user_devices*'],
                ],
            ],
        ],

        // ================= SECURITY =================
        [
            'text' => 'Security & Logs',
            'icon' => 'fas fa-shield-alt',
            'submenu' => [
                [
                    'text' => 'Activity Logs',
                    'route' => 'activity.logs.index',
                    'can' => 'activity.logs.index',
                    'active' => ['activity_logs*'],
                ],
                [
                    'text' => 'Security Logs',
                    'route' => 'security_logs.index',
                    'can' => 'security_logs.index',
                    'active' => ['security_logs*'],
                ],
                [
                    'text' => 'Ban Users',
                    'route' => 'ban_users.index',
                    'can' => 'ban_users.index',
                    'active' => ['ban_users*'],
                ],
                [
                    'text' => 'Banned Devices',
                    'route' => 'banned_devices.index',
                    'can' => 'banned_devices.index',
                    'active' => ['banned_devices*'],
                ],
            ],
        ],

    ],
];
