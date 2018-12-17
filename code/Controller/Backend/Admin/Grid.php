<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\Admin;

use CrazyCat\Admin\Block\Admin\Grid as GridBlock;
use CrazyCat\Admin\Model\Admin\Collection;
use CrazyCat\Admin\Model\Admin\Role\Collection as RoleCollection;
use CrazyCat\Core\Model\Source\YesNo as SourceYesNo;

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

        /**
         * Non-super administrator is only able to see records under roles
         *     of which level are lower than him/her, or the one he/she 
         *     belongs to.
         */
        $admin = $this->session->getAdmin();
        $adminRole = $admin->getRole();
        if ( !$adminRole->getIsSuper() ) {
            $childRoleIds = $this->objectManager->create( RoleCollection::class )
                    ->addFieldToFilter( 'path', [ 'like' => $adminRole->getPath() . '/%' ] )
                    ->getAllIds();
            if ( empty( $childRoleIds ) ) {
                $this->collection->addFieldToFilter( 'id', [ 'eq' => $admin->getId() ] );
            }
            else {
                $this->collection->addFieldToFilter( [
                        [ 'field' => 'id', 'conditions' => [ 'eq' => $admin->getId() ] ],
                        [ 'field' => 'role_id', 'conditions' => [ 'in' => $childRoleIds ] ] ] );
            }
        }
    }

    /**
     * @param array $collectionData
     * @return array
     */
    protected function processData( $collectionData )
    {
        $sourceYesNo = $this->objectManager->get( SourceYesNo::class );
        foreach ( $collectionData['items'] as &$item ) {
            $item['enabled'] = $sourceYesNo->getLabel( $item['enabled'] );
        }
        return $collectionData;
    }

}
