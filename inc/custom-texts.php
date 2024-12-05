<?php



add_filter('woocommerce_order_button_text', 'bsc_override_order_button_text');
function bsc_override_order_button_text($button_text) {
    return __('¡Hacer Compra!', 'woocommerce'); // Replace with your desired text
}
