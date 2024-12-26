$(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    // Handle the click event for the delete button
    $('.btdel').on('click', function() {
        var $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        // Set the values from the table row into form fields
        $('.ddt').val(data[0]);
    });

    // Handle the click event for the delete button
    $('.btdel').on('click', function() {
        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_ann(); // Call the delete function if confirmed
            }
        });
    });

    // Method to delete dues data
    function delete_ann() {
        var fd = new FormData();

        // Collect form data
        var idd = $(".ddt").val();

        fd.append("rid", idd);

        $.ajax({
            url: "delete_announcement.php",
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data != 0) {
                    Toast.fire({
                        icon: "success",
                        title: data,
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "Unable to delete data",
                    });
                }
            },
            error: function (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred',
                    text: err.responseText
                });
            },
        });
    }
});
