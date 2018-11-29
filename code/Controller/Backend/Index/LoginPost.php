<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\Index;

use CrazyCat\Admin\Model\Admin;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class LoginPost extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        try {
            $post = $this->request->getPost();
            $admin = $this->objectManager->create( Admin::class )->login( $post['username'], $post['password'] );
            $this->session->setAdminId( $admin->getData( 'id' ) );
            $this->messenger->addSuccess( __( 'Logged in successfully.' ) );
        }
        catch ( \Exception $e ) {
            $this->messenger->addError( $e->getMessage() );
        }

        $this->redirect( 'admin/index/index' );
    }

}
