<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\Module\Manager as ModuleManager;
use CrazyCat\Framework\App\Theme\Block\Context;
use CrazyCat\Framework\App\Translator;

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

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    protected $session;

    /**
     * @var \CrazyCat\Framework\App\Translator
     */
    protected $translator;

    public function __construct( Session $session, Translator $translator, ModuleManager $moduleManager, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->moduleManager = $moduleManager;
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    protected function getFullMenuData()
    {
        $cacheMenuData = $this->cacheFactory->create( self::CACHE_MENU_DATA . '-' . $this->translator->getLangCode() );
        if ( empty( $menuData = $cacheMenuData->getData() ) ) {
            foreach ( $this->moduleManager->getEnabledModules() as $module ) {
                if ( is_file( ( $file = $module->getData( 'dir' ) . DS . 'config' . DS . 'backend' . DS . 'menu.php' ) ) &&
                        is_array( ( $moduleMenuData = require $file ) ) ) {
                    $menuData = array_merge( $menuData, $moduleMenuData );
                }
            }
            usort( $menuData, function( $a, $b ) {
                return $a['sort_order'] < $b ? 1 : ( $a['sort_order'] > $b ? -1 : 0 );
            } );
            $cacheMenuData->setData( $menuData )->save();
        }
        return $menuData;
    }

    /**
     * @return array
     */
    protected function getMenuData()
    {
        if ( !$this->session->getAdmin() ) {
            return [];
        }

        $sourceData = $this->getFullMenuData();
        if ( $this->session->getAdmin()->getRole()->getIsSuper() ) {
            return $sourceData;
        }

        $menuData = [];
        $permissions = $this->session->getAdmin()->getRole()->getPermissions();
        foreach ( $sourceData as $itemData ) {

            /**
             * Show level 1 item only on at least one child item is in permissions,
             *     if related child item exist.
             */
            if ( isset( $itemData['children'] ) ) {
                $children = [];
                foreach ( $itemData['children'] as $childData ) {
                    if ( in_array( $childData['identifier'], $permissions ) ) {
                        $children[] = $childData;
                    }
                }
                if ( !empty( $children ) ) {
                    $menuData[] = [
                        'label' => $itemData['label'],
                        'identifier' => $itemData['identifier'],
                        'children' => $children
                    ];
                }
            }

            /**
             * Check permission with level 1 item if no child item set.
             */
            else {
                if ( in_array( $itemData['identifier'], $permissions ) ) {
                    $menuData[] = $itemData;
                }
            }
        }

        return $menuData;
    }

}
