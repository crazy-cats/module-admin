<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Model;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Admin extends \CrazyCat\Framework\App\Module\Model\AbstractModel {

    /**
     * @return void
     */
    protected function construct()
    {
        $this->init( 'admin', 'admin' );
    }

    /**
     * @param string $adminPasswordHash
     * @param string $inputPassword
     * @return boolean
     */
    public function verifyPassword( $adminPasswordHash, $inputPassword )
    {
        return password_verify( $inputPassword, $adminPasswordHash );
    }

    /**
     * @param string $password
     * @return string
     */
    public function encryptPassword( $password )
    {
        return password_hash( $password, PASSWORD_DEFAULT );
    }

    /**
     * @param string $username
     * @param string $password
     * @return $this
     */
    public function login( $username, $password )
    {
        if ( !empty( $admin = $this->conn->fetchRow( sprintf( 'SELECT * FROM `%s` WHERE `username` = ? AND `enabled` = 1', $this->mainTable ), [ $username ] ) ) ) {
            if ( $this->verifyPassword( $admin['password'], $password ) ) {
                return $this->setData( $admin );
            }
        }
        throw new \Exception( __( 'User does not exist or password does not match the username.' ) );
    }

}
