<script>
$(function () {
  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });

  $.validator.setDefaults({
    submitHandler: function () {
      record_expenses();
    },
  });

  function record_expenses() {
    var fd = new FormData();

    var category = $(".tfcat").val();
    var expenseDate = $(".tfdate").val();
    var amount = $(".tfamount").val();
    var details = $(".tfdetails").val();
    var benefit = $(".tfbenefit").val();
    var id = $(".tfidd").val();
    var expenseType = $('.type').val();
    var cheque = $('.tfcheque').val();
    var dept = $('.tfdept').val();

    fd.append("category", category);
    fd.append("date", expenseDate);
    fd.append("amount", amount);
    fd.append("details", details);
    fd.append("benefit", benefit);
    fd.append("idd", id);
    fd.append("type", expenseType);
    fd.append("cheque", cheque);
    fd.append("department", dept);

    $.ajax({
      url: "save_expenses.php",
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
      }
    });
  }

  $("#warefare").validate({
    rules: {
      category: {
        required: true,
      },
      date: {
        required: true,
      },
      amount: {
        required: true,
      },
      benefit: {
        required: true,
      },
      details: {
        required: true,
      },
      extype: {
        required: true,
      },
    },
    messages: {
      category: {
        required: "Please enter category",
      },
      extype: {
        required: "Please choose expense type",
      },
      date: {
        required: "Please choose date",
      },
      amount: {
        required: "Please enter amount(¢)",
      },
      benefit: {
        required: "Please enter Beneficiary name",
      },
      details: {
        required: "Please enter details in case of further explanation",
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
</script>
