<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Log;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Grid extends \CrazyCat\Base\Block\Backend\AbstractGrid {

    const BOOKMARK_KEY = 'admin_log';

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'name' => 'admin_id', 'label' => __( 'Administrator' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'like' ] ],
                [ 'name' => 'action', 'label' => __( 'Action' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'like' ] ],
                [ 'name' => 'ip', 'label' => __( 'IP' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'like' ] ],
                [ 'name' => 'created_at', 'label' => __( 'Time' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'like' ] ] ];
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return getUrl( 'admin/log/grid' );
    }

}
