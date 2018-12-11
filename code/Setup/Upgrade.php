<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Setup;

use CrazyCat\Admin\Model\Admin as AdminModel;
use CrazyCat\Framework\App\Db\Manager as DbManager;
use CrazyCat\Framework\App\Db\MySql;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Upgrade extends \CrazyCat\Framework\App\Module\Setup\AbstractUpgrade {

    /**
     * @var \CrazyCat\Admin\Model\Admin
     */
    private $adminModel;

    public function __construct( AdminModel $adminModel, DbManager $dbManager )
    {
        parent::__construct( $dbManager );

        $this->adminModel = $adminModel;
    }

    private function createAdminTable()
    {
        $columns = [
                [ 'name' => 'id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'auto_increment' => true ],
                [ 'name' => 'username', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 16, 'null' => false ],
                [ 'name' => 'password', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 64, 'null' => false ],
                [ 'name' => 'name', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false ],
                [ 'name' => 'enabled', 'type' => MySql::COL_TYPE_TINYINT, 'length' => 1, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'role_id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false ],
                [ 'name' => 'created_at', 'type' => MySql::COL_TYPE_DATETIME, 'null' => false ],
                [ 'name' => 'updated_at', 'type' => MySql::COL_TYPE_DATETIME, 'null' => false ]
        ];
        $indexes = [
                [ 'columns' => [ 'username' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'enabled' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'role_id' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'created_at' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'updated_at' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'name' ], 'type' => MySql::INDEX_FULLTEXT ]
        ];
        $this->conn->createTable( 'admin', $columns, $indexes );
    }

    private function createAdminRoleTable()
    {
        $columns = [
                [ 'name' => 'id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'auto_increment' => true ],
                [ 'name' => 'parent_id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'title', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false ],
                [ 'name' => 'is_super', 'type' => MySql::COL_TYPE_TINYINT, 'length' => 1, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'permissions', 'type' => MySql::COL_TYPE_TEXT ]
        ];
        $indexes = [
                [ 'columns' => [ 'parent_id' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'title' ], 'type' => MySql::INDEX_FULLTEXT ]
        ];
        $this->conn->createTable( 'admin_role', $columns, $indexes );
    }

    private function createAdminLogTable()
    {
        $columns = [
                [ 'name' => 'id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'auto_increment' => true ],
                [ 'name' => 'admin_id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false ],
                [ 'name' => 'action', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 64, 'null' => false ],
                [ 'name' => 'data', 'type' => MySql::COL_TYPE_TEXT ],
                [ 'name' => 'ip', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 16, 'null' => false ],
                [ 'name' => 'created_at', 'type' => MySql::COL_TYPE_DATETIME, 'null' => false ]
        ];
        $indexes = [
                [ 'columns' => [ 'admin_id' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'created_at' ], 'type' => MySql::INDEX_NORMAL ]
        ];
        $this->conn->createTable( 'admin_log', $columns, $indexes );
    }

    private function createDefaultAdmin()
    {
        $now = date( 'Y-m-d H:i:s' );

        $roleId = $this->conn->insert( 'admin_role', [
            'title' => 'Super Administrator',
            'is_super' => 1 ] );

        $this->conn->insert( 'admin', [
            'username' => 'admin',
            'password' => $this->adminModel->encryptPassword( 'admin123' ),
            'name' => 'Admin',
            'enabled' => 1,
            'role_id' => $roleId,
            'created_at' => $now,
            'updated_at' => $now ] );
    }

    /**
     * @param string|null $currentVersion
     */
    public function execute( $currentVersion )
    {
        if ( $currentVersion === null ) {
            $this->createAdminTable();
            $this->createAdminRoleTable();
            $this->createAdminLogTable();
            $this->createDefaultAdmin();
        }
    }

}
