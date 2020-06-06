<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin\Role;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Admin\Model\Source\AdminRoles;
use CrazyCat\Admin\Model\Source\Permissions;
use CrazyCat\Base\Block\Backend\Context;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Edit extends \CrazyCat\Base\Block\Backend\AbstractEdit {

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
            'general' => [
                'label' => __( 'General' ),
                'fields' => [
                        [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                        [ 'name' => 'title', 'label' => __( 'Role Title' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                        [ 'name' => 'parent_id', 'label' => __( 'Parent Role' ), 'type' => 'select', 'options' => $parentOptions ],
                        [ 'name' => 'permissions', 'label' => __( 'Permissions' ), 'type' => 'multiselect', 'options' => $this->permissions->toOptionArray() ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl( 'admin/admin_role/save' );
    }

}
