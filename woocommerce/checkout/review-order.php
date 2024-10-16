<?php
/**
 * Review order table
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get filtered product categories based on the parent category slug.
 *
 * @param int    $product_id The ID of the product.
 * @param array  $parent_slugs The slugs of the parent categories to filter by.
 * @return array Filtered category names.
 */
function get_filtered_product_categories( $product_id, $parent_slugs = ['sk-marcas', 'hc-marca', 'mk-marcas'] ) {
    // Get all the categories
    $product_categories = get_the_terms( $product_id, 'product_cat' );
    $filtered_categories = [];

    // Loop through the categories and filter based on parent slug
    if ( ! is_wp_error( $product_categories ) && $product_categories ) {
        foreach ( $product_categories as $category ) {
            // Get the parent category term
            $parent_category = get_term( $category->parent, 'product_cat' );
            
            // Check if the parent category's slug matches one of the target slugs
            if ( $parent_category && in_array( $parent_category->slug, $parent_slugs ) ) {
                // Add this category to the filtered categories
                $filtered_categories[] = $category->name;
            }
        }
    }

    return $filtered_categories; // Return an array of filtered category names
}

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
					<li class="review__item">
						<div class="item__col col1">
							<div class="item__picture">
								<?php echo $productImage; ?>
								<label>
									<span> <?php echo $productQuantity; ?></span>
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
									<h5 class="item__total"><?php echo $productTotal; ?></h5>
								</div>
							</div>
							<div class="row">
								<h5 class="item__price"><?php echo $productPrice; ?></h5>
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
					<input id="coupon_code"  type="text" name="coupon_code" class="input-text" placeholder=" " />
            		<label id="coupon_label" for="coupon_code">¿Tienes un código de <strong>descuento</strong>?</label>
        		</div>
				<div class="coupon__row">
					<div class="coupon__col">
						<p class="coupon__message"> ¡Muestras <strong>gratis</strong> con todos tus pedidos en BSC! <img src=""> <img src=""> <img src=""> </p>
					</div>
					<div class="coupon__col">
						<button class="coupon__button" id="apply_coupon">¡Aplicar!</button>
					</div>
				</div>
			</div>
		</div>

		<br>
		<hr>
		<br>

		<div class="review__summary">
			<div class="summary__row">
				<div class="summary_col col1">Subtotal (<?php echo $n_size; ?> items)</div>
				<div class="summary_col col2"><?php echo wc_price($cart_subtotal); ?></div>
			</div>
			<div class="summary__row">
				<div class="summary_col col1">Envío</div>
				<div class="summary_col col2"><?php echo WC()->cart->get_cart_shipping_total(); ?></div>
			</div>
			<div class="summary__row">
				<div class="summary_col col1"> <strong> Total </strong> </div>
				<div class="summary_col col2">
					<strong>
						<?php 
							$cart_total = $cart_subtotal + WC()->cart->get_shipping_total(); 
							echo wc_price($cart_total);
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



