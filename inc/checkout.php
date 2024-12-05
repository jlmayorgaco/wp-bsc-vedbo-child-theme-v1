<?php


// inc/checkout.php

class WooCommerceCheckoutService {
    
    /**
     * Prefill checkout fields for logged-in users.
     *
     * @param array $fields
     * @return array
     */
    public static function prefillCheckoutFields($fields) {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $fields['billing']['billing_first_name']['default'] = $current_user->first_name;
            $fields['billing']['billing_last_name']['default'] = $current_user->last_name;
            $fields['billing']['billing_email']['default'] = $current_user->user_email;
            $fields['billing']['billing_phone']['default'] = get_user_meta($current_user->ID, 'billing_phone', true);
        }
        return $fields;
    }

    /**
     * Automatically clone shipping fields into billing fields.
     *
     * @param array $fields
     * @return array
     */
    public static function cloneShippingToBillingFields($fields) {
        $fields['billing']['billing_state'] = $fields['shipping']['shipping_state'];
        $fields['billing']['billing_city'] = $fields['shipping']['shipping_city'];
        $fields['billing']['billing_postcode'] = $fields['shipping']['shipping_postcode'];
        $fields['billing']['billing_address_1'] = $fields['shipping']['shipping_address_1'];

        $fields['billing']['billing_state']['label'] = __('Departamento', 'woocommerce');
        $fields['billing']['billing_city']['label'] = __('Ciudad', 'woocommerce');
        $fields['billing']['billing_postcode']['label'] = __('Código Postal', 'woocommerce');

        return $fields;
    }

    /**
     * Save the "Notify Me" checkbox value with the order.
     *
     * @param int $order_id
     */
    public static function saveNotifyField($order_id) {
        $notify_value = isset($_POST['notify']) ? 'yes' : 'no';
        update_post_meta($order_id, '_notify', $notify_value);
    }

    /**
     * Display the "Notify Me" field in WooCommerce admin order page.
     *
     * @param WC_Order $order
     */
    public static function displayNotifyFieldInAdmin($order) {
        $notify = get_post_meta($order->get_id(), '_notify', true);
        echo '<p><strong>' . __('Notify Me:', 'woocommerce') . '</strong> ' . ($notify === 'yes' ? __('Yes', 'woocommerce') : __('No', 'woocommerce')) . '</p>';
    }

    /**
     * Handle guest checkout: Log in existing users or create new accounts.
     */
    public static function handleGuestCheckout() {
        if (is_user_logged_in()) {
            return; // Skip for logged-in users
        }

        $email = sanitize_email($_POST['billing_email']);
        if (!is_email($email)) {
            wc_add_notice(__('Invalid email address provided.', 'woocommerce'), 'error');
            return;
        }

        $user = get_user_by('email', $email);

        if (!$user) {
            // Create a new user
            $password = wp_generate_password();
            $user_id = wp_create_user($email, $password, $email);

            if (is_wp_error($user_id)) {
                wc_add_notice(__('Unable to create an account: ', 'woocommerce') . $user_id->get_error_message(), 'error');
                return;
            }

            // Update user meta with billing details
            update_user_meta($user_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
            update_user_meta($user_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
            update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));

            // Log in new user
            wp_set_auth_cookie($user_id, true);

            // Send account creation email
            wp_mail(
                $email,
                __('Your New Account on Bubbles Skincare', 'woocommerce'),
                sprintf(
                    __("Hello %s,\n\nYour account has been created successfully.\n\nUsername: %s\nPassword: %s\n\nYou can log in and change your password here: %s", 'woocommerce'),
                    sanitize_text_field($_POST['billing_first_name']),
                    $email,
                    $password,
                    wp_login_url()
                )
            );

            wc_add_notice(__('Your account has been created, and you are now logged in.', 'woocommerce'), 'success');
        }
    }
}

// Hooks
add_filter('woocommerce_checkout_fields', ['WooCommerceCheckoutService', 'prefillCheckoutFields']);
add_filter('woocommerce_checkout_fields', ['WooCommerceCheckoutService', 'cloneShippingToBillingFields']);
add_action('woocommerce_checkout_update_order_meta', ['WooCommerceCheckoutService', 'saveNotifyField']);
add_action('woocommerce_admin_order_data_after_billing_address', ['WooCommerceCheckoutService', 'displayNotifyFieldInAdmin'], 10, 1);
add_action('woocommerce_checkout_process', ['WooCommerceCheckoutService', 'handleGuestCheckout']);
