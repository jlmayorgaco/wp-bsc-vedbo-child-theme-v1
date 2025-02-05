<?php
/**
 * "Order received" message.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-received.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 *
 * @var WC_Order|false $order
 */

defined( 'ABSPATH' ) || exit;
?>

<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received" style="display: none;">
	<?php
	/**
	 * Filter the message shown after a checkout is complete.
	 *
	 * @since 2.2.0
	 *
	 * @param string         $message The message.
	 * @param WC_Order|false $order   The order created during checkout, or false if order data is not available.
	 */
	$message = apply_filters(
		'woocommerce_thankyou_order_received_text',
		esc_html( __( 'Thank you. Your order has been received.', 'woocommerce' ) ),
		$order
	);

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $message;
	?>


</p>

<br>
<br>
<br>

<div class="bsc__thankyou-page">
	<!-- Header Section -->
	<div class="bsc__thankyou-header">
		<img class="logo" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/arcoirisProductosPDRN.png' ); ?>" alt="Thank You Rainbow" class="rainbow-image">
		<h2 class="thankyou-title">¡ <strong>Gracias</strong> por tu compra !</h2>
		<img class="wave" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/bsc__waving-line.png' ); ?>" alt="Thank You Rainbow" class="rainbow-image">
	</div>
</div>

<style>

<style>
.bsc__thankyou-page {
    display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	width: 100%;
}
.bsc__thankyou-header{
	text-align: center;
    width: 500px;
    margin: 0 auto;
	font-family: "Helvetica", sans-serif;

	margin-bottom: 60px;
}
.bsc__thankyou-header .logo{
	width: 250px;
}
.bsc__thankyou-header .wave{
    width: 80px;
}

.bsc__thankyou{
    margin-bottom: 30px;
}

.rainbow-image {
    max-width: 150px;
    margin-bottom: 15px;
}

.thankyou-title {
    font-size: 23px;
    font-weight: regular;
	letter-spacing: 2.5px;
	font-family: "Helvetica", sans-serif;
}
.thankyou-title strong{
	font-weight: bold;
}

</style>