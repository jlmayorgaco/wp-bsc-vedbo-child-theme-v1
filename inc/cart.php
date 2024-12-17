<?php

add_filter( 'woocommerce_return_to_shop_redirect', 'custom_return_to_shop_url' );
function custom_return_to_shop_url() {
    return home_url( '/product-category/' ); // Replace with the desired URL
}
