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
    'namespace' => 'CrazyCat\Admin',
    'version' => '1.0.0',
    'depends' => [],
    'events' => [
        'process_backend_login' => 'CrazyCat\Admin\Observer\ProcessLogin',
        'process_backend_logout' => 'CrazyCat\Admin\Observer\ProcessLogout',
        'backend_controller_execute_before' => 'CrazyCat\Admin\Observer\CheckAccessRight'
    ],
    'routes' => [
        'backend' => 'admin'
    ]
];
