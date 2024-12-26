$(function () {
    // Show Bootstrap toast notification
    function showToast(icon, message) {
        var toast = $('#bootstrapToast');
        toast.find('.toast-body').text(message);

        // Set title and styling based on icon type
        if (icon === "success") {
            toast.find('.toast-title').text("Success").removeClass("text-danger").addClass("text-success");
        } else {
            toast.find('.toast-title').text("Error").removeClass("text-success").addClass("text-danger");
        }

        // Show the toast
        var bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
    }

    // Handle the confirm button click event
    $('.btconfirm').on('click', function () {
        if (validateForm()) {
            pay_dues();
        }
    });

    // Method to validate the form fields
    function validateForm() {
        var amount = $('.tfamount').val();
        var name = $(".tfname").val();
        var member_id = $(".tfid").val();
        var telephone = $(".tftel").val();
        var address = $(".tfaddress").val();

        if (amount === "") {
            alert("Please Enter Amount");
            return false;
        }
        if (name === "") {
            alert("Please Enter Name");
            return false;
        }
        if (member_id === "") {
            alert("Please Enter Member ID");
            return false;
        }
        if (telephone === "") {
            alert("Please Enter Telephone");
            return false;
        }
        if (address === "") {
            alert("Please Enter Address");
            return false;
        }

        return true;
    }

    // Method to save data
    function pay_dues() {
        var fd = new FormData();

        var name = $(".tfname").val();
        var member_id = $(".tfid").val();
        var telephone = $(".tftel").val();
        var address = $(".tfaddress").val();
        var amount = $(".tfamount").val();

        fd.append("member_name", name);
        fd.append("member_id", member_id);
        fd.append("telephone", telephone);
        fd.append("address", address);
        fd.append("amount", amount);

        $.ajax({
            url: "save_dues.php",
            type: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.trim() !== "0") {
                    showToast("success", data);
                    // Reload the page after 1 second if data is not 0
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showToast("error", "Unable to save data");
                }
            },
            error: function (err) {
                showToast("error", "An error occurred: " + err.responseText);
            }
        });
    }
});
