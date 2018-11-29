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
class CheckLogin {

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
        if ( !in_array( $this->request->getFullPath(), [ 'admin_index_login', 'admin_index_loginpost', 'admin_index_logout' ] ) &&
                !$this->session->isLoggedIn() ) {
            $data['action']->skipRunning()->redirect( 'admin/index/login' );
        }
    }

}
