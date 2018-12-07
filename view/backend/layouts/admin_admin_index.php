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
                [ 'class' => 'CrazyCat\Index\Block\Template', 'data' => [
                    'template' => 'CrazyCat\Index::header_buttons',
                    'buttons' => [
                        'new' => [ 'label' => __( 'Create New' ), 'action' => [ 'type' => 'redirect', 'params' => [ 'url' => getUrl( 'admin/admin/edit' ) ] ] ]
                    ]
                ] ]
        ],
        'main' => [
                [ 'class' => 'CrazyCat\Admin\Block\Admin\Grid' ]
        ]
    ]
];
