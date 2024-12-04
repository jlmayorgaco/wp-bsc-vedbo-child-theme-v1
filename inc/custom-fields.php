<?php

// Add a custom "Cedula" field to WooCommerce billing fields
add_filter('woocommerce_billing_fields', function ($fields) {
    $fields['billing_cc'] = [
        'label'       => __('Cedula', 'woocommerce'),
        'placeholder' => _x('Numero de Cedula', 'placeholder', 'woocommerce'),
        'required'    => true,
        'type'        => 'text',
    ];
    return $fields;
});
