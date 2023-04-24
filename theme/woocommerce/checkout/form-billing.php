<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
<div class="woocommerce-billing-fields">
	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		//output our full name field, our email and phone
		foreach ( $fields as $key => $field ) {
			if(($key == 'billing_first_name') || ($key == 'billing_email') || ($key == 'billing_phone')) {
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
		}
		?>
		
		<!-- Add a container for our address lookup -->
		<p class="form-row form-row form-row-wide" id="billing_address_lookup" data-priority="13"><label for="billing_address_lookup" class="">Delivery Address</label></p>

		<!-- now add a link to allow users to manually select address if needed -->
		<p class="form-row form-row form-row-wide manual_billing_address_entry" id="manual_billing_address_entry" data-priority="14">
			<a class="manual-billing-address-entry" href="#">Or enter address manually</a>
			<a class="manual-billing-address-cancel" href="#">Cancel manual address entry</a>
		</p>

		<?php
		//show the remainder of the billing fields
		foreach ( $fields as $key => $field ) {
			if($key == 'billing_country' || $key == 'billing_address_1' || $key == 'billing_address_2' || $key == 'billing_city' || $key == 'billing_state' || $key == 'billing_postcode') {
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
		}
		?>
	</div>
</div>