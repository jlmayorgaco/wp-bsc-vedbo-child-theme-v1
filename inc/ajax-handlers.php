<?php
add_action('wp_ajax_update_order_review', 'update_order_review');
add_action('wp_ajax_nopriv_update_order_review', 'update_order_review');


function update_order_review() {
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my-ajax-nonce-2')) {
        wp_send_json_error('Invalid nonce');
        return;
    }

    // Ensure WooCommerce cart and session are initialized
    if (!WC()->cart || !WC()->session) {
        wp_send_json_error('WooCommerce cart not initialized');
        return;
    }

    // Extract and sanitize posted data
    $state = isset($_POST['payload']['state']) ? sanitize_text_field($_POST['payload']['state']) : '';

    if (empty($state)) {
        wp_send_json_error('State not provided');
        return;
    }

    // Update customer shipping and billing state
    WC()->customer->set_billing_state($state);
    WC()->customer->set_shipping_state($state);

    // Trigger WooCommerce to refresh shipping rates and totals
    WC()->cart->calculate_shipping(); // Refresh shipping
    WC()->cart->calculate_totals();   // Refresh totals

    // Force WooCommerce to refresh the session data for the customer
    WC()->session->set('customer', WC()->customer);

    // Prepare updated data for response
    $response = [
        'subtotal'        => WC()->cart->get_cart_subtotal(),
        'shipping_total'  => WC()->cart->get_cart_shipping_total(),
        'cart_total'      => WC()->cart->get_total(),
    ];

    // Debugging
    error_log('State: ' . $state);
    error_log('Shipping Total: ' . $response['shipping_total']);
    error_log('Cart Total: ' . $response['cart_total']);

    wp_send_json_success($response);
}



add_action('wp_ajax_apply_coupon', 'apply_coupon_via_ajax');
add_action('wp_ajax_nopriv_apply_coupon', 'apply_coupon_via_ajax');

function apply_coupon_via_ajax() {
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'apply-coupon-nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
        return;
    }

    // Check if WooCommerce cart is initialized
    if (!WC()->cart) {
        wp_send_json_error(['message' => 'Cart not initialized']);
        return;
    }

    $coupon_code = sanitize_text_field($_POST['coupon_code']); // Get the coupon code

    // Try to apply the coupon
    $result = WC()->cart->apply_coupon($coupon_code);

    if (!$result) {
        wp_send_json_error(['message' => 'Invalid coupon code or not applicable']);
        return;
    }

    // Recalculate totals
    WC()->cart->calculate_totals();

    // Prepare and send the updated cart data
    $response = [
        'subtotal' => WC()->cart->get_cart_subtotal(),
        'shipping_total' => WC()->cart->get_cart_shipping_total(),
        'cart_total' => WC()->cart->get_total(),
    ];

    wp_send_json_success($response);
}
