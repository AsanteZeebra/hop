$(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    // Bind click event to populate the form based on table row data
    $('.btt').on('click', function() {
        var $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
    
        console.log(data);
    
        // Set the values from the table row into form fields
        $('.tfid').val(data[1]);
        $('.tfname').val(data[2]);
    });

   

    $.validator.setDefaults({
        submitHandler: function () {
            mark_att(); // Move actual save functionality here
        },
    });

    function mark_att() {
        var fd = new FormData();

        var name = $(".tfname").val();
        var member_id = $(".tfid").val();
        var status = $(".tfstatus").val();
        var reason = $(".tfnote").val();

        fd.append("fullname", name);
        fd.append("member_id", member_id);
        fd.append("status", status);
        fd.append("note", reason);

        $.ajax({
            url: "save_att.php",
            type: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data != 0) {
                    Toast.fire({
                        icon: "success",
                        title: data,
                    });
                    $("#acform")[0].reset(); // Reset form on success
                    setTimeout(function () {
                        location.reload();
                    }, 1000); // Consolidated reload into one place
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "Unable to save data",
                    });
                }
            },
            error: function (err) {
                Toast.fire({
                    icon: "error",
                    title: "Error: " + err.statusText,
                });
            },
        });
    }

    $("#acform").validate({
        rules: {
            fullname: {
                required: true,
            },
            member_id: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        messages: {
            fullname: {
                required: "Please enter Fullname",
            },
            member_id: {
                required: "Please enter member ID",
            },
            status: {
                required: "Please choose status",
            },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        },
    });
});
