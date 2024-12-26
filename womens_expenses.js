$(function () {
  // Configure SweetAlert2 for toast notifications
  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });

  // Set default behavior for form submission
  $.validator.setDefaults({
    submitHandler: function () {
      record_expenses();
    },
  });

  // Method to save expense data
  function record_expenses() {
    var fd = new FormData();

    var category = $(".tfcat").val();
    var date = $(".tfdate").val();
    var amount = $(".tfamount").val();  // Renamed from 'telephone' for clarity
    var details = $(".tfdetails").val();  // Fixed typo: 'adddress' to 'details'
    var benefit = $(".tfbenefit").val();
    var id = $(".tfidd").val();
    var type = $('.tftype').val();
    var cheque = $('.tfcheque').val();

    // Append data to FormData object
    fd.append("category", category);
    fd.append("date", date);
    fd.append("amount", amount);
    fd.append("details", details);
    fd.append("benefit", benefit);
    fd.append("id", id);  // Changed from 'idd' to 'id' for consistency
    fd.append("type", type);  // Changed from 'extype' to 'type' for consistency
    fd.append("cheque_no", cheque);

    // Make an AJAX request to save the data
    $.ajax({
      url: "save_womens_expenses.php",
      type: "POST",
      data: fd,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data) {
          Toast.fire({
            icon: "success",
            title: data,
          });
          setTimeout(function () {
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
        Toast.fire({
          icon: "error",
          title: "An error occurred: " + err.responseText,
        });
      },
    });
  }

  // Validate the expense form
  $("#ywarefare").validate({
    rules: {
      category: {
        required: true,
      },
      date: {
        required: true,
      },
      amount: {
        required: true,
        number: true, // Ensures the amount is a number
      },
      benefit: {
        required: true,
      },
      details: {
        required: true,
      },
      type: {
        required: true,
      },
    },
    messages: {
      category: {
        required: "Please enter a category",
      },
      date: {
        required: "Please choose a date",
      },
      amount: {
        required: "Please enter an amount",
        number: "Please enter a valid number", // Error message for non-numeric input
      },
      benefit: {
        required: "Please enter the beneficiary's name",
      },
      details: {
        required: "Please provide details for further explanation",
      },
      type: {
        required: "Please select an expense type",
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
