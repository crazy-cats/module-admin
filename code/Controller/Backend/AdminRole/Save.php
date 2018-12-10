<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\AdminRole;

use CrazyCat\Admin\Model\Admin\Role as Model;
use CrazyCat\Framework\App\Url;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Save extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        /* @var $model \CrazyCat\Admin\Model\Admin\Role */
        $model = $this->objectManager->create( Model::class );

        $data = $this->request->getPost( 'data' );
        if ( empty( $data[$model->getIdFieldName()] ) ) {
            unset( $data[$model->getIdFieldName()] );
        }

        try {
            $id = $model->addData( $data )->save()->getId();
            $this->messenger->addSuccess( __( 'Successfully saved.' ) );
        }
        catch ( \Exception $e ) {
            $id = isset( $data[Url::ID_NAME] ) ? $data[Url::ID_NAME] : null;
            $this->messenger->addError( $e->getMessage() );
        }

        if ( !$this->request->getPost( 'to_list' ) && $id !== null ) {
            return $this->redirect( 'admin/admin_role/edit', [ Url::ID_NAME => $id ] );
        }
        return $this->redirect( 'admin/admin_role' );
    }

}
