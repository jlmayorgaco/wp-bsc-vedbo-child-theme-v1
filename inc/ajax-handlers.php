<?php
// Update order review (existing)
add_action('wp_ajax_update_order_review', 'update_order_review');
add_action('wp_ajax_nopriv_update_order_review', 'update_order_review');

function update_order_review() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my-ajax-nonce-2')) {
        wp_send_json_error('Invalid nonce');
        return;
    }

    if (!WC()->cart || !WC()->session) {
        wp_send_json_error('WooCommerce cart not initialized');
        return;
    }

    $state = isset($_POST['payload']['state']) ? sanitize_text_field($_POST['payload']['state']) : '';

    if (empty($state)) {
        wp_send_json_error('State not provided');
        return;
    }

    WC()->customer->set_billing_state($state);
    WC()->customer->set_shipping_state($state);
    WC()->cart->calculate_shipping();
    WC()->cart->calculate_totals();
    WC()->session->set('customer', WC()->customer);

    $response = [
        'subtotal'        => WC()->cart->get_cart_subtotal(),
        'shipping_total'  => WC()->cart->get_cart_shipping_total(),
        'cart_total'      => WC()->cart->get_total(),
    ];

    wp_send_json_success($response);
}

// Apply coupon (existing)
add_action('wp_ajax_apply_coupon', 'apply_coupon_via_ajax');
add_action('wp_ajax_nopriv_apply_coupon', 'apply_coupon_via_ajax');

function apply_coupon_via_ajax() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'apply-coupon-nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
        return;
    }

    if (!WC()->cart) {
        wp_send_json_error(['message' => 'Cart not initialized']);
        return;
    }

    $coupon_code = sanitize_text_field($_POST['coupon_code']);
    $result = WC()->cart->apply_coupon($coupon_code);

    if (!$result) {
        wp_send_json_error(['message' => 'Invalid coupon code or not applicable']);
        return;
    }

    WC()->cart->calculate_totals();

    $response = [
        'subtotal' => WC()->cart->get_cart_subtotal(),
        'shipping_total' => WC()->cart->get_cart_shipping_total(),
        'cart_total' => WC()->cart->get_total(),
        'coupons' => get_applied_coupons_list(),
    ];

    wp_send_json_success($response);
}

// Remove coupon (new)
add_action('wp_ajax_remove_coupon', 'remove_coupon_via_ajax');
add_action('wp_ajax_nopriv_remove_coupon', 'remove_coupon_via_ajax');

function remove_coupon_via_ajax() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'apply-coupon-nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
        return;
    }

    if (!WC()->cart) {
        wp_send_json_error(['message' => 'Cart not initialized']);
        return;
    }

    $coupon_code = sanitize_text_field($_POST['coupon_code']);

    if (!in_array($coupon_code, WC()->cart->get_applied_coupons())) {
        wp_send_json_error(['message' => 'Coupon not found']);
        return;
    }

    // Remove the coupon
    WC()->cart->remove_coupon($coupon_code);
    WC()->cart->calculate_totals();

    $response = [
        'subtotal' => WC()->cart->get_cart_subtotal(),
        'shipping_total' => WC()->cart->get_cart_shipping_total(),
        'cart_total' => WC()->cart->get_total(),
        'coupons' => get_applied_coupons_list(),
    ];

    wp_send_json_success($response);
}

// Helper function to get applied coupons
function get_applied_coupons_list() {
    $applied_coupons = WC()->cart->get_coupons(); // Array of coupon codes
    $coupon_details = [];

    foreach ($applied_coupons as $coupon_code) {
        $coupon = new WC_Coupon($coupon_code);

        $coupon_details[] = [
            'code' => $coupon_code,
            'description' => $coupon->get_description() ? $coupon->get_description() : 'No description',
            'amount' => wc_price($coupon->get_amount()), // Coupon discount amount
            'discount_type' => $coupon->get_discount_type(),
        ];
    }

    return $coupon_details;
}




// Get applied coupons (new AJAX handler)
add_action('wp_ajax_get_applied_coupons', 'get_applied_coupons_ajax');
add_action('wp_ajax_nopriv_get_applied_coupons', 'get_applied_coupons_ajax');

function get_applied_coupons_ajax() {
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'apply-coupon-nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
        return;
    }

    if (!WC()->cart) {
        wp_send_json_error(['message' => 'Cart not initialized']);
        return;
    }

    // Retrieve applied coupons
    $coupons = WC()->cart->get_applied_coupons();
    $coupon_details = [];

    foreach ($coupons as $coupon_code) {
        $coupon = new WC_Coupon($coupon_code);

        $coupon_details[] = [
            'code' => $coupon_code,
            'description' => $coupon->get_description() ? $coupon->get_description() : 'No description',
            'amount' => wc_price($coupon->get_amount()),
            'discount_type' => $coupon->get_discount_type(),
        ];
    }

    // Return coupon details
    wp_send_json_success(['coupons' => $coupon_details]);
}





add_action('wp_ajax_update_cart_quantity', 'update_cart_quantity');
add_action('wp_ajax_nopriv_update_cart_quantity', 'update_cart_quantity');

function update_cart_quantity() {
    if ( ! isset($_POST['item_key'], $_POST['quantity_change']) ) {
        wp_send_json_error(['message' => 'Invalid request']);
        return;
    }

    $item_key = sanitize_text_field($_POST['item_key']);
    $quantity_change = intval($_POST['quantity_change']);
    $cart = WC()->cart;

    if ( $cart->get_cart_item($item_key) ) {
        $current_quantity = $cart->get_cart_item($item_key)['quantity'];
        $new_quantity = max(1, $current_quantity + $quantity_change); // Prevent negative quantity
        $cart->set_quantity($item_key, $new_quantity);
        $cart->calculate_totals();

        wp_send_json_success(get_cart_ajax_response());
    }

    wp_send_json_error(['message' => 'Item not found']);
}





add_action('wp_ajax_remove_cart_item', 'remove_cart_item');
add_action('wp_ajax_nopriv_remove_cart_item', 'remove_cart_item');

function remove_cart_item() {
    if ( ! isset($_POST['item_key']) ) {
        wp_send_json_error(['message' => 'Invalid request']);
        return;
    }

    $item_key = sanitize_text_field($_POST['item_key']);
    $cart = WC()->cart;

    if ( $cart->get_cart_item($item_key) ) {
        $cart->remove_cart_item($item_key);
        $cart->calculate_totals();

        wp_send_json_success(get_cart_ajax_response());
    }

    wp_send_json_error(['message' => 'Item not found']);
}


function get_cart_ajax_response() {


    WC()->cart->calculate_shipping();
    WC()->cart->calculate_totals();
    WC()->session->set('customer', WC()->customer);

    // Calculate subtotal with the coupon applied
    $discount_total = WC()->cart->get_cart_discount_total(); 

    $response = [

        'n_products' => WC()->cart->get_cart_contents_count(),
        'subtotal'        => WC()->cart->get_cart_subtotal(),
        'subtotal_disconted'  => wc_price($discount_total),
        'shipping_total'  => WC()->cart->get_cart_shipping_total(),
        'cart_total'      => WC()->cart->get_total(),

        'cart_items_html' => get_cart_items_html(),
    ];

    return  $response ;
}



function get_cart_items_html() {
    ob_start(); // Start output buffering
    ?>
    <ul class="review__items">
        <?php
        $n_size = 0; // Total quantity of all items
        $cart_subtotal = 0; // Initialize subtotal

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {	
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            
            $productId = $_product->get_id();
            $productBrandCategories = get_filtered_product_categories( $productId );

            $productImage = $_product->get_image();
            $productName = $_product->get_name();
            $productBrand = $productBrandCategories ? $productBrandCategories[0] : 'Unknown Brand';
            $productPrice = wc_price( $_product->get_price() ); // Get formatted price
            $productQuantity = $cart_item['quantity'];
            $productTotal = wc_price( $_product->get_price() * $productQuantity ); // Calculate total price for the product

            // Add product quantity to overall cart size
            $n_size += $productQuantity;

            // Add to subtotal
            $cart_subtotal += $_product->get_price() * $productQuantity;
            ?>
            <li class="review__item" data-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
                <div class="item__col col1">
                    <div class="item__picture">
                        <?php echo $productImage; ?>
                        <label>
                            <span><?php echo esc_html( $productQuantity ); ?></span>
                        </label>
                    </div>
                </div>
                <div class="item__col col2">
                    <div class="row">
                        <div class="col_name_brand">
                            <h5 class="item__name"><?php echo esc_html( $productName ); ?></h5>
                            <h5 class="item__brand"><?php echo esc_html( $productBrand ); ?></h5>
                        </div>
                        <div class="col_total">
                            <h5 class="item__total"><?php echo $productTotal; ?></h5>
                        </div>
                    </div>
                    <div class="row row_action_buttons">
                        <button class="quantity-btn decrease">-</button>
                        <button class="quantity-btn increase">+</button>
                        <button class="delete-btn">🗑</button>
                    </div>
                </div>
            </li>
            <?php 
        }
        ?>
    </ul>
    <?php
    return ob_get_clean(); // Return the buffered HTML as a string
}