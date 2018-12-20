/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery', 'utility' ], function( $, utility ) {

    return function( options ) {

        var opts = $.extend( true, {
            el: null
        }, options );

        var menu = $( opts.el );

        menu.find( 'a.current' ).parents( 'li' ).addClass( 'active' );

        menu.find( 'li.parent' ).not( '.active' ).on( 'click', '> a', function() {
            $( this ).closest( 'li' ).find( '> ul' ).slideToggle();
        } );

        menu.find( 'li' ).not( '.parent' ).on( 'click', '> a', function() {
            utility.loading( true );
        } );

    };

} );