<?php

// Prefill checkout fields for logged-in users
add_filter('woocommerce_checkout_fields', function ($fields) {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $fields['billing']['billing_first_name']['default'] = $current_user->first_name;
        $fields['billing']['billing_last_name']['default'] = $current_user->last_name;
        $fields['billing']['billing_email']['default'] = $current_user->user_email;
        $fields['billing']['billing_phone']['default'] = get_user_meta($current_user->ID, 'billing_phone', true);
    }
    return $fields;
});

// Automatically copy shipping details to billing fields
add_filter('woocommerce_checkout_fields', function ($fields) {
    $fields['billing']['billing_state'] = $fields['shipping']['shipping_state'];
    $fields['billing']['billing_city'] = $fields['shipping']['shipping_city'];
    $fields['billing']['billing_postcode'] = $fields['shipping']['shipping_postcode'];
    $fields['billing']['billing_address_1'] = $fields['shipping']['shipping_address_1'];
    return $fields;
});

// Save "Notify Me" checkbox with order meta
add_action('woocommerce_checkout_update_order_meta', function ($order_id) {
    $notify = isset($_POST['notify']) ? 'yes' : 'no';
    update_post_meta($order_id, '_notify', $notify);
});

// Add "Notify Me" meta field in admin order page
add_action('woocommerce_admin_order_data_after_billing_address', function ($order) {
    $notify = get_post_meta($order->get_id(), '_notify', true);
    echo '<p><strong>' . __('Notify Me:', 'woocommerce') . '</strong> ' . ($notify === 'yes' ? __('Yes', 'woocommerce') : __('No', 'woocommerce')) . '</p>';
});
