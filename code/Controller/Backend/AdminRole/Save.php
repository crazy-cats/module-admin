<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\AdminRole;

use CrazyCat\Admin\Helper\Permission;
use CrazyCat\Admin\Model\Admin\Role as Model;
use CrazyCat\Framework\App\Io\Http\Url;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Save extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    protected function execute()
    {
        /* @var $model \CrazyCat\Admin\Model\Admin\Role */
        $model = $this->objectManager->create(Model::class);

        $data = $this->request->getPost('data');
        if (empty($data['id'])) {
            unset($data['id']);
        } else {
            $model->load($data['id']);
            if (!$model->getId()) {
                $this->messenger->addError(__('Item with specified ID does not exist.'));
                return $this->redirect('admin/admin_role');
            }
            if (!$this->objectManager->get(Permission::class)->canAccessRole($model)) {
                $this->messenger->addError(__('You do not have the permission.'));
                return $this->redirect('admin/admin_role');
            }
        }

        try {
            $id = $model->addData($data)->save()->getId();
            $this->messenger->addSuccess(__('Successfully saved.'));
        } catch (\Exception $e) {
            $id = isset($data[Url::ID_NAME]) ? $data[Url::ID_NAME] : null;
            $this->messenger->addError($e->getMessage());
        }

        if (!$this->request->getPost('to_list') && $id !== null) {
            return $this->redirect('admin/admin_role/edit', [Url::ID_NAME => $id]);
        }
        return $this->redirect('admin/admin_role');
    }
}
