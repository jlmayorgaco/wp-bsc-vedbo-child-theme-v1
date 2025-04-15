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
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3 style="text-transform: initial;"> 
			<?php esc_html_e( 'Datos de Entrega', 'woocommerce' ); ?>
		</h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>





	<div class="woocommerce-billing-fields__field-wrapper form__fields">


		<?php

			$mapFieldKeyToPlaceholder = [
				'billing_email' => 'Correo electronico',
				'billing_first_name' => 'Nombre',
				'billing_last_name' => 'Apellidos',
				'billing_address_1' => 'Dirección',
				'billing_address_2' => 'Información adicional (Casa, apartamento, etc.)',
				'billing_postcode' => 'Código postal',
				'billing_phone' => 'Teléfono',
				// Add more mappings as needed
			];

			// Define the desired order of the fields
			$orderedKeys = [
				'billing_first_name',
				'billing_last_name',
				'billing_email',
				'billing_cc',
				'billing_phone',
				'billing_country',
				'billing_state',
				'billing_city',
				'billing_address_1',
				'billing_address_2',
				'billing_postcode',
				// Add other fields in the order you want them
			];

			$fields = $checkout->get_checkout_fields( 'billing' );
			
			// Loop through the ordered fields and render them
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

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>








<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>

