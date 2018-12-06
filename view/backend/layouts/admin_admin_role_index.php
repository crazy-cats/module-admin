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
    'template' => '2columns_left',
    'blocks' => [
        'header' => [
                [ 'class' => 'CrazyCat\Index\Block\Template', 'data' => [ 'template' => 'CrazyCat\Admin::admin_role/header' ] ]
        ],
        'main' => [
                [ 'class' => 'CrazyCat\Admin\Block\Admin\Role\Grid' ]
        ]
    ]
];
