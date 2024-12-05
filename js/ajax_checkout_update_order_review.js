// , input[name*="city"], input[name*="address"], select[name*="country"], input[name*="postcode"] 
jQuery(document).ready(function ($) {
    // Trigger AJAX on state change
    $('form.woocommerce-checkout').on('change', 'select[name*="state"]', function () {
        const selectedState = $(this).val(); // Get the selected state value

        const data = {
            action: ajax_checkout__update.action, // Action name
            nonce: ajax_checkout__update.nonce, // Security nonce
            payload: {
                state: selectedState, // Include the selected state in the payload
            },
        };

        console.log("AJAX request data:", data); // Debugging: Log the data being sent

        $.ajax({
            url: ajax_checkout__update.url, // admin-ajax.php URL
            type: "POST",
            dataType: "json", // Expect JSON response
            data: data,
            success: function (response) {
                if (response.success) {
                    console.log("AJAX success:", response.data);

                    // Update DOM elements with new values from response
                    if (response.data.subtotal) {
                        $('#review__summary--subtotal').html(response.data.subtotal);
                    }
                    if (response.data.shipping_total) {
                        $('#review__summary--shipping').html(response.data.shipping_total);
                    }
                    if (response.data.total) {
                        $('#review__summary--total').html('<strong>' + response.data.total + '</strong>');
                    }
                } else {
                    console.error("AJAX error:", response.data);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            },
        });
    });
});
