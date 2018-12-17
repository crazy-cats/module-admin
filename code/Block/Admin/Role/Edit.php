<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin\Role;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Admin\Model\Source\AdminRoles;
use CrazyCat\Admin\Model\Source\Permissions;
use CrazyCat\Core\Block\Backend\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Edit extends \CrazyCat\Core\Block\Backend\AbstractEdit {

    /**
     * @var \CrazyCat\Admin\Model\Source\AdminRoles
     */
    protected $adminRoles;

    /**
     * @var \CrazyCat\Admin\Model\Source\Permissions
     */
    protected $permissions;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct( Session $session, AdminRoles $adminRoles, Permissions $permissions, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->adminRoles = $adminRoles;
        $this->permissions = $permissions;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        /**
         * Only super administrator can assign a role under ROOT.
         */
        $parentOptions = $this->adminRoles->toOptionArray( $this->registry->registry( 'current_model' )->getId() );
        if ( $this->session->getAdmin()->getRole()->getIsSuper() ) {
            array_unshift( $parentOptions, [ 'label' => '[ ROOT ]', 'value' => 0 ] );
        }

        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                [ 'name' => 'title', 'label' => __( 'Role Title' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                [ 'name' => 'parent_id', 'label' => __( 'Parent Role' ), 'type' => 'select', 'options' => $parentOptions ],
                [ 'name' => 'permissions', 'label' => __( 'Permissions' ), 'type' => 'multiselect', 'options' => $this->permissions->toOptionArray() ]
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
