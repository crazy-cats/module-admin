<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Setup;

use CrazyCat\Framework\App\Db\MySql;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Upgrade extends \CrazyCat\Framework\App\Module\Setup\AbstractUpgrade {

    private function install()
    {
        $columns = [
                [ 'name' => 'id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'auto_increment' => true ],
                [ 'name' => 'username', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false ],
                [ 'name' => 'password', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 64, 'null' => false ],
                [ 'name' => 'name', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false ],
                [ 'name' => 'enabled', 'type' => MySql::COL_TYPE_TINYINT, 'length' => 1, 'unsign' => true, 'default' => 0 ]
        ];
        $indexes = [
                [ 'columns' => [ 'username' ], 'type' => MySql::INDEX_NORMAL ]
        ];
        $this->conn->createTable( 'admin', $columns, $indexes );
    }

    /**
     * @param string|null $currentVersion
     */
    public function execute( $currentVersion )
    {
        if ( $currentVersion === null ) {
            $this->install();
        }
    }

}
