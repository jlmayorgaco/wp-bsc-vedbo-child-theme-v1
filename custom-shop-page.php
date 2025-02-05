<?php
defined( 'ABSPATH' ) || exit;

get_header(); // Include header ?>

<div class="category-grid">
    <?php
    // Define the desired category slugs in order
    $category_slugs = [ 'group-skin-care', 'group-hair-care', 'group-make-up' ];

    // Fetch categories in the defined order
    $categories = get_terms( [
        'taxonomy'   => 'product_cat',
        'slug'       => $category_slugs,
        'hide_empty' => false,
    ] );

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
        // Sort categories based on the defined order
        usort( $categories, function ( $a, $b ) use ( $category_slugs ) {
            $pos_a = array_search( $a->slug, $category_slugs );
            $pos_b = array_search( $b->slug, $category_slugs );
            return $pos_a - $pos_b;
        });

        foreach ( $categories as $category ) :
            $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true ); // Get category image ID
            $image_url    = wp_get_attachment_url( $thumbnail_id ); // Get category image URL
            $image_url    = $image_url ? $image_url : wc_placeholder_img_src(); // Fallback to placeholder
            ?>
            <div class="category-tile" style="background-image: url('<?php echo esc_url( $image_url ); ?>');">
                <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-link">
                    <div class="category-content">
                        <h2 class="category-title"><?php echo esc_html( $category->name ); ?></h2>
                    </div>
                </a>
            </div>
        <?php
        endforeach;
    else :
        echo '<p>No categories found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); // Include footer ?>


<style>

.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.category-tile {
    position: relative;
    width: 100%;
    padding-top: 75%; /* Aspect ratio 4:3 */
    background-size: cover;
    background-position: center;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.category-tile:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
}

.category-link {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-content {
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    text-align: center;
    padding: 10px 20px;
    border-radius: 5px;
}

.category-title {
    font-size: 1.5rem;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0;
}


</style>