$(function() {
    // Initialize Toast notifications
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    // Function to create an account
    function createAccount() {
        const formData = new FormData();
        formData.append("member_id", $(".tfmemid").val());
        formData.append("password", $(".tfpass").val());

        $.ajax({
            url: "change_pass.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $('.submit-btn').prop('disabled', true).text('Creating account...');
            },
            success: (response) => {
                try {
                    const data = JSON.parse(response);

                    if (Array.isArray(data) && data.length > 0) {
                        // Display each error message returned from the server
                        data.forEach((error) => {
                            Toast.fire({ icon: "info", title: error });
                        });
                        setTimeout(() => window.location.href = 'index.php', 100); // Redirect after success
                    } else {
                        Toast.fire({ icon: "success", title: data });
                        $('#acform')[0].reset(); // Reset form
                        $('.is-invalid').removeClass('is-invalid');
                        setTimeout(() => window.location.href = 'index.php', 100); // Redirect after success
                    }
                } catch (e) {
                    Toast.fire({ icon: "info", title: response });
                }
            },
            error: (xhr) => {
                Toast.fire({ icon: "info", title: `Error: ${xhr.responseText}` });
            },
            complete: () => {
                $('.submit-btn').prop('disabled', false).text('Create Account');
            }
        });
    }

    // Set default behavior for the form validation plugin
    $.validator.setDefaults({
        submitHandler: () => createAccount(),
    });

    // Initialize form validation
    $("#acform").validate({
        rules: {
            memid: {
                required: true,
            },
            password: {
                required: true,
                minlength: 6,
            },
            resetpassword: {
                required: true,
                equalTo: "#password",
                minlength: 6,
            },
        },
        messages: {
            memid: {
                required: "Please enter member ID",
            },
            password: {
                required: "Please enter password",
                minlength: "Your password must be at least 6 characters long",
            },
            resetpassword: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match",
                minlength: "Your password must be at least 6 characters long",
            },
        },
        errorElement: "span",
        errorPlacement: (error, element) => {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: (element) => $(element).addClass("is-invalid"),
        unhighlight: (element) => $(element).removeClass("is-invalid"),
        invalidHandler: (event, validator) => {
            if (validator.numberOfInvalids()) {
                $(validator.errorList[0].element).focus();
            }
        }
    });
});
