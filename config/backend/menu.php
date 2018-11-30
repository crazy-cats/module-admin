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
        'label' => __( 'Administrator' ), 'identifier' => 'admin', 'url' => getUrl( 'admin/admin' ),
        'children' => [
                [ 'label' => __( 'Administrators' ), 'identifier' => 'admin-list', 'url' => getUrl( 'admin/admin' ) ],
                [ 'label' => __( 'Administrator Roles' ), 'identifier' => 'admin-roles', 'url' => getUrl( 'admin/adminrole' ) ]
        ]
    ],
        [ 'label' => 'Logout', 'identifier' => 'logout', 'url' => getUrl( 'admin/index/logout' ) ]
];