<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\AdminRole;

use CrazyCat\Admin\Helper\Permission;
use CrazyCat\Admin\Model\Admin\Role as Model;
use CrazyCat\Framework\App\Io\Http\Response;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Delete extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    protected function execute()
    {
        $success = false;

        if (!($id = $this->request->getParam('id'))) {
            $message = __('Please specify an item.');
        } else {
            /* @var $model \CrazyCat\Framework\App\Component\Module\Model\AbstractModel */
            $model = $this->objectManager->create(Model::class)->load($id);
            if ($model->getId()) {
                if (!$this->objectManager->get(Permission::class)->canAccessRole($model)) {
                    $this->messenger->addError(__('You do not have the permission.'));
                    return $this->redirect('admin/admin_role');
                }

                try {
                    $model->delete();
                    $success = true;
                    $message = null;
                } catch (\Exception $e) {
                    $message = $e->getMessage();
                }
            } else {
                $message = __('Item with specified ID does not exist.');
            }
        }

        $this->response->setType(Response::TYPE_JSON)->setData(['success' => $success, 'message' => $message]);
    }
}
