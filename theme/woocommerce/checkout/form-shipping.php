<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
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
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-shipping-fields">
	<div class="emc_shipping_address">
		<div class="woocommerce-shipping-fields__field-wrapper">
			<?php
			$fields = $checkout->get_checkout_fields( 'shipping' );

			//output our full name field, our email and phone
			foreach ( $fields as $key => $field ) {
				if(($key == 'shipping_first_name') || ($key == 'shipping_email') || ($key == 'shipping_phone')) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
			}

			?>
		
			<!-- Add a container for our address lookup -->
			<p class="form-row form-row form-row-wide" id="shipping_address_lookup" data-priority="13"><label for="shipping_address_lookup" class="">Shipping Address</label></p>

			<!-- now add a link to allow users to manually select address if needed -->
			<p class="form-row form-row form-row-wide manual_shipping_address_entry" id="manual_shipping_address_entry" data-priority="14">
				<a class="manual-shipping-address-entry" href="#">Or enter address manually</a>
				<a class="manual-shipping-address-cancel" href="#">Cancel manual address entry</a>
			</p>

			<?php
			//show the remainder of the shipping fields
			foreach ( $fields as $key => $field ) {
				if($key == 'shipping_country' || $key == 'shipping_address_1' || $key == 'shipping_address_2' || $key == 'shipping_city' || $key == 'shipping_state' || $key == 'shipping_postcode') {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
			}
			?>
		</div>
	</div>
</div>