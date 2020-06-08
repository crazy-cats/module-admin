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
        'header' => [
            'header-buttons' => [
                'class' => 'CrazyCat\Base\Block\Template',
                'data'  => [
                    'template' => 'CrazyCat\Base::header_buttons',
                    'buttons'  => [
                        'back'          => [
                            'label'  => __('Back'),
                            'action' => [
                                'type'   => 'redirect',
                                'params' => ['url' => getUrl('admin/admin')]
                            ]
                        ],
                        'save'          => [
                            'label'  => __('Save'),
                            'action' => ['type' => 'save', 'params' => ['target' => '#edit-form']]
                        ],
                        'save_continue' => [
                            'label'  => __('Save and Continue'),
                            'action' => [
                                'type'   => 'saveContinue',
                                'params' => ['target' => '#edit-form']
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'main'   => [
            'edit-form' => [
                'class' => 'CrazyCat\Admin\Block\Admin\Edit'
            ]
        ]
    ]
];
