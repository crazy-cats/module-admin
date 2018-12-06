<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Admin\Block;

use CrazyCat\Framework\App\Cookies;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Index
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
abstract class AbstractGrid extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    const BOOKMARK_FILTER = 'filter';
    const BOOKMARK_SORTING = 'sorting';

    /**
     * field types
     */
    const FIELD_TYPE_SELECT = 'select';
    const FIELD_TYPE_TEXT = 'text';

    protected $template = 'CrazyCat\Index::grid';

    /**
     * @var \CrazyCat\Framework\App\Cookies
     */
    protected $cookies;

    /**
     * @var array
     */
    protected $bookmarks;

    public function __construct( Cookies $cookies, Context $context, array $data = array() )
    {
        parent::__construct( $context, $data );

        $this->cookies = $cookies;
    }

    /**
     * @return array
     */
    protected function getBookmarks()
    {
        if ( $this->bookmarks === null ) {
            $bookmarks = $this->cookies->getData( 'grid-bookmarks-' . static::COOKIES_BOOKMARK_KEY );
            $this->bookmarks = !empty( $bookmarks ) ? json_decode( $bookmarks, true ) : [ self::BOOKMARK_FILTER => [], self::BOOKMARK_SORTING => [] ];
        }
        return $this->bookmarks;
    }

    /**
     * @return array
     */
    protected function getFilters()
    {
        return $this->getBookmarks()[self::BOOKMARK_FILTER];
    }

    /**
     * @return array
     */
    protected function getSorting()
    {
        return $this->getBookmarks()[self::BOOKMARK_SORTING];
    }

    /**
     * Return array structure is like:
     * [
     *     [
     *         'name' => string,
     *         'label' => string,
     *         'sort' => boolean,
     *         'filter' => [
     *             'type' => string,
     *             'condition' => string
     *         ]
     *     ]
     * ]
     *
     * @return array
     */
    abstract public function getFields();

    /**
     * @return string
     */
    abstract public function getSourceUrl();
}
