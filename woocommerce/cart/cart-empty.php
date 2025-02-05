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
    font-size: 23px;
    font-weight: regular;
    letter-spacing: 2.5px;
    font-family: "Helvetica", sans-serif;
}

.woocommerce-cart-empty-container img {
    max-width: 300px;
    margin: 20px auto;
    display: block;
}

.woocommerce-cart-empty-container .return-to-shop .button {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 20px;

    font-weight: 300;
    font-size: 16px;
    color: var(--color--white);
    text-decoration: none;
    text-transform: lowercase;
    letter-spacing: 1px;


	border: 1px solid  var(--color--black);
    background-color: var(--color--black);
}

.woocommerce-cart-empty-container .return-to-shop .button strong{
    font-weight: 700;
}

.woocommerce-cart-empty-container .return-to-shop .button:hover {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 20px;

    font-weight: 300;
    font-size: 16px;
    color: var(--color--black);
    text-decoration: none;
    text-transform: lowercase;
    letter-spacing: 1px;

	border: 1px solid  var(--color--black);
    background-color: var(--color--white);

}
.woocommerce-cart-empty-container .return-to-shop .button:hover strong{
    font-weight: 700;
}
</style>

<div class="woocommerce-cart-empty-container" style="text-align: center; margin: 50px 0;">


    <!-- Centered Image -->
    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/carita_tristeProductos_PDRN.png' ); ?>" 
         alt="<?php esc_attr_e( 'Empty Cart', 'woocommerce' ); ?>" 
         style="max-width: 200px; margin: 20px auto; margin-bottom:10px; display: block;">

    <!-- Centered Title -->
    <h1 style="        margin-bottom: 1.25rem; ">
        Ohh ... <strong>tu carrito</strong> esta vacío
    </h1>
    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/bsc__waving-line.png' ); ?>" 
         alt="<?php esc_attr_e( 'Empty Cart', 'woocommerce' ); ?>" 
         style="max-width: 80px; margin: 0px auto;  display: block;">

    <div style="margin:25px; display:block;"></div>

    
    <!-- Return to Shop Button -->
    <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
    <p class="return-to-shop">
        <a class="button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" 
           href="<?php echo esc_url( home_url( '/product-category/group-skin-care/sk-rutina/sk-rutina-s1-limpiadores-aceitosos/' ) ); ?>">
            ¡ Ir a la <strong>tienda</strong> !
        </a>
    </p>
<?php endif; ?>
</div>

