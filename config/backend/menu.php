<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
return [
    'admin' => [
        'label' => 'Admin',
        'sort_order' => 200,
        'children' => [
            'admin/admin/index' => [
                'label' => 'Administrators',
                'url' => 'admin/admin'
            ],
            'admin/admin_role/index' => [
                'label' => 'Administrator Roles',
                'url' => 'admin/admin_role'
            ],
            'admin/log/index' => [
                'label' => 'Actions Log',
                'url' => 'admin/log'
            ]
        ]
    ]
];
