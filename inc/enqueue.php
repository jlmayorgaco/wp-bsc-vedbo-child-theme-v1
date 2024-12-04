<?php
function vedbo_enqueue_assets() {
    // Styles
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_style('header-style', get_template_directory_uri() . '/components/header/header.css', [], '1.0.0');

    // Scripts
    wp_enqueue_script(
        'header-script',
        get_template_directory_uri() . '/components/header/header.js',
        ['jquery'],
        '1.0.0',
        true
    );

    // Conditional enqueue for checkout page
    if (is_checkout()) {
        wp_enqueue_script(
            'checkout-ajax',
            get_template_directory_uri() . '/js/ajax_checkout_update_order_review.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_localize_script(
            'checkout-ajax',
            'ajax_var',
            [
                'url'    => admin_url('admin-ajax.php'),
                'nonce'  => wp_create_nonce('my-ajax-nonce'),
                'action' => 'update_order_review',
            ]
        );
    }
}
add_action('wp_enqueue_scripts', 'vedbo_enqueue_assets');
