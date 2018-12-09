<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\Admin;

use CrazyCat\Admin\Model\Admin as Model;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Save extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        /* @var $model \CrazyCat\Admin\Model\Admin */
        $model = $this->objectManager->create( Model::class );

        $data = $this->request->getPost( 'data' );
        if ( empty( $data[$model->getIdFieldName()] ) ) {
            unset( $data[$model->getIdFieldName()] );
        }
        if ( empty( $data['password'] ) ) {
            unset( $data['password'] );
        }
        else {
            $data['password'] = $model->encryptPassword( $data['password'] );
        }

        try {
            $model->addData( $data )->save();
            $this->messenger->addSuccess( __( 'Successfully saved.' ) );

            if ( !$this->request->getPost( 'to_list' ) ) {
                return $this->redirect( 'admin/admin/edit', [ 'id' => $model->getId() ] );
            }
        }
        catch ( \Exception $e ) {
            $this->messenger->addError( $e->getMessage() );
        }

        return $this->redirect( 'admin/admin' );
    }

}
