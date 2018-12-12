<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Model\Source;

use CrazyCat\Admin\Model\Admin\Role\Collection;
use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\Utility\Html;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class AdminRoles {

    /**
     * @var array
     */
    private $options;

    /**
     * @var \CrazyCat\Admin\Model\Admin\Role\Collection
     */
    private $roleCollecion;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct( Session $session, ObjectManager $objectManager )
    {
        $this->roleCollecion = $objectManager->create( Collection::class )->addOrder( 'title' );
        $this->session = $session;

        if ( $session->getAdmin() ) {
            /**
             * Non-super administrator is only able to see roles
             *     of which level are lower than him/her or the one
             *     he/she belongs to.
             */
            $adminRole = $session->getAdmin()->getRole();
            if ( !$adminRole->getIsSuper() ) {
                $this->roleCollecion->addFieldToFilter( [
                        [ 'field' => 'path', 'conditions' => [ 'like' => $adminRole->getPath() . '/%' ] ],
                        [ 'field' => 'id', 'conditions' => [ 'eq' => $adminRole->getId() ] ] ] );
            }
        }
    }

    /**
     * @param array $roleGroups
     * @param int $roleId
     * @param int $level
     * @return array
     */
    private function getSortedRoles( $roleGroups, $excludeId = null, $roleId = 0, $level = 0 )
    {
        if ( !isset( $roleGroups[$roleId] ) ) {
            return [];
        }
        $roles = [];
        foreach ( $roleGroups[$roleId] as $roleModel ) {
            if ( $excludeId === $roleModel->getId() ) {
                continue;
            }
            $roles[] = [ 'label' => sprintf( '%s%s [ ID: %d ]', str_repeat( Html::spaceString(), $level * 4 ), $roleModel->getData( 'title' ), $roleModel->getId() ), 'value' => $roleModel->getId() ];
            $roles = array_merge( $roles, $this->getSortedRoles( $roleGroups, $excludeId, $roleModel->getId(), $level + 1 ) );
        }
        return $roles;
    }

    /**
     * @param int|null $excludeId
     * @return array
     */
    public function toOptionArray( $excludeId = null )
    {
        if ( $excludeId !== null || $this->options === null ) {
            $roleGroups = [];
            foreach ( $this->roleCollecion as $roleModel ) {
                if ( !isset( $roleGroups[$roleModel->getData( 'parent_id' )] ) ) {
                    $roleGroups[$roleModel->getData( 'parent_id' )] = [];
                }
                $roleGroups[$roleModel->getData( 'parent_id' )][] = $roleModel;
            }
            $adminRole = $this->session->getAdmin()->getRole();
            $rootRoleId = $adminRole->getIsSuper() ? 0 : $adminRole->getParentId();
            $this->options = $this->getSortedRoles( $roleGroups, $excludeId, $rootRoleId );
        }
        return $this->options;
    }

}
