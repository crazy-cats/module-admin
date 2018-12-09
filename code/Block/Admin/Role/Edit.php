<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin\Role;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Edit extends \CrazyCat\Framework\App\Module\Block\Backend\AbstractEdit {

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                [ 'name' => 'title', 'label' => __( 'Title' ), 'type' => 'text' ],
                [ 'name' => 'permisions', 'label' => __( 'Permisions' ), 'type' => 'multiselect' ]
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
