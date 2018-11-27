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
class Index extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        if ( $this->session->isLoggedIn() ) {
            $this->setLayoutFile( 'admin_index_index_admin' )
                    ->setPageTitle( sprintf( '%s - %s', 'CrazyCat', __( 'Dashboard' ) ) );
        }
        else {
            $this->setLayoutFile( 'admin_index_index_guest' )
                    ->setPageTitle( sprintf( '%s - %s', 'CrazyCat', __( 'Administrator Login' ) ) );
        }

        $this->setMetaKeywords( [ 'CrazyCat', 'CMS', __( 'dynamic portal' ) ] )
                ->setMetaDescription( __( 'CrazyCat Platform' ) )
                ->render();
    }

}
