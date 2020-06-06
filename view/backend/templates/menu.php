<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Admin\Block\Menu */
?>
<div class="main-menu" id="main-menu">
    <?= $this->getMenuHtml(); ?>
</div>

<script type="text/javascript">
    // <![CDATA[
    require(['CrazyCat/Admin/js/menu'], function (menu) {
        menu({
            el: '#main-menu',
            baseUrl: '<?= $this->getBaseUrl(); ?>'
        });
    });
    // ]]>
</script>