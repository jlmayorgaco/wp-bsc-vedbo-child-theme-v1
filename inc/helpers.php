<?php

// Check if the user is an administrator
function is_user_admin() {
    return is_user_logged_in() && current_user_can('administrator');
}

// Get filtered product categories based on parent slug
function get_filtered_product_categories($product_id, $parent_slugs = ['sk-marcas', 'hc-marca', 'mk-marcas']) {
    $product_categories = get_the_terms($product_id, 'product_cat');
    $filtered_categories = [];

    if (!is_wp_error($product_categories) && $product_categories) {
        foreach ($product_categories as $category) {
            $parent_category = get_term($category->parent, 'product_cat');
            if ($parent_category && in_array($parent_category->slug, $parent_slugs)) {
                $filtered_categories[] = $category->name;
            }
        }
    }

    return $filtered_categories;
}
