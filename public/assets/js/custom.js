document.addEventListener("DOMContentLoaded", () => {
    function handleAjaxForm(selector, delay = 1000) {
        $(document).on("submit", selector, function (event) {
            event.preventDefault();
            const form = $(this);

            $.ajax({
                type: form.attr("method"),
                url: form.attr("action"),
                headers: {
                    Accept: "application/json",
                },
                beforeSend: function () {
                    JDLoader.open();
                },
                dataType: "json",
                data: form.serialize(),
                success: function (result) {
                    JDLoader.close();

                    if (result.status === "success") {
                        toastr.success(result.message || "Success", "Success");

                        setTimeout(() => {
                            if (result.url) window.location = result.url;
                        }, delay);

                        if (form.hasClass("resetForm")) {
                            const csrfToken = form
                                .find('input[name="_token"]')
                                .val();
                            form[0].reset();
                            form.find('input[name="_token"]').val(csrfToken);
                        }
                    } else {
                        toastr.error(
                            result.message || "An error occurred",
                            "Error"
                        );

                        setTimeout(() => {
                            if (result.url) window.location = result.url;
                        }, delay);
                    }
                },
                error: function (xhr) {
                    JDLoader.close();

                    const errors = xhr.responseJSON || {};
                    toastr.error(
                        errors.message || "An unknown error occurred.",
                        "Error"
                    );
                },
            });
        });
    }

    // Usage
    handleAjaxForm(".ajaxForm", 3500); // slower
    handleAjaxForm(".ajaxForm2", 500); // faster
});
// Numbers only inputs
document.querySelectorAll("input[integer]").forEach(function (input) {
    input.addEventListener("input", function () {
        // Replace any non-digit characters with an empty string
        this.value = this.value.replace(/[^0-9]/g, "");
    });
});
