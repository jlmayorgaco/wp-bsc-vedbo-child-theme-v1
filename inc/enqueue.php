<?php
function vedbo_enqueue_assets() {
    // Styles
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_style('header-style', get_stylesheet_directory_uri() . '/components/header/header.css', [], '1.0.0');

    // Scripts
    wp_enqueue_script(
        'header-script',
        get_stylesheet_directory_uri() . '/components/header/header.js',
        ['jquery'],
        '1.0.0',
        true
    );

    // Conditional enqueue for checkout page
    if (is_checkout()) {
        wp_enqueue_script(
            'checkout-ajax',
            get_stylesheet_directory_uri() . '/js/ajax_checkout_update_order_review.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_localize_script(
            'checkout-ajax',
            'ajax_checkout__update',
            [
                'url'    => admin_url('admin-ajax.php'),
                'nonce'  => wp_create_nonce('my-ajax-nonce-2'),
                'action' => 'update_order_review',
            ]
        );
    }

    if (is_checkout()) { // Only enqueue on checkout page
        wp_enqueue_script(
            'ajax-apply-coupon',
            get_stylesheet_directory_uri() . '/js/ajax-apply-coupon.js', // Update path as necessary
            ['jquery'],
            '1.0.0',
            true
        );

        wp_localize_script(
            'ajax-apply-coupon',
            'ajax_coupon_var',
            [
                'url'    => admin_url('admin-ajax.php'),
                'nonce'  => wp_create_nonce('apply-coupon-nonce'),
            ]
        );
    }

    if(is_checkout()){
        wp_enqueue_script('ajax-cart', get_stylesheet_directory_uri() . '/js/ajax-cart.js', ['jquery'], '1.0', true);
        wp_localize_script('ajax-cart', 'wc_add_to_cart_params', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('update-cart'),
        ]); 
    }


    
}
add_action('wp_enqueue_scripts', 'vedbo_enqueue_assets');



