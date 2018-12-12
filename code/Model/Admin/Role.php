<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Model\Admin;

use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Db\Manager as DbManager;
use CrazyCat\Framework\App\EventManager;
use CrazyCat\Framework\App\Module\Manager as ModuleManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Role extends \CrazyCat\Framework\App\Module\Model\AbstractModel {

    /**
     * @var array
     */
    static protected $permissions;

    /**
     * @var \CrazyCat\Framework\App\Module\Manager
     */
    protected $moduleManager;

    public function __construct( ModuleManager $moduleManager, EventManager $eventManager, DbManager $dbManager, array $data = [] )
    {
        parent::__construct( $eventManager, $dbManager, $data );

        $this->moduleManager = $moduleManager;
    }

    /**
     * @return void
     */
    protected function construct()
    {
        $this->init( 'admin_role', 'admin_role' );
    }

    /**
     * @return void
     */
    protected function beforeSave()
    {
        parent::beforeSave();

        $this->setData( 'permissions', json_encode( $this->getData( 'permissions' ) ) );
    }

    /**
     * @return void
     */
    protected function afterSave()
    {
        if ( ( $parentId = $this->getData( 'parent_id' ) ) == 0 ) {
            $path = $this->getId();
        }
        else {
            if ( !( $path = $this->conn->fetchOne( sprintf( 'SELECT `path` FROM `%s` WHERE `%s` = ?', $this->conn->getTableName( $this->mainTable ), $this->idFieldName ), [ $parentId ] ) ) ) {
                throw new \Exception( __( 'Role record with specified parent ID does not has a path.' ) );
            }
            $path .= '/' . $this->getId();
        }
        $this->conn->update( $this->mainTable, [ 'path' => $path ], [ '`id` = ?' => $this->getId() ] );

        parent::afterSave();
    }

    /**
     * @return void
     */
    protected function afterLoad()
    {
        $this->setData( 'permissions', json_decode( $this->getData( 'permissions' ), true ) );

        parent::afterLoad();
    }

    /**
     * @return array
     */
    public function getAllPermissions()
    {
        if ( self::$permissions === null ) {
            $actions = [];
            foreach ( $this->moduleManager->getEnabledModules() as $module ) {
                $actions = array_merge( $actions, array_keys( $module->getControllerActions( Area::CODE_BACKEND ) ) );
            }
            sort( $actions );
            self::$permissions = array_combine( $actions, $actions );
        }

        return self::$permissions;
    }

}
