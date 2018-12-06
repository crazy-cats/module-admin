<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Grid extends \CrazyCat\Framework\App\Module\Block\Backend\AbstractGrid {

    const COOKIES_BOOKMARK_KEY = 'admin';

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'eq' ] ],
                [ 'name' => 'name', 'label' => __( 'Name' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'like' ] ],
                [ 'name' => 'username', 'label' => __( 'Username' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'like' ] ] ];
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return getUrl( 'admin/admin/grid' );
    }

}
