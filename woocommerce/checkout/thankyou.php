<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<style>
.woocommerce-order-overview__order--col-title{
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 16px;
	font-weight: 700;
	text-transform: capitalize;
	letter-spacing:1px;
	color:  var(--color--black) !important;
}
.woocommerce-order-overview.woocommerce-thankyou-order-details.order_details{
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	justify-content: flex-end;
	align-items: center;
}
.woocommerce-thankyou-order-details li{
	padding-left: 40px;
}
.woocommerce-thankyou-order-details li:first-child{
	-webkit-order: 0;
    order: 0;
    -webkit-flex: 1 1 auto;
    flex: 1 1 auto;
    -webkit-align-self: auto;
    align-self: auto;
}
.woocommerce-thankyou-order-details{
	display: flex;
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
}
.woocommerce-order-overview.woocommerce-thankyou-order-details.order_details{
	display: flex !important;
    width: 100% !important;
    max-width: calc(0.75*var(--size-max-w)) !important;
    margin: 0 auto !important;
}
.product-details{
	display: flex !important;
	flex-direction: column;
    width: 100% !important;
    max-width: calc(0.75*var(--size-max-w)) !important;
    margin: 0 auto !important;
}

</style>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<div class="woocommerce-order-overview__order--col-title">
						Número de orden:
					</div>
					<strong>#<?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<div class="woocommerce-order-overview__order--col-title"><?php esc_html_e( 'Fecha:', 'woocommerce' ); ?></div>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>


				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
					<div class="woocommerce-order-overview__order--col-title"><?php esc_html_e( 'Metodo de Pago:', 'woocommerce' ); ?></div>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>


				<li class="woocommerce-order-overview__total total">
				<div class="woocommerce-order-overview__order--col-title"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></div>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

			</ul>

		<?php endif; ?>

		<div style="display:none">
			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
		</div>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>


	<?php if ( $order ) : ?>
		<br>
		<br>
		<br>
		<div class="product-details">
			<?php foreach ( $order->get_items() as $item_id => $item ) : 
				// Get product data
				$product = $item->get_product();
				$product_image = $product ? wp_get_attachment_url( $product->get_image_id() ) : wc_placeholder_img_src();
				$product_name = $item->get_name();
				$quantity = $item->get_quantity();
				$subtotal = $order->get_formatted_line_subtotal( $item );
			?>
			<hr class="bsc__order-review product-divider"> <!-- Divider between items -->
				<div class="bsc__order-review product-item">

					<!-- Product Image -->
					<?php if($product_image): ?>
						<img src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product_name ); ?>" class="product-image">
					<?php else: ?>
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/bsc__product_placeholder.webp' ); ?>" alt="<?php echo esc_attr( $product_name ); ?>" class="product-image">
					<?php endif; ?>

					<!-- Product Name and Quantity -->
					<p class="product-name">
						<?php echo esc_html( $product_name ); ?> <strong>x<?php echo esc_html( $quantity ); ?></strong>
					</p>

					<!-- Product Subtotal -->
					<p class="product-price">
						<?php echo wp_kses_post( $subtotal ); ?>
					</p>
				</div>
				
			<?php endforeach; ?>

			<br>
			<br>
			<br>
			<br>

			<!-- Return to Shop Button -->
			<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
			<p class="bsc__order-review return-to-shop">
				<a class="button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" 
				href="<?php echo esc_url( home_url( '/product-category/group-skin-care/sk-rutina/sk-rutina-s1-limpiadores-aceitosos/' ) ); ?>">
					¡ Ir a la <strong>tienda</strong> !
				</a>
			</p>
			<?php endif; ?>

			<br>
			<br>
			<br>
			<br>

		</div>

		<style>
			.bsc__order-review .product-details {
				margin-top: 60px;

			}

			.bsc__order-review.product-item {
				display: flex;
				flex-direction: row;
				align-items: flex-start;
				justify-content: space-between;
				margin-bottom: 15px;

				padding-top: 15px;
			}

			.bsc__order-review .product-image {
				width: 150px !important;
    			height: 150px !important;
				background-color: gray;
				margin-right: 10px;
			}

			.bsc__order-review .product-name {
				flex-grow: 1;
				text-align: left;
				font-size:16px;
				letter-spacing: 1px;
				color: var(--color--black);
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			}

			.bsc__order-review .product-price {
				font-weight: bold;
				text-align: right;
				padding-right: 14px;
				font-size:16px;
				color: var(--color--black);
				letter-spacing: 1px;
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			}

			.bsc__order-review.product-divider {
				border: none;
				border-top: 2px dotted #ccc;
				margin: 10px 0;
				width: 100%;
				max-width: 100%;
			}




			.bsc__order-review.return-to-shop .button{
				display: inline-block;
				padding: 10px 20px;
				border-radius: 20px;

				font-weight: 300;
				font-size: 16px;
				color: var(--color--white);
				text-decoration: none;
				text-transform: lowercase;
				letter-spacing: 1px;

				border: 1px solid  var(--color--black);
				background-color: var(--color--black);
			}
			.bsc__order-review.return-to-shop .button strong{
				font-weight: 700;
			}
			.bsc__order-review.return-to-shop .button:hover {
				display: inline-block;
				padding: 10px 20px;
				border-radius: 20px;

				font-weight: 300;
				font-size: 16px;
				color: var(--color--black);
				text-decoration: none;
				text-transform: lowercase;
				letter-spacing: 1px;

				border: 1px solid  var(--color--black);
				background-color: var(--color--white);
			}
			.bsc__order-review.return-to-shop .button:hover strong{
				font-weight: 700;
			}

		</style>
		<?php endif; ?>


</div>
