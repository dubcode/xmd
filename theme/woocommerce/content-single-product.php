<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
// do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('emc-single-product', $product); ?>>
	<header class="woocommerce-single-product-header relative z-50 bg-grey-700">
		<?php
		//add our mobile menu under banner content
		include __DIR__ . '/../template-parts/content/content-mobile-menu.php';

		//add our main navbar
		get_template_part('template-parts/nav/main', 'header');

		//add our mega menus
		get_template_part('template-parts/nav/mega', 'menus'); 
		?>
	</header>

	<div class="single-product-intro bg-grey-700">
		<div class="single-product-info container pb-12 md:grid md:grid-cols-12 md:gap-3">
			<div class="single-product-images md:order-last md:col-span-6 lg:col-span-5 lg:col-start-8">
				<?php
				/**
				 * Hook: woocommerce_before_single_product_summary.
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action('woocommerce_before_single_product_summary');
				?>
			</div>


			<div class="single-product-content text-gray-400 md:col-span-6">
				<?php
				if (function_exists('yoast_breadcrumb')) {
					yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
				}
				?>

				<?php the_title('<h2 class="emc-single-product-title">', '</h2>'); ?>
				
				<div class="emc-single-product-price">
					<h4 class="price"><?= wc_price( wc_get_price_including_tax( $product ) ); ?></h4>
					<span class="price-vat-text">inc. VAT</span>
				</div>
				
				<div class="emc-single-product-description">
					<?php the_content(); ?>
				</div>
				
				<?php //woocommerce_template_single_rating(); ?>
				
				<?php //woocommerce_template_single_meta(); ?>
				
				<?php //woocommerce_template_single_sharing(); ?>

				<?php woocommerce_template_single_add_to_cart(); ?>

				<?php wc_get_template_part( 'single-product/product', 'usps' ); ?>
			</div>
		</div>
			</div>
	
	<div class="bg-white">
		<div class="emc-overview">
			<?php

			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked extramile_single_product_video - 17
			 * @hooked woocommerce_output_related_products - 20
			 * @hooked extramile_single_product_susbcribe - 50
			 */
			do_action('woocommerce_after_single_product_summary');

			?>
		</div>
	</div>
</div>

<?php do_action('woocommerce_after_single_product'); ?>