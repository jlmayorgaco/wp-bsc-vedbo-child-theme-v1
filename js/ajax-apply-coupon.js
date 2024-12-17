jQuery(document).ready(function ($) {
    // Handle Enter key press and button click for the coupon code
    $('#coupon_code__review-order').on('keypress', function (e) {
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
        const couponCode = $('#coupon_code__review-order').val(); // Get the entered coupon code

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

                    alert('Coupon aplicado exitosamente!');

                    // Refresh totals
                    $('#review__summary--subtotal').html(response.data.subtotal);
                    $('#review__summary--shipping').html(response.data.shipping_total);
                    $('#review__summary--total').html('<strong>' + response.data.cart_total + '</strong>');

                    // Refresh applied coupon list
                    refreshAppliedCoupons(response.data.coupons);

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

    // Function to refresh the applied coupons list
    function refreshAppliedCoupons() {
        const couponListContainer = $('#applied_coupons_list');
        const appliedCouponsSection = $('.applied-coupons'); // Parent container for the coupons
        couponListContainer.empty(); // Clear the current list
    
        // Perform AJAX call to fetch applied coupons
        $.ajax({
            url: ajax_coupon_var.url, // AJAX endpoint
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_applied_coupons',
                nonce: ajax_coupon_var.nonce, // Security nonce
            },
            success: function (response) {
                if (response.success && response.data.coupons.length > 0) {
                    appliedCouponsSection.show(); // Show the section
    
                    response.data.coupons.forEach(function (coupon) {
                        const couponItem = `
                            <li class="applied-coupon-item" data-coupon="${coupon.code}">
                                <strong>${coupon.code}</strong>
                                <span class="remove-coupon" style="  cursor: pointer; margin-left: 10px;">X</span>
                            </li>`;
                        couponListContainer.append(couponItem);
                    });
    
                    // Add click handler for removing coupons
                    $('.remove-coupon').on('click', function () {
                        const couponCode = $(this).closest('.applied-coupon-item').data('coupon');
                        removeCouponCode(couponCode);
                    });
                } else {
                    appliedCouponsSection.hide(); // Hide the section when no coupons are applied
                }
            },
            error: function () {
                console.error('Failed to fetch applied coupons.');
                appliedCouponsSection.hide(); // Hide the section on error
            }
        });
    }
    
    

    // Function to remove a coupon code
    function removeCouponCode(couponCode) {
        const data = {
            action: 'remove_coupon',
            nonce: ajax_coupon_var.nonce,
            coupon_code: couponCode,
        };

        console.log(' ')
        console.log(' removeCouponCode:. data')
        console.log(data)
        console.log(' ')

        $.ajax({
            url: ajax_coupon_var.url, // Admin AJAX URL
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (response) {
                if (response.success) {
                    alert('Coupon removed successfully!');

                    // Refresh totals
                    $('#review__summary--subtotal').html(response.data.subtotal);
                    $('#review__summary--shipping').html(response.data.shipping_total);
                    $('#review__summary--total').html('<strong>' + response.data.cart_total + '</strong>');

                    // Refresh applied coupon list
                    refreshAppliedCoupons(response.data.coupons);
                } else {
                    alert(response.data.message || 'Failed to remove coupon.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('An error occurred while removing the coupon.');
            },
        });
    }

    // Initial load of applied coupons
    refreshAppliedCoupons(ajax_coupon_var.coupons);
});
