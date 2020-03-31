<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Model\Admin;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Role extends \CrazyCat\Framework\App\Component\Module\Model\AbstractModel {

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
     * Set index page and logout function as always in permissions
     * 
     * @return array
     */
    public function getPermissions()
    {
        return array_merge( [ 'system/index/index', 'system/index/logout' ], $this->getData( 'permissions' ) );
    }

}
