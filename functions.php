<?php //Start building your awesome child theme functions

add_action( 'wp_enqueue_scripts', 'vedbo_enqueue_styles', 100 );
function vedbo_enqueue_styles() {
    wp_enqueue_style( 'vedbo-child-styles',  get_stylesheet_directory_uri() . '/style.css', array( 'nova-vedbo-styles' ), wp_get_theme()->get('Version') );
}
