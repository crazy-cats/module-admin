<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Model\Source;

use CrazyCat\Admin\Model\Admin\Role\Collection;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class AdminRoles
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var \CrazyCat\Admin\Model\Admin\Role\Collection
     */
    protected $roleCollection;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    protected $session;

    public function __construct(
        \CrazyCat\Admin\Model\Session $session,
        \CrazyCat\Framework\App\ObjectManager $objectManager
    ) {
        $this->roleCollection = $objectManager->create(Collection::class)->addOrder('title');
        $this->session = $session;

        if ($session->getAdmin()) {
            /**
             * Non-super administrator is only able to see roles
             *     of which level are lower than him/her or the one
             *     he/she belongs to.
             */
            $adminRole = $session->getAdmin()->getRole();
            if (!$adminRole->getIsSuper()) {
                $this->roleCollection->addFieldToFilter(
                    [
                        ['field' => 'path', 'conditions' => ['like' => $adminRole->getPath() . '/%']],
                        ['field' => 'id', 'conditions' => ['eq' => $adminRole->getId()]]
                    ]
                );
            }
        }
    }

    /**
     * @param array $roleGroups
     * @param int   $roleId
     * @param int   $level
     * @return array
     * @throws \ReflectionException
     */
    private function getSortedRoles($roleGroups, $excludeId = null, $roleId = 0, $level = 0)
    {
        if (!isset($roleGroups[$roleId])) {
            return [];
        }
        $roles = [];
        foreach ($roleGroups[$roleId] as $roleModel) {
            if ($excludeId === $roleModel->getId()) {
                continue;
            }
            $roles[] = [
                'label' => sprintf(
                    '%s%s [ ID: %d ]',
                    str_repeat(spaceString(), $level * 4),
                    $roleModel->getData('title'),
                    $roleModel->getId()
                ),
                'value' => $roleModel->getId()
            ];
            $roles = array_merge(
                $roles,
                $this->getSortedRoles($roleGroups, $excludeId, $roleModel->getId(), $level + 1)
            );
        }
        return $roles;
    }

    /**
     * @param int|null $excludeId
     * @return array
     * @throws \Exception
     */
    public function toOptionArray($excludeId = null)
    {
        if ($excludeId !== null || $this->options === null) {
            $roleGroups = [];
            foreach ($this->roleCollection as $roleModel) {
                if (!isset($roleGroups[$roleModel->getData('parent_id')])) {
                    $roleGroups[$roleModel->getData('parent_id')] = [];
                }
                $roleGroups[$roleModel->getData('parent_id')][] = $roleModel;
            }
            $adminRole = $this->session->getAdmin()->getRole();
            $rootRoleId = $adminRole->getIsSuper() ? 0 : $adminRole->getParentId();
            $this->options = $this->getSortedRoles($roleGroups, $excludeId, $rootRoleId);
        }
        return $this->options;
    }
}
