<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin\Role;

use CrazyCat\Admin\Model\Admin\Role;
use CrazyCat\Admin\Model\Source\AdminRoles;
use CrazyCat\Framework\App\Theme\Block\Context;
use CrazyCat\Framework\Utility\Tools;

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

    /**
     * @var \CrazyCat\Admin\Model\Admin\Role
     */
    protected $role;

    public function __construct( AdminRoles $adminRoles, Role $role, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->adminRoles = $adminRoles;
        $this->role = $role;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                [ 'name' => 'title', 'label' => __( 'Title' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                [ 'name' => 'parent_id', 'label' => __( 'Parent' ), 'type' => 'select', 'options' => array_merge( [ [ 'label' => '[ ROOT ]', 'value' => 0 ] ], $this->adminRoles->toOptionArray( $this->registry->registry( 'current_model' )->getId() ) ) ],
                [ 'name' => 'permissions', 'label' => __( 'Permissions' ), 'type' => 'multiselect', 'options' => Tools::toOptionsArray( $this->role->getAllPermissions() ) ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return getUrl( 'admin/admin_role/save' );
    }

}
