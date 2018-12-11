<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\Io\Http\Request;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class CheckAccessRight {

    /**
     * @var \CrazyCat\Framework\App\Io\Http\Request
     */
    private $request;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct( Request $request, Session $session )
    {
        $this->request = $request;
        $this->session = $session;
    }

    public function execute( $data )
    {
        $path = $this->request->getFullPath();

        if ( $this->session->isLoggedIn() ) {
            if ( !$this->session->getAdmin()->getRole()->getData( 'is_super' ) &&
                    !in_array( $path, $this->session->getAdmin()->getRole()->getData( 'permissions' ) ) ) {
                $data['action']->skipRunning()->redirect( 'admin' );
            }
        }
        else if ( !in_array( $path, [ 'admin_index_login', 'admin_index_loginpost', 'admin_index_logout' ] ) ) {
            $data['action']->skipRunning()->redirect( 'admin/index/login' );
        }
    }

}
