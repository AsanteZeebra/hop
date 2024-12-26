$(function() {
  var Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
  });

  $.validator.setDefaults({
      submitHandler: function() {
          create_account();
      },
  });

  function create_account() {
      var fd = new FormData();

      var name = $(".tfname").val();
      var member_id = $(".tfmemid").val();
      var department = $(".tfdepartment").val();
      var role = $(".tfrole").val();
      var password = $(".tfpass").val();
      var csrf_token = $('input[name="csrf_token"]').val();  // Assuming CSRF token is present in the form

      fd.append("fullname", name);
      fd.append("member_id", member_id);
      fd.append("department", department);
      fd.append("role", role);
      fd.append("password", password);
      fd.append("csrf_token", csrf_token);  // Adding CSRF token to the form data

      $.ajax({
          url: "save_account.php",
          type: "POST",
          data: fd,
          contentType: false,
          cache: false,
          processData: false,
          success: function(data) {
              if (data != 0) {
                  Toast.fire({
                      icon: "success",
                      title: data,
                  });
                  $("#acform")[0].reset(); // Reset form on success
              } else {
                  Toast.fire({
                      icon: "error",
                      title: "Unable to save data",
                  });
              }

              if (data != 0) {
                  setTimeout(function() {
                      location.reload();
                  }, 1000)
              }
          },
          error: function(err) {
              Toast.fire({
                  icon: "error",
                  title: "Error: " + err.statusText,
              });
          },
      });
  }




    // Handle the click event for the delete button
    $('.btdel').on('click', function() {
        var $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        // Set the values from the table row into form fields
        $('.ddt').val(data[1]);
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
            url: "delete_account.php",
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



  $("#acform").validate({
      rules: {
          fullname: {
              required: true,
          },
          memid: {
              required: true,
          },
          department: {
              required: true,
          },
          role: {
              required: true,
          },
          password: {
              required: true,
              minlength: 6,
          },
          repeatpass: {
              required: true,
              equalTo: "#password",
              minlength: 6,
          },
      },
      messages: {
          fullname: {
              required: "Please enter Fullname",
          },
          memid: {
              required: "Please enter member ID",
          },
          department: {
              required: "Please select department",
          },
          role: {
              required: "Please select role",
          },
          password: {
              required: "Please enter password",
              minlength: "Password must be at least 6 characters long",
          },
          repeatpass: {
              required: "Please confirm your password",
              equalTo: "Passwords do not match",
          },
      },
      errorElement: "span",
      errorPlacement: function(error, element) {
          error.addClass("invalid-feedback");
          element.closest(".form-group").append(error);
      },
      highlight: function(element, errorClass, validClass) {
          $(element).addClass("is-invalid");
      },
      unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
      },
  });
});
