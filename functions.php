<?php
// Load theme assets
require_once get_stylesheet_directory() . '/inc/enqueue.php';

// WooCommerce customizations
require_once get_stylesheet_directory() . '/inc/custom-fields.php';
require_once get_stylesheet_directory() . '/inc/custom-texts.php';
require_once get_stylesheet_directory() . '/inc/checkout.php';
require_once get_stylesheet_directory() . '/inc/cart.php';


// AJAX handlers
require_once get_stylesheet_directory() . '/inc/ajax-handlers.php';

// Utility functions
require_once get_stylesheet_directory() . '/inc/helpers.php';

// Services
foreach (glob(get_stylesheet_directory() . '/inc/services/*.php') as $service_file) {
    require_once $service_file;
}

function load_coming_soon_template() {
    // Define conditions for local development
    $is_local = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || 
                strpos($_SERVER['SERVER_NAME'], 'localhost') !== false;

    // Check if user is not logged in, site is not local, and not in admin
    if (!$is_local && !is_user_logged_in() && !is_admin()) {
        // Load the coming-soon.php template
        include get_stylesheet_directory() . '/coming-soon.php';
        exit; // Stop further execution
    }
}

// Hook into template_redirect to override the front-end
add_action('template_redirect', 'load_coming_soon_template');

function add_custom_body_class($classes) {
    if (is_page('checkout-bubbles') && trim($_SERVER['REQUEST_URI'], '/') === 'checkout-bubbles') {
        $classes[] = 'checkout-bubbles-bg';
    }
    return $classes;
}
add_filter('body_class', 'add_custom_body_class');



add_filter('woocommerce_package_rates', 'custom_free_shipping_for_high_value_orders', 10, 2);

function custom_free_shipping_for_high_value_orders($rates, $package) {
    $free_shipping_minimum = 300000; // Minimum cart amount for free shipping

    // Get cart subtotal before taxes and shipping
    $cart_subtotal = WC()->cart->get_subtotal();

    // Debug output to check subtotal (optional)
    error_log("Cart subtotal: " . $cart_subtotal);

    if ($cart_subtotal >= $free_shipping_minimum) {
        // Keep only the free shipping method and remove all others
        foreach ($rates as $rate_id => $rate) {
            if (is_object($rate) && method_exists($rate, 'get_method_id')) {
                if ($rate->get_method_id() !== 'free_shipping') {
                    unset($rates[$rate_id]);
                }
            }
        }
    }

    return $rates;
}
