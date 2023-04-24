<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<div class="emc-checkout-wrapper">
    <?php
	//add our mobile menu under banner content
	include __DIR__ . '/../template-parts/content/content-mobile-menu.php';

	//add our main navbar
	get_template_part('template-parts/nav/main', 'header');

	//add our mega menus
	get_template_part('template-parts/nav/mega', 'menus'); 	
	?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
        <div class="emc-checkout-grid">
            <div class="checkout-form-container">
                <?php
                if (function_exists('yoast_breadcrumb')) {
                    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                }
                ?>

                <h2 class="checkout-title">Checkout securely</h2>

                <h5 class="checkout-details-heading"><span class="checkout-steps-number">1</span> Your details</h5>

                <?php if ( $checkout->get_checkout_fields() ) : ?>
                    <?php if(!is_user_logged_in()) { ?>
                        <ul class="nav emc-tabs" id="emc-tabs" role="tablist">
                            <li class="emc-tab-item" role="presentation">
                                <a href="#emc-tab-guest-content" class="emc-tab-link active" id="emc-tab-guest" data-bs-toggle="pill" data-bs-target="#emc-tab-guest-content" role="tab"
                                    aria-controls="tabs-tabGuestJustify" aria-selected="true">
                                    Guest Checkout
                                </a>
                            </li>

                            <li class="emc-tab-item" role="presentation">
                                <a href="#emc-tab-login-content" class="emc-tab-link" id="emc-tab-login" data-bs-toggle="pill" data-bs-target="#emc-tab-login-content" role="tab"
                                    aria-controls="tabs-tabLoginJustify" aria-selected="false">
                                    Login to my account
                                </a>
                            </li>
                        </ul>

                        <div class="emc-tab-content tab-content" id="tabs-tabContentJustify">
                            <div class="tab-pane fade show active" id="emc-tab-guest-content" role="tabpanel"
                                aria-labelledby="emc-tab-guest-content">
                                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                            </div>

                            <div class="tab-pane fade" id="emc-tab-login-content" role="tabpanel"
                                aria-labelledby="emc-tab-login-content">
                                    <?= do_shortcode('[emc_wc_login_form]'); ?>
                            </div>
                        </div>
                    <?php
                    } else { ?>
                        <div class="logged-in-details">
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        </div>
                    <?php
                    }
                    ?>

                    <h5 class="checkout-payment-details-heading"><span class="checkout-steps-number">2</span> Payment</h5>

                    <div class="checkout-payment-section">
                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php 
                            woocommerce_checkout_payment();
                            //do_action( 'woocommerce_checkout_order_review' ); 

                            if ( true === WC()->cart->needs_shipping_address() ) : ?>
                                <p id="ship-to-different-address">
                                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                        <input id="emc-ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" checked type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'Billing address the same as delivery address', 'woocommerce' ); ?></span>
                                    </label>
                                </p>
                            <?php
                            endif;

                            if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
                                <p class="form-row validate-required">
                                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                    <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" checked id="terms" />
                                        <span class="woocommerce-terms-and-conditions-checkbox-text"><?php wc_terms_and_conditions_checkbox_text(); ?></span>&nbsp;<abbr class="required" title="<?php esc_attr_e( 'required', 'woocommerce' ); ?>">*</abbr>
                                    </label>
                                    <input type="hidden" name="terms-field" value="1" />
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="checkout-shipping-section">
                        <h5 class="checkout-shipping-details-heading"><span class="checkout-steps-number">3</span> Shipping Details</h5>

                        <div class="checkout-shipping-details">
                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="checkout-order-summary">
                <div class="emc-sidebar-header">
                    <div class="emc-order-summary">
                        <div class="order-summary-header">
                            <h5 class="order-summary-heading">Order Summary</h5>
                        </div>
                    </div>
                </div>

                <div class="sidebar-products">
                    <?php
                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                            ?>

                            <div class="checkout-sidebar-product-item">
                                <div class="checkout-sidebar-product-image">
                                    <?php
                                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                    if ( ! $product_permalink ) {
                                        echo $thumbnail; // PHPCS: XSS ok.
                                    } else {
                                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                    }
                                    ?>
                                </div>

                                <div class="checkout-sidebar-product-info">
                                    <div class="sidebar-product-name">
                                        <?php
                                        if ( ! $product_permalink ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }

                                        if($cart_item['quantity'] > 1) {
                                            echo ' x' . $cart_item['quantity'];
                                        }
                                        ?>
                                    </div>
                                    
                                    <div class="sidebar-product-price">
                                        <?php
                                            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . ' inc. VAT'; // PHPCS: XSS ok.
                                        ?>
                                    </div>
                                    
                                    <?php
                                    //is this a variation
                                    $product_parent = $_product->get_parent_id();
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
                        <?php
                        }
                    }
                    ?>
                </div>

                <div class="checkout-product-sidebar-totals">
                    <h5 class="cost-totals-heading">Cost total</h5>

                    <?php
                    woocommerce_order_review();

                    //add our payment button here
                    $order_button_text = apply_filters( 'woocommerce_pay_order_button_text', __( 'Place order', 'woocommerce' ) );

                    echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button-primary button-col-primary' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine

                    ?>
                </div>

                <?php
			$usps = get_field('checkout_usps', 'option');

			if($usps) { ?>
				<ul class="checkout-usps">
					<?php
					foreach($usps as $usp) {
						$imageType = $usp['usp_image_type'];
						$uspName = $usp['checkout_usp'];
						?>
							<li class="checkout-usp">
								<?php if($imageType == 'fa') { 
									echo $usp['fa_usp_image'];
								} else { ?>
									<img class="checkout-usp-image" src="<?= $usp['usp_image']['url']; ?>" alt="<?= $usp['usp_image']['alt']; ?>" />
								<?php }

								echo '<span class="checkout-usp-text">' . $uspName . '</span>'; ?>
							</li>
					<?php } ?>
				</ul>
			<?php } ?>
            </div>
        </div>
    </form>
</div>