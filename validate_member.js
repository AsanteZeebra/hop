$(function () {
  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });

  // Set default submitHandler for form validation
  $.validator.setDefaults({
    submitHandler: function () {
      save_member();
    },
  });

  
    $('.tfdob').on('change', function() {
      // Get the date of birth value
      var dob = $('.tfdob').val();
      
      if(dob) {
          // Calculate the age
          var dobDate = new Date(dob);
          var today = new Date();
          var age = today.getFullYear() - dobDate.getFullYear();
          var monthDifference = today.getMonth() - dobDate.getMonth();

          // If the birthday hasn't occurred yet this year, subtract 1 from the age
          if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dobDate.getDate())) {
              age--;
          }

          // Display the age in the age input field
          $('.tfage').val(age);
      } else {
          $('.tfage').val('');
      }
  });
  

  // Handle back button click event
  $('.back').click(function(){
    if (document.referrer) {
      window.location.href = document.referrer;
    } else {
      window.history.back();
    }
  });

  // Method to save data
  function save_member() {
    var fd = new FormData();

    // Collect form data
    var data = {
      fullname: $(".tfname").val(),
      birthdate: $(".tfdob").val(),
      altercall: $(".tfalter").val(),
      gender: $(".cbgender").val(),
      marital: $(".cbmarital").val(),
      age: $(".tfage").val(),
      occupation: $(".tfoccupation").val(),
      telephone: $(".tftel").val(),
      spouse: $(".tfspouse").val(),
      child: $(".tfchild").val(),
      city: $(".tfcity").val(),
      region: $(".tfregion").val(),
      residence: $(".tfresidence").val(),
      postal: $(".tfpostal").val(),
      nextofkin: $(".tfnextofkin").val()
    };

    // Append data to FormData object
    $.each(data, function(key, value) {
      fd.append(key, value);
    });

    $.ajax({
      url: "save_client_info.php",
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
            location.reload(); // Reload the page after a short delay
          }, 1000);
        } else {
          Toast.fire({
            icon: "error",
            title: "Unable to save data",
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

  // Form validation rules and messages
  $("#member_form").validate({
    rules: {
      fullname: { required: true },
      dob: { required: true },
      age: { required: true },
      altercall: { required: true },
      gender: { required: true },
      marital: { required: true },
      occupation: { required: true },
      telephone: { required: true },
      children: { required: true },
      city: { required: true },
      region: { required: true },
      address: { required: true },
      box: { required: true },
      nextofkin: { required: true },
    },
    messages: {
      fullname: { required: "Please enter the full name" },
      dob: { required: "Please enter the date of birth" },
      age: { required: "Please enter age" },
      altercall: { required: "Please enter the date of alter call" },
      gender: { required: "Please select gender" },
      marital: { required: "Please select marital status" },
      occupation: { required: "Please enter occupation" },
      telephone: { required: "Please enter telephone number" },
      city: { required: "Please enter city / town" },
      children: { required: "Please enter number of children" },
      region: { required: "Please enter region" },
      address: { required: "Please enter address" },
      box: { required: "Please enter postal box address" },
      nextofkin: { required: "Please enter next of kin" },
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
