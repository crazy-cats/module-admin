<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Model;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Session extends \CrazyCat\Framework\App\Io\Http\Session\Backend {

    /**
     * @var \CrazyCat\Admin\Model\Admin|null
     */
    protected $admin;

    /**
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->storage->getData( 'admin_id' ) !== null;
    }

    /**
     * @return \CrazyCat\Admin\Model\Admin|null
     */
    public function getAdmin()
    {
        if ( $this->admin === null ) {
            if ( ( $id = $this->storage->getData( 'admin_id' ) ) ) {
                $this->admin = $this->objectManager->create( Admin::class )->load( $id );
            }
        }
        return $this->admin;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setAdminId( $id )
    {
        $this->storage->setData( 'admin_id', $id );
        if ( $id === null ) {
            $this->admin = null;
        }
        return $this;
    }

}
