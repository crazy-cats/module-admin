<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Helper;

use CrazyCat\Admin\Model\Admin;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Permission
{
    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    protected $session;

    public function __construct(
        \CrazyCat\Framework\App\ObjectManager $objectManager,
        \CrazyCat\Admin\Model\Session $session
    ) {
        $this->objectManager = $objectManager;
        $this->session = $session;
    }

    /**
     * Super administrators can access all,
     *     other administrators can access themseives and down level administrators.
     *
     * @param \CrazyCat\Admin\Model\Admin|int $targetAdmin
     * @return bool
     * @throws \ReflectionException
     */
    public function canAccessAdmin($targetAdmin)
    {
        /* @var $admin \CrazyCat\Admin\Model\Admin */
        $admin = $this->session->getAdmin();
        if ($admin->getRole()->getIsSuper()) {
            return true;
        }

        /* @var $targetAdmin \CrazyCat\Admin\Model\Admin */
        if (is_numeric($targetAdmin)) {
            $targetAdmin = $this->objectManager->create(Admin::class)->load($targetAdmin);
        }
        return $targetAdmin->getId() == $admin->getId() ||
            strpos($targetAdmin->getRole()->getPath(), ($admin->getRole()->getPath() . '/')) === 0;
    }

    /**
     * Super administrators can access all,
     *     other administrators can access down level roles.
     *
     * @param \CrazyCat\Admin\Model\Admin\Role|int $targetRole
     * @return bool
     * @throws \ReflectionException
     */
    public function canAccessRole($targetRole)
    {
        /* @var $admin \CrazyCat\Admin\Model\Admin */
        $admin = $this->session->getAdmin();
        if ($admin->getRole()->getIsSuper()) {
            return true;
        }

        /* @var $targetRole \CrazyCat\Admin\Model\Admin\Role */
        if (is_numeric($targetRole)) {
            $targetRole = $this->objectManager->create(Admin\Role::class)->load($targetRole);
        }
        return strpos($targetRole->getPath(), ($admin->getRole()->getPath() . '/')) === 0;
    }
}
