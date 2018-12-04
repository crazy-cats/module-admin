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
class Grid extends \CrazyCat\Index\Block\Backend\AbstractGrid {

    const COOKIES_BOOKMARK_KEY = 'admin';

    public function getFields()
    {
        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'filter' => 'text', 'sort' => true ],
                [ 'name' => 'name', 'label' => __( 'Name' ), 'filter' => 'text', 'sort' => false ],
                [ 'name' => 'username', 'label' => __( 'Username' ), 'filter' => 'text', 'sort' => true ] ];
    }

    public function getSourceUrl()
    {
        return getUrl( 'admin/admin/grid' );
    }

}
