<?php

add_action('wc_ajax_update_order_review', 'bsc_update_order_review');
add_action('wp_ajax_nopriv_update_order_review', 'bsc_update_order_review');

function bsc_update_order_review() {
    check_ajax_referer('my-ajax-nonce', 'nonce');

    // Example payload handling
    $post_data = isset($_POST['payload']) ? wp_unslash($_POST['payload']) : [];

    // Example response
    wp_send_json_success([
        'message' => 'AJAX request successful!',
        'data'    => $post_data,
    ]);
}
