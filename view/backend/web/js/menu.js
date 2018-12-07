/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery' ], function( $ ) {

    return function( options ) {

        var opts = $.extend( {
            el: null
        }, options );

        var menu = $( opts.el );
        menu.find( 'a.current' ).parents( 'li' ).addClass( 'active' );

    };

} );