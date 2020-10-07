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
    'template' => '2columns_left',
    'blocks'   => [
        'main' => [
            'children' => [
                'grid-form' => [
                    'class' => 'CrazyCat\Admin\Block\Log\Grid'
                ]
            ]
        ]
    ]
];
