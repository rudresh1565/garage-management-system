document.addEventListener("DOMContentLoaded", function () {
    var forms = document.querySelectorAll(".needs-validation");

    forms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            var valid = true;
            var requiredFields = form.querySelectorAll("[data-required='true']");

            requiredFields.forEach(function (field) {
                var value = field.value.trim();
                var feedback = field.parentElement.querySelector(".invalid-feedback");

                if (value === "") {
                    valid = false;
                    field.classList.add("is-invalid");
                    if (feedback) {
                        feedback.textContent = field.dataset.message || "This field is required.";
                    }
                } else {
                    field.classList.remove("is-invalid");
                }

                if (field.dataset.type === "phone" && value !== "") {
                    var phonePattern = /^[0-9]{10,15}$/;
                    if (!phonePattern.test(value)) {
                        valid = false;
                        field.classList.add("is-invalid");
                        if (feedback) {
                            feedback.textContent = "Enter a valid phone number using 10 to 15 digits.";
                        }
                    }
                }

                if (field.dataset.type === "number" && value !== "") {
                    if (isNaN(value) || Number(value) < 0) {
                        valid = false;
                        field.classList.add("is-invalid");
                        if (feedback) {
                            feedback.textContent = "Enter a valid positive number.";
                        }
                    }
                }
            });

            if (!valid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    });
});
