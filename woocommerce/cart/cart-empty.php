<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
?>

<style>
.woocommerce-cart-empty-container {
    text-align: center;
    margin: 50px 0;
}

.woocommerce-cart-empty-container h1 {
    font-size: 32px;
    color: #333;
}

.woocommerce-cart-empty-container img {
    max-width: 300px;
    margin: 20px auto;
    display: block;
}

.woocommerce-cart-empty-container .return-to-shop .button {
    display: inline-block;
    background-color: var(--color--pink);
    color: #fff;
	border: 1px solid var(--color-pink);
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
}

.woocommerce-cart-empty-container .return-to-shop .button:hover {
	background-color: #fff;
	border: 1px solid #fff;
    color: var(--color--pink);
}

</style>

<div class="woocommerce-cart-empty-container" style="text-align: center; margin: 50px 0;">
    <!-- Centered Title -->
    <h1 style="font-size: 32px; color: #333;"><?php esc_html_e( 'Tu Carrito esta Vacio', 'woocommerce' ); ?></h1>
    
    <!-- Centered Image -->
    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/BSC_Empty_Cart.jpg' ); ?>" 
         alt="<?php esc_attr_e( 'Empty Cart', 'woocommerce' ); ?>" 
         style="max-width: 300px; margin: 20px auto; display: block;">
    
    <!-- Return to Shop Button -->
    <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <p class="return-to-shop">
            <a class="button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" 
               href="<?php echo esc_url( home_url( '/product-category/' ) ); ?>"
               >
                <?php esc_html_e( 'Ir a Tienda', 'woocommerce' ); ?>
            </a>
        </p>
    <?php endif; ?>
</div>
