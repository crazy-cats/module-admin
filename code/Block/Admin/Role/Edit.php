<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin\Role;

use CrazyCat\Admin\Model\Admin\Role;
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
     * @var \CrazyCat\Admin\Model\Admin\Role
     */
    protected $role;

    public function __construct( Role $role, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->role = $role;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                [ 'name' => 'title', 'label' => __( 'Title' ), 'type' => 'text' ],
                [ 'name' => 'permisions', 'label' => __( 'Permisions' ), 'type' => 'multiselect', 'options' => Tools::toOptionsArray( $this->role->getAllPermissions() ) ]
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
