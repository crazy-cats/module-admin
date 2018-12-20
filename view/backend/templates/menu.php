<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Admin\Block\Menu */
?>
<div class="main-menu" id="main-menu">
    <?php echo $this->getMenuHtml(); ?>
</div>

<script type="text/javascript">
// <![CDATA[
    require( [ 'CrazyCat/Admin/js/menu' ], function( menu ) {
        menu( {el: '#main-menu'} );
    } );
// ]]>
</script>