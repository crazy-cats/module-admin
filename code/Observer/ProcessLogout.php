<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\Io\Http\Cookies;
use CrazyCat\Framework\App\Io\Http\Session\Manager as SessionManager;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class ProcessLogout {

    /**
     * @var \CrazyCat\Framework\App\Io\Http\Cookies
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
