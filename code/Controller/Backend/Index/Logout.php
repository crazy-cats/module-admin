<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\Index;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Logout extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        if ( $this->session->isLoggedIn() ) {
            $this->session->destroy();
            $this->messenger->addSuccess( __( 'Logged out successfully.' ) );
        }
        $this->redirect( 'admin/index/login' );
    }

}
