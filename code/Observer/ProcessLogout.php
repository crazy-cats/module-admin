<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Admin\Model\Session;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class ProcessLogout {

    public function __construct( Session $session )
    {
        $this->session = $session;
    }

    /**
     * @return void
     */
    public function execute()
    {
        if ( $this->session->isLoggedIn() ) {
            $this->session->destroy();
        }
    }

}
