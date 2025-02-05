<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

<div class="product-category-page">
    <header class="page-header">
        <h1 class="page-title">
            <?php single_term_title(); // Display the category name ?>
        </h1>
        <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
    </header>

    <div class="products-grid">
        <?php if ( have_posts() ) : ?>
            <ul class="products">
                <?php while ( have_posts() ) : the_post(); ?>
                    <li class="product">
                        <a href="<?php the_permalink(); ?>">
                            <?php woocommerce_template_loop_product_thumbnail(); ?>
                            <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
                            <?php woocommerce_template_loop_price(); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php woocommerce_pagination(); // Add pagination ?>
        <?php else : ?>
            <p><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
