jQuery(document).ready(function ($) {
    // Increase quantity
    $('.review__items').on('click', '.quantity-btn.increase', function (e) {
        e.preventDefault();
        disableCheckoutRefresh();
        updateCartQuantity($(this), 1);
    });

    // Decrease quantity
    $('.review__items').on('click', '.quantity-btn.decrease', function (e) {
        e.preventDefault();
        disableCheckoutRefresh();
        updateCartQuantity($(this), -1);
    });

    // Remove item
    $('.review__items').on('click', '.delete-btn', function (e) {
        e.preventDefault();
        disableCheckoutRefresh();
        removeCartItem($(this));
    });

    // Function to temporarily disable WooCommerce checkout refresh
    function disableCheckoutRefresh() {
        if (typeof wc_checkout_form !== 'undefined') {
            $(document.body).off('updated_cart_totals', wc_checkout_form.trigger_update_checkout);
        }
    }

    // Function to update cart quantity
    function updateCartQuantity(button, change) {
        const itemRow = button.closest('.review__item');
        const itemKey = itemRow.data('item-key');

        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'update_cart_quantity',
                item_key: itemKey,
                quantity_change: change,
            },
            success: function (response) {
                if (response.success) {
                    refreshCartView(response.data);
                } else {
                    alert(response.data.message || 'Error updating quantity.');
                }
            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });
    }

    // Function to remove cart item
    function removeCartItem(button) {
        const itemRow = button.closest('.review__item');
        const itemKey = itemRow.data('item-key');

        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'remove_cart_item',
                item_key: itemKey,
            },
            success: function (response) {
                if (response.success) {
                    refreshCartView(response.data);
                } else {
                    alert(response.data.message || 'Error removing item.');
                }
            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });
    }

    // Function to refresh cart view
    function refreshCartView(cartData) {

        console.log(' ')
        console.log('  function refreshCartView { ')
        console.log({cartData})
        console.log(' ')

        // Update totals
        $('#review__summary--cart-n').html(cartData.n_products);
        $('#review__summary--subtotal').html(cartData.subtotal);
        $('#review__summary--subtotal-discounted').html(cartData.subtotal_disconted);
        $('#review__summary--shipping').html(cartData.shipping_total);
        $('#review__summary--total').html('<strong>' + cartData.cart_total + '</strong>');

        // Reload the product list
        $('.review__items').html(cartData.cart_items_html);

        // Re-enable WooCommerce checkout updates after a small delay
        setTimeout(function () {
            if (typeof wc_checkout_form !== 'undefined') {
                $(document.body).on('updated_cart_totals', wc_checkout_form.trigger_update_checkout);
            }
        }, 500);
    }
});
