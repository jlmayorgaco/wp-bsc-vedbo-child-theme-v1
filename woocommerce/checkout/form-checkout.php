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
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<div class="bsc__checkout">
	<form name="checkout" method="post" class="bsc__checkout checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">


		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="col2-set" id="customer_details" >
				<div class="col-1">

					<div class="bsc__checkout__header">
						<img src="<?php echo get_template_directory_uri().'-child/images/BSC_Checkout_Logo.png'; ?>">
					</div>

					<div class="checkout__contact" style="display:none">
					<div class="contact__head">
						<h2 class="checkout__title">Contacto</h2>
						<?php if (!is_user_logged_in()) : ?>
							<a class="checkout__link" href="<?php echo esc_url(wp_login_url()); ?>">Iniciar Sesión</a>
						<?php endif; ?>
					</div>
						<div class="contact__form">
							<div class="form__field">

								<!-- ---------------------------- -->
								<!-- BILLING_FORM::EMAIL -------- -->
								<!-- ---------------------------- -->
								<!-- WooCommerce's Billing Email Field -->
								<?php 
									woocommerce_form_field(
										'billing_email',
										[
											'type'        => 'email',
											'label'       => '',
											'placeholder' => 'Correo electrónico',
											'required'    => true,
											'class'       => ['form-row-wide', 'validate-required', 'validate-email'],
											'autocomplete'=> 'email username',
										],
										WC()->checkout->get_value('billing_email')
									); 
            					?>
							</div>
						</div>
						<div class="contact__footer">
						<label class="form-row-wide">
							<input class="field__notify" name="notify" type="checkbox" value="yes" <?php checked(WC()->checkout->get_value('notify'), 'yes'); ?>>
							Enviarme novedades y ofertas por correo electrónico
						</label>
						</div>
					</div>

					<br>

					<?php do_action( 'woocommerce_checkout_billing' ); ?>
				</div>

				<div class="col-2">
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>
			</div>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>
		
		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
		
		
		<h3 id="order_review_heading" style="display:none">
			<?php esc_html_e( 'Your order', 'woocommerce' ); ?>
		</h3>
		
		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

	</form>
</div>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
