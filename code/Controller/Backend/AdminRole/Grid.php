<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\AdminRole;

use CrazyCat\Admin\Block\Admin\Role\Grid as GridBlock;
use CrazyCat\Admin\Model\Admin\Role\Collection;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Grid extends \CrazyCat\Base\Controller\Backend\AbstractGridAction {

    protected function construct()
    {
        $this->init( Collection::class, GridBlock::class );

        /**
         * Non-super administrator is only able to access roles
         *     of which level are lower than him/her.
         */
        $adminRole = $this->session->getAdmin()->getRole();
        if ( !$adminRole->getIsSuper() ) {
            $this->collection->addFieldToFilter( 'path', [ 'like' => $adminRole->getPath() . '/%' ] );
        }
    }

}
