<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Admin\Model\Session;
use CrazyCat\Framework\App\Io\Http\Session\Messenger;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class CheckPermission
{
    /**
     * @var \CrazyCat\Framework\App\Io\Http\Session\Messenger
     */
    private $messenger;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct(Messenger $messenger, Session $session)
    {
        $this->messenger = $messenger;
        $this->session = $session;
    }

    /**
     * @param \CrazyCat\Framework\Data\DataObject $observer
     * @throws \ReflectionException
     */
    public function execute($observer)
    {
        $requestPath = $observer->getAction()->getRequest()->getFullPath('/');
        if ($this->session->isLoggedIn()) {
            if (!$this->session->getAdmin()->getRole()->getData('is_super') &&
                !in_array(
                    $requestPath,
                    array_merge(['admin/index/index'], $this->session->getAdmin()->getRole()->getPermissions())
                )) {
                $this->messenger->addError(__('You do not have the permission.'));
                $observer->getAction()->skipRunning()->redirect('admin');
            }
        } elseif (!in_array(
            $requestPath,
            [
                'system/index/login',
                'system/index/login_post',
                'system/index/logout',
                'system/translate/source'
            ]
        )) {
            $observer->getAction()->skipRunning()->redirect('system/index/login');
        }
    }
}
