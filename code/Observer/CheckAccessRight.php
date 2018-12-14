<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\Io\Http\Request;
use CrazyCat\Framework\App\Session\Messenger;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class CheckAccessRight {

    /**
     * @var \CrazyCat\Framework\App\Session\Messenger
     */
    private $messenger;

    /**
     * @var \CrazyCat\Framework\App\Io\Http\Request
     */
    private $request;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct( Messenger $messenger, Request $request, Session $session )
    {
        $this->messenger = $messenger;
        $this->request = $request;
        $this->session = $session;
    }

    /**
     * @param \CrazyCat\Framework\Data\Object $observer
     */
    public function execute( $observer )
    {
        $requestPath = $this->request->getFullPath( '/' );
        if ( $this->session->isLoggedIn() ) {
            if ( !$this->session->getAdmin()->getRole()->getData( 'is_super' ) &&
                    !in_array( $requestPath, array_merge( [ 'system/index/index' ], $this->session->getAdmin()->getRole()->getPermissions() ) ) ) {
                $this->messenger->addError( __( 'You do not have the permission.' ) );
                $observer->getAction()->skipRunning()->redirect( 'admin' );
            }
        }
        else if ( !in_array( $requestPath, [ 'system/index/login', 'system/index/loginpost', 'system/index/logout' ] ) ) {
            $observer->getAction()->skipRunning()->redirect( 'system/index/login' );
        }
    }

}
