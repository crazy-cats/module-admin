<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Admin\Block\Admin\Grid */
?>
<div id="admin-list">
    <admin-list></admin-list>
</div>
<script type="text/javascript">
// <![CDATA[
    require( [ 'js/vue', 'CrazyCat/Admin/js/ui/list' ], function( Vue, list ) {

        var sourceUrl = '<?php echo getUrl( 'admin/admin/grid' ); ?>';
        var fieldConfig = <?php echo $this->getFieldConfig(); ?>;

        new Vue( {
            el: '#admin-list',
            components: {
                'admin-list': list( sourceUrl, fieldConfig )
            }
        } );

    } );
// ]]>
</script>