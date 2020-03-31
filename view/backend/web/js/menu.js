/* 
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery', 'utility' ], function( $, utility ) {

    return function( options ) {

        var opts = $.extend( true, {
            el: null,
            baseUrl: null
        }, options );

        var menu = $( opts.el );

        var getUrlPath = function( url ) {
            if ( url.indexOf( opts.baseUrl ) === -1 ) {
                return false;
            }
            var pathParts = url.substr( opts.baseUrl.length ).split( '/' );
            var urlPath = '/';
            if ( pathParts[1] && pathParts[2] && pathParts[3] ) {
                urlPath += pathParts[1] + '/' + pathParts[2] + '/' + pathParts[3] + '/';
            }
            return urlPath;
        };

        var currentPath = getUrlPath( window.location.href );
        menu.find( 'a' ).each( function() {
            var el = $( this );
            if ( getUrlPath( el.attr( 'href' ) ) === currentPath ) {
                el.addClass( 'current' );
            }
        } );

        menu.find( 'a.current' ).parents( 'li' ).addClass( 'active' );
        menu.find( 'li.parent' ).not( '.active' ).on( 'click', '> a', function() {
            $( this ).closest( 'li' ).find( '> ul' ).slideToggle();
        } );

        menu.find( 'li' ).not( '.parent' ).on( 'click', '> a', function( evt ) {
            if ( !evt.shiftKey && !evt.ctrlKey ) {
                utility.loading( true );
            }
        } );

    };

} );