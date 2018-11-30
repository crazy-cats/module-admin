<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block;

use CrazyCat\Framework\App\Module\Manager as ModuleManager;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Index
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Menu extends \CrazyCat\Index\Block\Menu {

    const CACHE_MENU_DATA = 'backend_menu_data';

    protected $template = 'CrazyCat\Admin::menu';

    /**
     * @var \CrazyCat\Framework\App\Module\Manager
     */
    protected $moduleManager;

    public function __construct( ModuleManager $moduleManager, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->moduleManager = $moduleManager;
    }

    /**
     * @return array
     */
    protected function getMenuData()
    {
        $cacheMenuData = $this->cacheFactory->create( self::CACHE_MENU_DATA );
        if ( empty( $menuData = $cacheMenuData->getData() ) ) {
            foreach ( $this->moduleManager->getEnabledModules() as $module ) {
                if ( is_file( ( $file = $module->getData( 'dir' ) . DS . 'config' . DS . 'backend' . DS . 'menu.php' ) ) &&
                        is_array( ( $moduleMenuData = require $file ) ) ) {
                    $menuData = array_merge( $menuData, $moduleMenuData );
                }
            }
            $cacheMenuData->setData( $menuData )->save();
        }
        return $menuData;
    }

}
