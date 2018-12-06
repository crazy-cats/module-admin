<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Controller\Backend;

use CrazyCat\Framework\App\Io\Http\Response;
use CrazyCat\Framework\App\Module\Controller\Backend\Context;
use CrazyCat\Framework\Utility\StaticVariable;
use CrazyCat\Admin\Block\AbstractGrid;

/**
 * @category CrazyCat
 * @package CrazyCat\Framework
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
abstract class AbstractGridAction extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    const DEFAULT_PAGE_SIZE = 20;

    /**
     * @var \CrazyCat\Admin\Block\AbstractGrid
     */
    protected $block;

    /**
     * @var \CrazyCat\Framework\App\Module\Model\AbstractCollection
     */
    protected $collection;

    public function __construct( Context $context )
    {
        parent::__construct( $context );

        $this->construct();
    }

    /**
     * @param string $collectionClass
     */
    protected function init( $collectionClass, $blockClass )
    {
        $this->block = $this->objectManager->create( $blockClass );
        $this->collection = $this->objectManager->create( $collectionClass );
    }

    /**
     * @return void
     */
    protected function addFilters( $filters )
    {
        foreach ( $this->block->getFields() as $field ) {
            switch ( $field['filter']['type'] ) {

                case AbstractGrid::FIELD_TYPE_SELECT :
                    if ( $filters[$field['name']] != StaticVariable::NO_SELECTION ) {
                        $this->collection->addFieldToFilter( $field['name'], [ $field['filter']['condition'] => '%' . $filters[$field['name']] . '%' ] );
                    }
                    break;

                case AbstractGrid::FIELD_TYPE_TEXT :
                    if ( !empty( $filter = trim( $filters[$field['name']] ) ) ) {
                        $this->collection->addFieldToFilter( $field['name'], [ $field['filter']['condition'] => '%' . $filter . '%' ] );
                    }
                    break;
            }
        }
    }

    /**
     * @return void
     */
    protected function run()
    {
        if ( !empty( $filters = $this->request->getParam( 'filter' ) ) ) {
            $this->addFilters( $filters );
        }

        $this->collection->setPageSize( $this->request->getParam( 'limit' ) ?: self::DEFAULT_PAGE_SIZE  );

        if ( ( $page = $this->request->getParam( 'p' ) ) ) {
            $this->collection->setCurrentPage( $page );
        }

        $this->response->setType( Response::TYPE_JSON )->setData( $this->collection->toArray() );
    }

    /**
     * @return void
     */
    abstract protected function construct();
}
