<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

defined( 'ABSPATH' ) || exit;
?>

<div class="emc-cart-wrapper">
	<?php
	//add our mobile menu under banner content
	get_template_part( 'template-parts/content/content-mobile-menu' );

	//add our main navbar
	get_template_part('template-parts/nav/main', 'header');

	//add our mega menus
	get_template_part('template-parts/nav/mega', 'menus'); 	
	?>

	<div class="emc-cart-grid">
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php
			if (function_exists('yoast_breadcrumb')) {
				yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
			}
			?>

			<h2 class="cart-title">Your basket</h2>

			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<div class="cart woocommerce-cart-form__contents emc-custom-cart">
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<div class="cart-product-item">
							<div class="cart-product-item-info">
								<div class="cart-product-thumbnail cart-left">
									<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo $thumbnail; // PHPCS: XSS ok.
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
									}
									?>
								</div>
								
								<div class="cart-product-info">
									<div class="cart-product-details cart-middle">
										<div class="cart-product-name">
											<?php
											if ( ! $product_permalink ) {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
											} else {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
											}

											if($cart_item['quantity'] > 1) {
												echo ' x ' . $cart_item['quantity'];
											}

											do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
											?>
										</div>

										<div class="cart-product-price">
											<?php
												echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . ' inc. VAT'; // PHPCS: XSS ok.
											?>
										</div>
									</div>

									<div class="cart-product-information cart-right">
										<div class="cart-product-buttons">
											<?php
											$product_parent = $_product->get_parent_id();
											?>

											<a href="#" class="emc-product-edit basket-product-action-button" aria-label="Edit product">Edit</a>
											<a href="#" class="emc-product-update basket-product-action-button hidden" aria-label="Edit product" data-product_id="<?= esc_attr( $product_id ); ?>">Update</a>
											<?php
											echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												'woocommerce_cart_item_remove_link',
												sprintf(
													'<a href="%s" class="emc-product-remove basket-product-action-button" aria-label="%s" data-product_id="%s" data-product_sku="%s">Remove</a>',
													esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
													esc_html__( 'Remove product', 'woocommerce' ),
													esc_attr( $product_id ),
													esc_attr( $_product->get_sku() )
												),
												$cart_item_key
											);
											?>
										</div>
										
										<?php
										//is this a variation
										if ( $product_parent !== 0 ) { 
											$parent = wc_get_product($product_parent);
											
											$variations = $parent->get_children();
											
											if($variations) { ?>
												<div class="cart-product-variations-container">
													<ul class="cart-product-variations">
														<?php
														foreach($variations as $variation_id) { 
															$variation = new WC_Product_Variation($variation_id);
															$variableName = $variation->get_name();
															$nameSplit = explode(' - ', $variableName);
															$name = $nameSplit[1];
														?>
															<li class="cart-product-variation"><?= $name; ?></li>
														<?php 
														}
														?>
													</ul>
												</div>
											<?php 
											}
										} ?>
									</div>
								</div>
							</div>
							
							<div class="cart-product-item-actions hidden">
								<div class="product-edit-actions">
									<div class="edit-quantity">
										<p class="edit-quantity-text">Quantity</p>
										<?php
										if ( $_product->is_sold_individually() ) {
											$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
										} else {
											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $_product->get_max_purchase_quantity(),
													'min_value'    => '0',
													'product_name' => $_product->get_name(),
												),
												$_product,
												false
											);
										}

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
										?>
									</div>
									<div class="edit-variation">
										<?php
										if ( $product_parent !== 0 ) {
											echo '<p class="edit-variation-text">Variation</p>';
											
											//get our cart items
											foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
												if(intval($cart_item['product_id']) !== intval($_product)) {
													continue;
												}

												$cartVariable = $cart_item['variation_id'];
											}

											$parent = wc_get_product($product_parent);
											
											$variations = $parent->get_children();
											
											if($variations) { ?>
												<select name="product-variations" id="product-variations">
													<?php
													foreach($variations as $variation_id) { 
														$variation = new WC_Product_Variation($variation_id);
														$variableName = $variation->get_name();
														$nameSplit = explode(' - ', $variableName);
														$name = $nameSplit[1];

														if($variation == $cartVariable) {
															$selected = true;
														}
													?>
														<option value="<?= $variation_id; ?>" <?php if($selected) { echo 'selected'; } ?>><?= $name; ?></option>
													<?php 
													}
													?>
												</select>
											<?php 
											}
										} ?>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
		</form>

		<div class="cart-payment-sidebar">
			<div class="emc-sidebar-header">
				<div class="emc-order-summary">
					<div class="order-summary-header">
						<h5 class="order-summary-heading">Order Summary</h5>
					</div>
				</div>
			</div>

			<div class="emc-siderbar-content">
				<div class="emc-sidebar-subtotal">
					<p>Subtotal</p>
					<p><?php wc_cart_totals_subtotal_html(); ?></p>
				</div>

				<div class="emc-sidebar-delivery">
					<p>Delivery</p>

					<?php
					$current_shipping_method = WC()->session->get( 'chosen_shipping_methods' );
					$packages = WC()->shipping()->get_packages();
					$package = $packages[0];
					$available_methods = $package['rates'];
					foreach ($available_methods as $key => $method) {
						if($current_shipping_method[0] == $method->id){
							$price = $method->cost;
						}
					}

                    if($price == 0) {
                        $price = 'FREE';
                    } else {
                        $price = '£' . $price;
                    }

                    echo $price;
                    ?>
				</div>
				
				<div class="delivery-options-text-container">
					<p class="delivery-options-text">More delivery options available at checkout</p>
				</div>

				<div class="emc-sidebar-total">
					<p>Total</p>
					<p><?php wc_cart_totals_order_total_html(); ?></p>
				</div>

				<div class="emc-checkout-button">
					<a href="<?= wc_get_checkout_url() ?>" class="emc-custom-checkout-button">Checkout Securely</a>
				</div>

				<div class="accepted-payments">
					<p>We Accept</p>

					<ul class="checkout-payment-accept-icons">
						<?php
						$paymentIcons = get_field('checkout_payment_icons', 'option');

						foreach($paymentIcons as $paymentIcon) { 
							$image = $paymentIcon['payment_icon'];
							?>
							<li class="checkout-payment-icon">
								<img class="checkout-payment-icon-image" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
							</li>
						<?php } ?>
					</ul>
				</div>

				<div class="emc-continue-shopping-button">
					<a href="<?= wc_get_page_permalink( 'shop' ) ?>" class="emc-custom-continue-shopping-button">Continue Shopping</a>
				</div>
			</div>

			<?php
			$usps = get_field('basket_usps', 'option');

			if($usps) { ?>
				<ul class="cart-usps">
					<?php
					foreach($usps as $usp) {
						$imageType = $usp['usp_image_type'];
						$uspName = $usp['basket_usp'];
						?>
							<li class="cart-usp">
								<?php if($imageType == 'fa') { 
									echo $usp['fa_usp_image'];
								} else { ?>
									<img class="basket-usp-image" src="<?= $usp['usp_image']['url']; ?>" alt="<?= $usp['usp_image']['alt']; ?>" />
								<?php }

								echo '<span class="basket-usp-text">' . $uspName . '</span>'; ?>
							</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</div>
	</div>
</div>
