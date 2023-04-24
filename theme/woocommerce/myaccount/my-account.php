<?php

/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>



<div class="u-column1 col-1 text-center bg-gray-700 text-gray-400" id="customer_login">

    <div class="inner container">

        <?php
            if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
            }
        ?>

        <h2 class="text-6xl text-white mt-0"><?php esc_html_e('Login', 'woocommerce'); ?></h2>

        <form class="woocommerce-form woocommerce-form-login login text-center" method="post">

            <?php do_action('woocommerce_login_form_start'); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide text-center">
                <label for="username" class="text-gray-400 text-base"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>">
                <?php // @codingStandardsIgnoreLine 
                ?>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide text-center">
                <label for="password" class="text-gray-400 text-base"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
            </p>

            <?php do_action('woocommerce_login_form'); ?>
            <p class="woocommerce-LostPassword lost_password text-center">
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text-gray-400"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
            </p>
            <p class="form-row text-center">
                <?php /* 
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
        </label>*/ ?>
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button type="submit" class="px-5 py-2 m-auto float-none bg-gray-900 uppercase text-white" name="login" value="<?php esc_attr_e('Account Login', 'woocommerce'); ?>"><?php esc_html_e('Account Login', 'woocommerce'); ?></button>
            </p>


            <?php do_action('woocommerce_login_form_end'); ?>

        </form>
    </div>





</div>

<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    <div class="emc-register-cta container text-center">
        <?php
        $cta_title = get_field('login_regsstration_cta', 'option');
        if ($cta_title) { ?><h2 class="heading-2 mb-8"><?php echo $cta_title; ?></h2><?php } else { ?>
            <h2 class="heading-2 text-gray-900 mb-8"><?php esc_html_e('Register', 'woocommerce'); ?></h2>
        <?php } ?>

        <?php
        $cta_content = get_field('cta_content', 'option');
        if ($cta_content) { ?><p class="text-lg text-gray-700 max-w-lg m-auto mb-8"><?php echo $cta_content; ?></p><?php } else { ?>
            <p class="text-lg text-gray-700"><?php esc_html_e('Please use the button bellow to register', 'woocommerce'); ?></p>
        <?php } ?>

        <?php
        $register_link = get_field('register_link', 'option');
        if ($register_link) { ?><a class="px-5 py-3 m-auto float-none bg-gray-900 uppercase text-white no-underline" href="<?php echo $register_link['url']; ?>"><?php echo $register_link['title']; ?></a><?php } else { ?>
            <a class="px-5 py-3 m-auto float-none bg-gray-900 uppercase text-white no-underline" href="<?php echo $register_link['url']; ?>">Register</a></p>
        <?php } ?>
    </div>



<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>