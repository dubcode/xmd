<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="emc-empty-cart-wrapper">
    <?php
	//add our mobile menu under banner content
	include __DIR__ . '/../template-parts/content/content-mobile-menu.php';

	//add our main navbar
	get_template_part('template-parts/nav/main', 'header');

	//add our mega menus
	get_template_part('template-parts/nav/mega', 'menus'); 	
	?>

    <div class="empty-cart-header">
        <?php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
        }
        ?>

        <div class="empty-cart-header-content">
            <h1 class="empty-cart-heading">Your basket is empty</h1>

            <p class="empty-cart-description">
                We have a huge range of products for you to browse in the shop..
                Please <a class="thank-you-header-link" href="/contact-us">contact us</a> if you cannot find the product you are looking for.
            </p>

            <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
                <a class="button-primary button-col-primary" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?= esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Go to shop', 'woocommerce' ) ) ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>
