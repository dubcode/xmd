<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $product;

// The related products header can be set globally or overridden per product
// First check the product, then fall back to global text
$productGroup = get_field('related_products', $product->get_id() );
$related_products_header = $productGroup['header_text'] || $productGroup['header_description'] ?
							array( 'header' => $productGroup['header_text'], 'text' => $productGroup['header_description'], 'button' => $productGroup['header_button'] ) :
							array( 'header' => get_field( 'related_posts_title', 'option' ), 'text' => get_field( 'related_posts_text', 'option' ) );

if( !empty( $productGroup['related_products'] ) ) : ?>
	
	<div class="single-product-related-products">
	
		<?php if( $productGroup['enable_header'] ) : ?>

			<?php get_template_part(
				'template-parts/blocks/block',
				'header',
				array( 'header' => $related_products_header['header'], 'text' => $related_products_header['text'], 'classes' => 'pb-0' )
			) ?>

		<?php endif ?>
		
		<section class="slider-block related-products-slider py-12 lg:py-24">
			<?php get_template_part( 'template-parts/blocks/product', 'slider' ); ?>
		</section>
	</div>

<?php endif ?>