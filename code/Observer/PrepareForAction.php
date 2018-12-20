<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Framework\App\Config;
use CrazyCat\Framework\App\Timezone;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class PrepareForAction {

    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    /**
     * @var \CrazyCat\Framework\App\Timezone
     */
    private $timezone;

    public function __construct( Config $config, Timezone $timezone )
    {
        $this->config = $config;
        $this->timezone = $timezone;
    }

    public function execute()
    {
        $this->timezone->setTimezone( new \DateTimeZone( $this->config->getValue( 'general/timezone' ) ) );
    }

}
