<?php
/**
 * Review order table
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;



?>
<div class="bsc__checkout--review" >

	<div class="review__container"> 
		<ul class="review__items">
			<?php

			$n_size = 0;
			$cart_subtotal = 0; // Initialize subtotal

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {	
				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				
				$productId = $_product->get_id();
				$productBrandCategories = get_filtered_product_categories( $productId );

				$productImage = $_product->get_image();
				$productName = $_product->get_name();
				$productBrand = $productBrandCategories ? $productBrandCategories[0] : 'Unknown Brand';
				$productPrice = wc_price($_product->get_price()); // Get formatted price
				$productQuantity = $cart_item['quantity'];
				$productTotal = wc_price($_product->get_price() * $productQuantity); // Calculate total price for the product

				// Add product quantity to overall cart size
				$n_size += $productQuantity;

				// Add to subtotal
				$cart_subtotal += $_product->get_price() * $productQuantity;
				?>
					<li class="review__item" data-item-key="<?php echo esc_attr($cart_item_key); ?>">
						<div class="item__col col1">
							<div class="item__picture">
								<?php echo $productImage; ?>
								<label>
									<span><?php echo $productQuantity; ?></span>
								</label>
							</div>
						</div>
						<div class="item__col col2">
							<div class="row">
								<div class="col_name_brand">
									<h5 class="item__name"><?php echo $productName; ?></h5>
									<h5 class="item__brand"><?php echo $productBrand; ?></h5>
								</div>
								<div class="col_total">
									<h5 class="item__total">
										<?php echo $productTotal; ?>
									</h5>
								</div>
							</div>
							<div class="row row_action_buttons">
									<button class="quantity-btn decrease">-</button>
									<button class="quantity-btn increase">+</button>
									<button class="delete-btn" >x</button>
							</div>
						</div>
					</li>
				<?php 
			}
			?>
		</ul> 	
		<div class="review__coupon">
			<div class="coupon__container">
				<div class="coupon__field">
					<input id="coupon_code__review-order" type="text" name="coupon_code" class="input-text" placeholder=" " />
					<label id="coupon_label" for="coupon_code">¿Tienes un código de <strong>descuento</strong>?</label>
				</div>
				<div class="coupon__row">
					<div class="coupon__col" style="justify-content: flex-start;">
						<p class="coupon__message">¡Muestras <strong>gratis</strong> con todos tus pedidos en BSC! 
						<img width="50px" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/corazonesBSC.png' ); ?>">

					</p>
					<div class="coupon__col">
						<button class="coupon__button" id="apply_coupon">¡Aplicar!</button>
					</div>
					</div>
					
				</div>

				<!-- Applied Coupons Section (Initially Hidden) -->
				<div class="applied-coupons" 
					<?php if ( empty( WC()->cart->get_applied_coupons() ) ) : ?> 
						style="display: none; margin-top: 0px;" 
					<?php endif; ?>
				>

					<!-- Applied Coupons Section -->
					<br>
					<hr>
					<br>

					<h4>Cupones aplicados ***:</h4>
					<ul id="applied_coupons_list">
						<?php foreach ( WC()->cart->get_coupons() as $coupon_code => $coupon ) : ?>
							<li class="applied-coupon-item" data-coupon="<?php echo esc_attr( $coupon_code ); ?>">
								<?php echo esc_html( $coupon_code ); ?> 
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/2BONO.png' ); ?>" >	
								<span class="remove-coupon" style="cursor: pointer; margin-left: 10px; color: red;">X</span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

    </div>
</div>

		<hr>
		<br>

		<div class="review__summary">
			<div class="summary__row">
				<div class="summary_col col1">Subtotal (<span id="review__summary--cart-n"><?php echo $n_size; ?></span>&nbsp;items)</div>
				<div class="summary_col col2" id="review__summary--subtotal"><?php echo wc_price($cart_subtotal); ?></div>
			</div>
			<div class="summary__row">
				<div class="summary_col col1">Subtotal con descuento</div>
				<div class="summary_col col2" id="review__summary--subtotal-discounted">
					<?php 
						// Calculate subtotal with the coupon applied
						$discount_total = WC()->cart->get_cart_discount_total(); // Total discount from coupons
						$subtotal_with_coupon = $cart_subtotal - $discount_total;

						// Display the discounted subtotal
						echo wc_price( $subtotal_with_coupon );
					?>
				</div>
			</div>

			<div class="summary__row">
				<div class="summary_col col1">Envío</div>
				<div class="summary_col col2" id="review__summary--shipping"><?php echo WC()->cart->get_cart_shipping_total(); ?></div>
			</div>
			<div class="summary__row">
    <div class="summary_col col1"> <strong> Total </strong> </div>
    <div class="summary_col col2" id="review__summary--total">
			<strong>
				<?php 
					// Get the total discount from applied coupons
					$discount_total = WC()->cart->get_cart_discount_total();

					// Get the cart subtotal and shipping total
					$subtotal = $cart_subtotal; // Previously calculated cart subtotal
					$shipping_total = WC()->cart->get_shipping_total();

					// Calculate the real total
					$real_total = ( $subtotal - $discount_total ) + $shipping_total;

					// Display the formatted real total
					echo wc_price( $real_total );
				?>
			</strong>
		</div>
	</div>

		</div>
	</div>
</div>

<script>
document.getElementById('apply_coupon').addEventListener('click', function() {
    // WooCommerce applies coupons via AJAX, trigger the click event on WooCommerce's apply coupon button.
    jQuery('form.woocommerce-checkout').find('button[name="apply_coupon"]').click();
});
</script>

<script>






</script>



<style>
.applied-coupons {
    font-size: 14px;
    color: #555;
}

.applied-coupons h4{
	font-family: inherit;
    font-size: 0.875rem;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

#applied_coupons_list{
	margin-left: 0px;
	padding-left:0px;
	margin-bottom: 5px;
}

.applied-coupon-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0px 0;
    padding: 0px 0px;
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 4px;

	text-transform: uppercase;

	position: relative;

	width:440px;
	height: 140px;

}
.applied-coupon-item img{ position: absolute; 
	display:block;
	width:440px;
	header: 140px;
}
.applied-coupon-item label{ 
	position:absolute;
    cursor: pointer;
    margin-left: 10px;
    top: 5px;
    right: 10px;
    background-color: pink;
    width: 20px;
    height: 20px;
    border-radius: 100%;
}
.appplied-coupon-item label span{ 
	position: relative;
    left: 6px;
    top: -3px;
}
.applied-coupon-item strong{ 
	position: absolute;
	bottom: 20px;
    left: 24px;
}
.remove-coupon {
    color: #333333;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.2s ease;
}

.remove-coupon:hover {
    color: darkred;
}

	</style>