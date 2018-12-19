<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\Log;

use CrazyCat\Admin\Block\Log\Grid as GridBlock;
use CrazyCat\Admin\Model\Log\Collection;
use CrazyCat\Admin\Model\Admin\Collection as AdminCollection;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Grid extends \CrazyCat\Core\Controller\Backend\AbstractGridAction {

    protected function construct()
    {
        $this->init( Collection::class, GridBlock::class );
    }

    /**
     * @param array $collectionData
     * @return array
     */
    protected function processData( $collectionData )
    {
        $adminIds = [];
        foreach ( $collectionData['items'] as $item ) {
            $adminIds[] = $item['admin_id'];
        }

        /* @var $adminCollection \CrazyCat\Admin\Model\Admin\Collection */
        $adminCollection = $this->objectManager->get( AdminCollection::class )
                ->addFieldToFilter( 'id', [ 'in' => array_unique( $adminIds ) ] );

        foreach ( $collectionData['items'] as &$item ) {
            $adminModel = $adminCollection->getItemById( $item['admin_id'] );
            $item['admin_id'] = sprintf( '%s ( ID: %d )', $adminModel->getData( 'name' ), $adminModel->getId() );
        }
        return $collectionData;
    }

}
