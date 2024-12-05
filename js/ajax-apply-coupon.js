jQuery(document).ready(function ($) {
    // Handle Enter key press and button click for the coupon code
    $('#coupon_code').on('keypress', function (e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            applyCouponCode();
        }
    });

    $('#apply_coupon').on('click', function (e) {
        e.preventDefault();
        applyCouponCode();
    });

    function applyCouponCode() {
        const couponCode = $('#coupon_code').val(); // Get the entered coupon code

        if (!couponCode) {
            alert('Please enter a coupon code!');
            return;
        }

        const data = {
            action: 'apply_coupon',
            nonce: ajax_coupon_var.nonce,
            coupon_code: couponCode,
        };

        $.ajax({
            url: ajax_coupon_var.url, // Admin AJAX URL
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (response) {
                if (response.success) {
                    // Refresh totals and show success message
                    alert('Coupon applied successfully!');
                    $('#review__summary--subtotal').html(response.data.subtotal);
                    $('#review__summary--shipping').html(response.data.shipping_total);
                    $('#review__summary--total').html('<strong>' + response.data.cart_total + '</strong>');
                } else {
                    alert(response.data.message || 'Failed to apply coupon.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('An error occurred. Please try again.');
            },
        });
    }
});
