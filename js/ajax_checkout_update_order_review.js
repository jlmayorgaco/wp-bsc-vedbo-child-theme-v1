jQuery(document).ready(function ($) {
    $('form.woocommerce-checkout').on(
        'change',
        'select[name*="country"], input[name*="postcode"], select[name*="state"], input[name*="city"], input[name*="address"]',
        function () {
            const data = {
                action: ajax_var.action,
                nonce: ajax_var.nonce,
                payload: {
                    group: "group-skin-care",
                    page: "sk-rutina",
                    price: { min: 0, max: 100 },
                    categories: ["sk-rutina-s4-tonicos"],
                },
            };

            $.ajax({
                url: ajax_var.url,
                type: "POST",
                data: data,
                success: function (response) {
                    console.log("AJAX success:", response);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                },
            });
        }
    );
});
