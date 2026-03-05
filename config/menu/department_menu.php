<?php

return  [
    'text'    => 'Department Menu',
    'icon'    => 'fas fa-book',
    // 'route'    => 'organization_menu',
    'submenu' => [

        [
            'text' => 'Branch List',
            'route' => 'branches.index',
            'can' => 'branches.index',
            'active' => ['branches*'],
        ],
        [
            'text' => 'Division List',
            'route' => 'divisions.index',
            'can' => 'divisions.index',
            'active' => ['divisions*'],
        ],
        [
            'text' => 'Department List',
            'route' => 'departments.index',
            'can' => 'departments.index',
            'active' => ['departments*'],
        ],
    ],
];
