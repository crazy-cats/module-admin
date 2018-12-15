<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block\Admin;

use CrazyCat\Core\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Framework\App\Session\Backend as Session;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Grid extends \CrazyCat\Framework\App\Module\Block\Backend\AbstractGrid {

    const BOOKMARK_KEY = 'admin';

    /**
     * @var \CrazyCat\Core\Model\Source\YesNo
     */
    protected $sourceYesNo;

    public function __construct( SourceYesNo $sourceYesNo, Session $session, Context $context, array $data = array() )
    {
        parent::__construct( $session, $context, $data );

        $this->sourceYesNo = $sourceYesNo;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'ids' => true, ],
                [ 'name' => 'id', 'label' => __( 'ID' ), 'sort' => true, 'width' => 100, 'filter' => [ 'type' => 'text', 'condition' => 'eq' ] ],
                [ 'name' => 'name', 'label' => __( 'Name' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'like' ] ],
                [ 'name' => 'username', 'label' => __( 'Username' ), 'sort' => true, 'filter' => [ 'type' => 'text', 'condition' => 'like' ] ],
                [ 'name' => 'enabled', 'label' => __( 'Enabled' ), 'sort' => true, 'width' => 130, 'filter' => [ 'type' => 'select', 'condition' => 'eq', 'options' => $this->sourceYesNo->toOptionArray() ] ],
                [ 'label' => __( 'Actions' ), 'actions' => [
                        [ 'name' => 'edit', 'label' => __( 'Edit' ), 'url' => getUrl( 'admin/admin/edit' ) ],
                        [ 'name' => 'delete', 'label' => __( 'Delete' ), 'confirm' => __( 'Sure you want to remove this item?' ), 'url' => getUrl( 'admin/admin/delete' ) ]
                ] ] ];
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return getUrl( 'admin/admin/grid' );
    }

}
