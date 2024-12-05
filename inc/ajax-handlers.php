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