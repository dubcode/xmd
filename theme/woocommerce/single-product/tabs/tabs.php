<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
$product_tabs_intro = get_field( 'product_tabs' );

if ( ! empty( $product_tabs ) ) : ?>


	<?php // Display the optional header ?>
	<?php if( $product_tabs_intro['enable_header'] ) : ?>
		<?php get_template_part( 
			'template-parts/blocks/block',
			'header',
			array( 'header' => $product_tabs_intro['header_text'], 'text' => $product_tabs_intro['header_description'], 'button' => $product_tabs_intro['header_button'] ) 
		) ?>
	<?php endif ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		<div class="tabs-header-container w-full overflow-x-scroll scrollbar-hide">
			<ul class="tabs wc-tabs flex justify-center min-w-[640px]" role="tablist">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab !flex items-center flex-grow w-auto p-0" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a class="block px-10 py-5 md:py-8" href="#tab-<?php echo esc_attr( $key ); ?>">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="woocommerce-tabs-panel woocommerce-tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
				<div class="container">
					<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif; ?>
