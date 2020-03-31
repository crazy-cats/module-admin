<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
return [
    'process_backend_login'     => 'CrazyCat\Admin\Observer\ProcessLogin',
    'process_backend_logout'    => 'CrazyCat\Admin\Observer\ProcessLogout',
    'controller_execute_before' => [
        'CrazyCat\Admin\Observer\CheckPermission',
        'CrazyCat\Admin\Observer\LogAction'
    ]
];
