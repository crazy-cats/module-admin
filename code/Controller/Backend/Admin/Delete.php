<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\Admin;

use CrazyCat\Admin\Helper\Permission;
use CrazyCat\Admin\Model\Admin as Model;
use CrazyCat\Framework\App\Io\Http\Response;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Delete extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        $success = false;

        if ( !( $id = $this->request->getParam( 'id' ) ) ) {
            $message = __( 'Please specifiy an item.' );
        }
        else {
            /* @var $model \CrazyCat\Framework\App\Module\Model\AbstractModel */
            $model = $this->objectManager->create( Model::class )->load( $id );
            if ( $model->getId() ) {

                if ( !$this->objectManager->get( Permission::class )->canAccessAdmin( $model ) ) {
                    $this->messenger->addError( __( 'You do not have the permission.' ) );
                    return $this->redirect( 'admin/admin' );
                }

                try {
                    $model->delete();
                    $success = true;
                    $message = null;
                }
                catch ( \Exception $e ) {
                    $message = $e->getMessage();
                }
            }
            else {
                $message = __( 'Item with specified ID does not exist.' );
            }
        }

        $this->response->setType( Response::TYPE_JSON )->setData( [ 'success' => $success, 'message' => $message ] );
    }

}
