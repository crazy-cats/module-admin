<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\Cookies;
use CrazyCat\Framework\App\Session\Manager as SessionManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class ProcessLogout {

    /**
     * @var \CrazyCat\Framework\App\Cookies
     */
    private $cookies;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct( Cookies $cookies, Session $session )
    {
        $this->cookies = $cookies;
        $this->session = $session;
    }

    /**
     * @return void
     */
    public function execute()
    {
        if ( $this->session->isLoggedIn() ) {
            $this->session->destroy();
            $this->cookies->unsetData( SessionManager::SESSION_NAME );
        }
    }

}
