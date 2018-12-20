<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Helper;

use CrazyCat\Admin\Model\Admin;
use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\ObjectManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Permission {

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    protected $session;

    public function __construct( ObjectManager $objectManager, Session $session )
    {
        $this->objectManager = $objectManager;
        $this->session = $session;
    }

    /**
     * Super administrators can access all,
     *     other administrators can access themseives and down level administrators.
     * 
     * @param \CrazyCat\Admin\Model\Admin|int $targetAdmin
     * @return boolean
     */
    public function canAccessAdmin( $targetAdmin )
    {
        /* @var $admin \CrazyCat\Admin\Model\Admin */
        $admin = $this->session->getAdmin();
        if ( $admin->getRole()->getIsSuper() ) {
            return true;
        }

        /* @var $targetAdmin \CrazyCat\Admin\Model\Admin */
        if ( is_numeric( $targetAdmin ) ) {
            $targetAdmin = $this->objectManager->create( Admin::class )->load( $targetAdmin );
        }
        return $targetAdmin->getId() == $admin->getId() ||
                strpos( $targetAdmin->getRole()->getPath(), ( $admin->getRole()->getPath() . '/' ) ) === 0;
    }

    /**
     * Super administrators can access all,
     *     other administrators can access down level roles.
     * 
     * @param \CrazyCat\Admin\Model\Admin\Role|int $targetRole
     * @return boolean
     */
    public function canAccessRole( $targetRole )
    {
        /* @var $admin \CrazyCat\Admin\Model\Admin */
        $admin = $this->session->getAdmin();
        if ( $admin->getRole()->getIsSuper() ) {
            return true;
        }

        /* @var $targetRole \CrazyCat\Admin\Model\Admin\Role */
        if ( is_numeric( $targetRole ) ) {
            $targetRole = $this->objectManager->create( Admin\Role::class )->load( $targetRole );
        }
        return strpos( $targetRole->getPath(), ( $admin->getRole()->getPath() . '/' ) ) === 0;
    }

}
