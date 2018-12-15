<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin;

use CrazyCat\Admin\Model\Source\AdminRoles;
use CrazyCat\Framework\App\Module\Block\Backend\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Edit extends \CrazyCat\Framework\App\Module\Block\Backend\AbstractEdit {

    /**
     * @var \CrazyCat\Admin\Model\Source\AdminRoles
     */
    protected $adminRoles;

    public function __construct( AdminRoles $adminRoles, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->adminRoles = $adminRoles;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                [ 'name' => 'name', 'label' => __( 'Name' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                [ 'name' => 'username', 'label' => __( 'Username' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                [ 'name' => 'enabled', 'label' => __( 'Enabled' ), 'type' => 'select', 'options' => [ [ 'value' => '1', 'label' => __( 'Yes' ) ], [ 'value' => '0', 'label' => __( 'No' ) ] ] ],
                [ 'name' => 'role_id', 'label' => __( 'Role' ), 'type' => 'select', 'options' => $this->adminRoles->toOptionArray() ],
                [ 'name' => 'password', 'label' => __( 'Password' ), 'type' => 'password' ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return getUrl( 'admin/admin/save' );
    }

}
