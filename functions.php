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