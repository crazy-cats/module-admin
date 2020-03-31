<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Model\Source;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Component\Module\Manager as ModuleManager;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Permissions {

    /**
     * @var \CrazyCat\Framework\App\Component\Module\Manager
     */
    private $moduleManager;

    /**
     * @var array
     */
    private $options;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct( Session $session, ModuleManager $moduleManager )
    {
        $this->moduleManager = $moduleManager;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ( $this->options === null ) {
            $actions = [];
            foreach ( $this->moduleManager->getEnabledModules() as $module ) {
                $actions = array_merge( $actions, array_keys( $module->getControllerActions( Area::CODE_BACKEND ) ) );
            }

            /**
             * Non-super administrator is only able to see permissions of itself.
             */
            if ( $this->session->getAdmin() ) {
                $adminRole = $this->session->getAdmin()->getRole();
                if ( !$adminRole->getIsSuper() ) {
                    $actions = array_intersect( $actions, $adminRole->getPermissions() );
                }
            }

            $this->options = [];
            sort( $actions );
            foreach ( $actions as $action ) {
                $this->options[] = [ 'label' => $action, 'value' => $action ];
            }
        }

        return $this->options;
    }

}
