<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Admin\Model\Log;
use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\Io\Http\Request;
use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\Utility\Http;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class LogAction {

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    private $objectManager;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct( Session $session, ObjectManager $objectManager )
    {
        $this->objectManager = $objectManager;
        $this->session = $session;
    }

    /**
     * @param \CrazyCat\Framework\App\Io\Http\Request $request
     * @return boolean
     */
    private function filterActions( $request )
    {
        if ( $request->getParam( Request::AJAX_PARAM ) ) {
            return false;
        }
        if ( in_array( $request->getActionName(), [ 'index', 'login', 'logout' ] ) ) {
            return false;
        }
        return true;
    }

    /**
     * @param \CrazyCat\Framework\Data\Object $observer
     */
    public function execute( $observer )
    {
        /* @var $request \CrazyCat\Framework\App\Io\Http\Request */
        $request = $observer->getAction()->getRequest();

        if ( !$this->filterActions( $request ) ) {
            return;
        }

        $this->objectManager->create( Log::class )->addData( [
            'admin_id' => $this->session->getAdmin()->getId(),
            'action' => $request->getFullPath( '/' ),
            'data' => json_encode( $request->getParams() ),
            'ip' => Http::getRemoteIp(),
            'created_at' => date( 'Y-m-d H:i:s' )
        ] )->save();
    }

}
