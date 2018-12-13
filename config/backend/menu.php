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
        [
        'label' => __( 'Admin' ), 'identifier' => 'admin',
        'children' => [
                [ 'label' => __( 'Administrators' ), 'identifier' => 'admin/admin/index', 'url' => getUrl( 'admin/admin' ) ],
                [ 'label' => __( 'Administrator Roles' ), 'identifier' => 'admin/admin_role/index', 'url' => getUrl( 'admin/admin_role' ) ]
        ],
        'sort_order' => 2 ],
        [ 'label' => __( 'Logout' ), 'identifier' => 'admin/index/logout', 'sort_order' => 999, 'url' => getUrl( 'admin/index/logout' ) ]
];
