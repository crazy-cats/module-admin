<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Model;

use CrazyCat\Admin\Model\Admin\Role;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Admin extends \CrazyCat\Framework\App\Component\Module\Model\AbstractModel
{
    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \CrazyCat\Admin\Model\Admin\Role
     */
    protected $role;

    public function __construct(
        \CrazyCat\Framework\App\Db\Manager $dbManager,
        \CrazyCat\Framework\App\EventManager $eventManager,
        \CrazyCat\Framework\App\ObjectManager $objectManager,
        array $data = []
    ) {
        parent::__construct($eventManager, $dbManager, $data);

        $this->objectManager = $objectManager;
    }

    /**
     * @return void
     */
    protected function construct()
    {
        $this->init('admin', 'admin');
    }

    /**
     * @return void
     */
    protected function beforeSave()
    {
        parent::beforeSave();

        $now = date('Y-m-d H:i:s');
        $this->setData('updated_at', $now);
        if (!$this->getId()) {
            $this->setData('created_at', $now);
        }
    }

    /**
     * @param string $adminPasswordHash
     * @param string $inputPassword
     * @return bool
     */
    public function verifyPassword($adminPasswordHash, $inputPassword)
    {
        return password_verify($inputPassword, $adminPasswordHash);
    }

    /**
     * @param string $password
     * @return string
     */
    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $username
     * @param string $password
     * @return $this
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function login($username, $password)
    {
        $admin = $this->conn->fetchRow(
            sprintf(
                'SELECT * FROM `%s` WHERE `username` = ? AND `enabled` = 1',
                $this->conn->getTableName($this->mainTable)
            ),
            [$username]
        );
        if (!empty($admin)) {
            if ($this->verifyPassword($admin['password'], $password)) {
                return $this->setData($admin);
            }
        }
        throw new \Exception(__('User does not exist or password does not match the username.'));
    }

    /**
     * @return \CrazyCat\Admin\Model\Admin\Role|null
     * @throws \ReflectionException
     */
    public function getRole()
    {
        if ($this->role === null) {
            if (!($roleId = $this->getData('role_id'))) {
                throw new \Exception(__('Impossible to get a role without role ID.'));
            }
            $this->role = $this->objectManager->create(Role::class)->load($roleId);
        }
        return $this->role;
    }
}
