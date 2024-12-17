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

