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
    $('.tfid').val(data[0]);
    $('.tfyear').val(data[1]);
    $('.tfmonth').val(data[2]);
  });

  // Set default submitHandler for form validation
  $.validator.setDefaults({
    submitHandler: function () {
      pay_dues();
    },
  });

  // Method to save dues data
  function pay_dues() {
    var fd = new FormData();

    // Collect form data
    var name = $(".tfname").val();
    var member_id = $(".tfid").val();
    var month = $(".tfmonth").val();
    var year = $(".tfyear").val();
    var amount = $(".tfamount").val();

    fd.append("member_name", name);
    fd.append("member_id", member_id);
    fd.append("year", year);
    fd.append("month", month);
    fd.append("amount", amount);

    $.ajax({
      url: "save_mens_dues.php",
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

  // Handle the click event for the delete button
  $('.delbtn').on('click', function() {
    delete_dues();
  });

  // Method to delete dues data
  function delete_dues() {
    var fd = new FormData();

    // Collect form data
    var member_id = $(".tfid").val();
    var month = $(".tfmonth").val();
    var year = $(".tfyear").val();

    fd.append("member_id", member_id);
    fd.append("year", year);
    fd.append("month", month);

    $.ajax({
      url: "delete_mens_dues.php",
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

  // Validate the dues form
  $("#dues_form").validate({
    rules: {
      year: { required: true },
      month: { required: true },
      amount: { required: true },
    },
    messages: {
      year: { required: "Please select year" },
      month: { required: "Please select month" },
      amount: { required: "Please enter amount" },
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
