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
class View extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        if ( !( $id = $this->request->getParam( 'id' ) ) ) {
            $this->messenger->addError( __( 'Please specifiy an item.' ) );
            $this->redirect( 'admin/admin' );
        }

        /* @var $model \CrazyCat\Framework\App\Module\Model\AbstractModel */
        $model = $this->objectManager->create( Model::class )->load( $id );
        $pageTitle = $model->getId() ?
                __( 'Edit Administrator `%1` [ ID: %2 ]', [ $model->getName(), $model->getId() ] ) :
                __( 'Create Administrator' );

        $this->setPageTitle( $pageTitle )->render();
    }

}
