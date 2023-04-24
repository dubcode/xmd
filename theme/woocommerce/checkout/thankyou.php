<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="emc-thank-you-wrapper">
    <?php
	//add our mobile menu under banner content
	include __DIR__ . '/../template-parts/content/content-mobile-menu.php';

	//add our main navbar
	get_template_part('template-parts/nav/main', 'header');

	//add our mega menus
	get_template_part('template-parts/nav/mega', 'menus'); 	
	?>

    <div class="thank-you-header">
        <?php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
        }
        ?>

        <div class="thank-you-header-content">
            <h1 class="thank-you-heading">Your order has been placed</h1>

            <p class="thank-you-description">
                Your order confirmation has been sent to the email address you supplied.
                Please <a class="thank-you-header-link" href="/contact-us">contact us</a> if you have any queries.
            </p>

            <a class="button-primary button-col-primary" href="<?= wc_get_page_permalink( 'myaccount' ) ?>">Go to account</a>
        </div>
    </div>
</div>
