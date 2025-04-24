document.addEventListener("DOMContentLoaded", () => {
    function handleAjaxForm(selector, delay = 1000) {
        $(document).on("submit", selector, function (event) {
            event.preventDefault();
            const form = $(this);
            // Check if the form is valid
            if (form[0].checkValidity && !form[0].checkValidity()) {
                // Trigger the browser's native form validation UI
                form[0].reportValidity();
                return;
            }
            $.ajax({
                type: form.attr("method"),
                url: form.attr("action"),
                headers: {
                    Accept: "application/json",
                },
                beforeSend: function () {
                    JDLoader.open(".loader-mask");
                },
                dataType: "json",
                timeout: 30000,
                data: form.serialize(),
                success: function (result) {
                    JDLoader.close(".loader-mask");

                    if (result.status === "success") {
                        toastr.success(result.message || "Success", "Success");

                        handleRedirect(result.url);

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
                        handleRedirect(result.url);
                    }
                },
                error: function (xhr) {
                    JDLoader.close(".loader-mask");

                    const errors = xhr.responseJSON || {};
                    toastr.error(
                        errors.message || "An unknown error occurred.",
                        "Error"
                    );
                },
                complete: function () {
                    JDLoader.close(".loader-mask");
                },
            });
        });
    }
    const handleRedirect = (url) => {
        if (url) {
            setTimeout(() => {
                window.location = url;
            }, delay);
        }
    };
    // Usage
    handleAjaxForm(".ajaxForm", 3500); // slower
    handleAjaxForm(".ajaxForm2", 500); // faster
    // Numbers only inputs
    document.querySelectorAll("input[integer]").forEach(function (input) {
        input.addEventListener("input", function () {
            // Replace any non-digit characters with an empty string
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });

    document.querySelectorAll(".password-toggle").forEach((toggle) => {
        toggle.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            const input = document.getElementById(targetId);
            if (input) {
                input.type = input.type === "password" ? "text" : "password";
            }
        });
    });
});
