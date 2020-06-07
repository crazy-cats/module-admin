<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Observer;

use CrazyCat\Admin\Model\Admin;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class ProcessLogin
{
    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    private $objectManager;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    private $session;

    public function __construct(
        \CrazyCat\Framework\App\ObjectManager $objectManager,
        \CrazyCat\Admin\Model\Session $session
    ) {
        $this->objectManager = $objectManager;
        $this->session = $session;
    }

    /**
     * @param \CrazyCat\Framework\Data\DataObject $observer
     * @return void
     * @throws \ReflectionException
     */
    public function execute($observer)
    {
        $post = $observer->getPost();
        $admin = $this->objectManager->create(Admin::class)->login($post['username'], $post['password']);
        $this->session->setAdminId($admin->getData('id'));
    }
}
