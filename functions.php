<?php //Start building your awesome child theme functions

add_action( 'wp_enqueue_scripts', 'vedbo_enqueue_styles', 100 );
function vedbo_enqueue_styles() {
    wp_enqueue_style( 'vedbo-child-styles',  get_stylesheet_directory_uri() . '/style.css', array( 'nova-vedbo-styles' ), wp_get_theme()->get('Version') );
}


add_filter('woocommerce_billing_fields', 'custom_woocommerce_billing_fields');

function custom_woocommerce_billing_fields($fields)
{

    $fields['billing_cc'] = array(
        'label' => __('Cedula', 'woocommerce'), // Add custom field label
        'placeholder' => _x('Numero de Cedula', 'placeholder', 'woocommerce'), // Add custom field placeholder
        'required' => true, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'text', // add field type
        'class' => array('my-css')    // add class name
    );

    return $fields;
}



function custom_woocommerce_form_field($key, $field, $value) {
    // Default field attributes
    $required = $field['required'] ? '<abbr class="required" title="obligatorio">*</abbr>' : '';
    $label = isset($field['label']) ? $field['label'] : '';
    $type = isset($field['type']) ? $field['type'] : 'text';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
    $autocomplete = isset($field['autocomplete']) ? $field['autocomplete'] : '';
    $class = implode(' ', isset($field['class']) ? $field['class'] : array());
    $input_class = isset($field['input_class']) ? implode(' ', $field['input_class']) : 'input-text';
    $label_class = isset($field['label_class']) ? implode(' ', $field['label_class']) : '';
    $id = isset($field['id']) ? $field['id'] : $key;

    // Output the custom form field
    echo '<div class="custom-form-field ' . esc_attr($class) . '">';
    echo '<label for="' . esc_attr($key) . '" class="' . esc_attr($label_class) . '">' . esc_html($label) . ' ' . $required . '</label>';
    echo '<input type="' . esc_attr($type) . '" class="' . esc_attr($input_class) . '" name="' . esc_attr($key) . '" id="' . esc_attr($id) . '" placeholder="' . esc_attr($placeholder) . '" value="' . esc_attr($value) . '" autocomplete="' . esc_attr($autocomplete) . '">';
    echo '</div>';
}

// add_filter( 'woocommerce_checkout_fields', 'clone_shipping_to_billing_fields' );
function clone_shipping_to_billing_fields( $fields ) {
    
    // Clone shipping state, city, postcode to billing fields
    $fields['billing']['billing_state'] = $fields['shipping']['shipping_state'];
    $fields['billing']['billing_city'] = $fields['shipping']['shipping_city'];
    $fields['billing']['billing_postcode'] = $fields['shipping']['shipping_postcode'];
    $fields['billing']['billing_address_1'] = $fields['shipping']['shipping_address_1'];

    // Rename cloned fields to match billing structure
    $fields['billing']['billing_state']['label'] = 'Departamento';
    $fields['billing']['billing_city']['label'] = 'Ciudad';
    $fields['billing']['billing_postcode']['label'] = 'Código Postal';

    return $fields;
}