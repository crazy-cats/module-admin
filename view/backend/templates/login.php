<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Index\Block\Template */
?>
<div class="block block-login">
    <div class="block-title">
        <h1><?php echo __( 'Login' ) ?></h1>
    </div>
    <div class="block-content">
        <form method="post" action="<?php echo getUrl( 'admin/index/loginpost' ) ?>">
            <div class="field">
                <input type="text" name="username" class="input-text" autocomplete="off"
                       placeholder="<?php echo htmlEscape( __( 'Username' ) ) ?>" />
            </div>
            <div class="field">
                <input type="password" name="password" class="input-text"
                       placeholder="<?php echo htmlEscape( __( 'Password' ) ) ?>" />
            </div>
            <div class="actions">
                <button class="button" type="submit"><span><?php echo __( 'Login' ) ?></span></button>
            </div>
        </form>
    </div>
</div>