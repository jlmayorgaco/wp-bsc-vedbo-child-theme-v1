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
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="bsc__checkout woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<h3 id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
			</label>
		</h3>

		<div class="shipping_address">
			
			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<h3 class="checkout__title">
				<?php esc_html_e( 'Envio', 'woocommerce' ); ?>
			</h3>

			<div class="woocommerce-shipping-fields__field-wrapper form__fields">
				<?php

				$mapFieldKeyToPlaceholder = [
					'shipping_address_1' => 'Dirección',
					'shipping_address_2' => 'Información adicional (Casa, apartamento, etc.)',
					'shipping_postcode' => 'Código postal',
				];

				$orderedKeys = [
					'shipping_country',
					'shipping_state',
					'shipping_city',
					'shipping_address_1',
					'shipping_address_2',
					'shipping_postcode' 
				];

				$fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ($orderedKeys as $key) {
					if (isset($fields[$key])) {
						$field = $fields[$key];
	
						// Add custom classes
						$field['class'] = [
							'bsc__field--no-label',
							'bsc__field--' . $key
						];
	
						// Set the placeholder if the key exists in the placeholder map
						if (isset($mapFieldKeyToPlaceholder[$key])) {
							$field['placeholder'] = $mapFieldKeyToPlaceholder[$key];
						}
	
						// Render the form field in the specified order
						woocommerce_form_field($key, $field, $checkout->get_value($key));
					}
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
