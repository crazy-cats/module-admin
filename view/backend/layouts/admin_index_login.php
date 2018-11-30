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
    'template' => 'home',
    'blocks' => [
        'main' => [
            [ 'class' => 'CrazyCat\Index\Block\Template', 'data' => [ 'template' => 'CrazyCat\Admin::login' ] ]
        ]
    ]
];
