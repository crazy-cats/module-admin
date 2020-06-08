/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define(['jquery', 'utility'], function ($, utility) {

    return function (options) {

        let opts = $.extend(true, {
            el: null,
            baseUrl: null
        }, options);

        let menu = $(opts.el);

        let getUrlPath = function (url) {
            if (url.indexOf(opts.baseUrl) === -1) {
                return false;
            }
            let pathParts = url.substr(opts.baseUrl.length).split('/');
            let urlPath = '/';
            if (pathParts[1] && pathParts[2] && pathParts[3]) {
                urlPath += pathParts[1] + '/' + pathParts[2] + '/' + pathParts[3] + '/';
            }
            return urlPath;
        };

        let currentPath = getUrlPath(window.location.href);
        let parentPath = currentPath ? currentPath.substr(currentPath.indexOf('/', 1)) + 'index/' : false;
        menu.find('a').each(function () {
            let el = $(this);
            let urlPath = getUrlPath(el.attr('href'));
            if (urlPath === currentPath || urlPath == parentPath) {
                el.addClass('current');
            }
        });

        menu.find('a.current').parents('li').addClass('active');
        menu.find('li.parent').not('.active').on('click', '> a', function () {
            $(this).closest('li').find('> ul').slideToggle();
        });

        menu.find('li').not('.parent').on('click', '> a', function (evt) {
            if (!evt.shiftKey && !evt.ctrlKey) {
                utility.loading(true);
            }
        });

    };

});