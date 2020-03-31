<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend\Admin;

use CrazyCat\Admin\Model\Admin;
use CrazyCat\Framework\App\Io\Http\Response;

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class MassDelete extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    protected function execute()
    {
        $success = false;

        if (empty($ids = $this->request->getParam('ids'))) {
            $message = __('Please specifiy an item.');
        } else {
            $model = $this->objectManager->create(Admin::class);
            foreach ($ids as $id) {
                $model->setData($model->getIdFieldName(), $id)->delete();
            }
            $success = true;
            $message = __('Successfully deleted.');
        }

        $this->response->setType(Response::TYPE_JSON)->setData(['success' => $success, 'message' => $message]);
    }
}
