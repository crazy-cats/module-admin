<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Edit extends \CrazyCat\Base\Block\Backend\AbstractEdit
{
    /**
     * @var \CrazyCat\Admin\Model\Source\AdminRoles
     */
    protected $adminRoles;

    public function __construct(
        \CrazyCat\Admin\Model\Source\AdminRoles $adminRoles,
        \CrazyCat\Base\Block\Backend\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->adminRoles = $adminRoles;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getFields()
    {
        return [
            'general' => [
                'label'  => __('General'),
                'fields' => [
                    ['name' => 'id', 'label' => __('ID'), 'type' => 'hidden'],
                    ['name' => 'name', 'label' => __('Name'), 'type' => 'text', 'validation' => ['required' => true]],
                    [
                        'name'       => 'username',
                        'label'      => __('Username'),
                        'type'       => 'text',
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'    => 'enabled',
                        'label'   => __('Enabled'),
                        'type'    => 'select',
                        'options' => [['value' => '1', 'label' => __('Yes')], ['value' => '0', 'label' => __('No')]]
                    ],
                    [
                        'name'    => 'role_id',
                        'label'   => __('Role'),
                        'type'    => 'select',
                        'options' => $this->adminRoles->toOptionArray()
                    ],
                    ['name' => 'password', 'label' => __('Password'), 'type' => 'password']
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('admin/admin/save');
    }
}
