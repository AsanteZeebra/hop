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


      //method to save data
  function record_expenses() {
    var fd = new FormData();

  
    var name = $(".tfcat").val();
    var date = $(".tfdate").val();
    var telephone = $(".tfamount").val();
    var adddress = $(".tfdetails").val();
    var benefit  = $(".tfbenefit").val();
    var id = $(".tfidd").val();
    var type = $('.tftype').val();
    var cheque = $('.tfcheque').val();

  

    fd.append("category", name);
    fd.append("date",date);
    fd.append("amount",telephone);
    fd.append("details",adddress);
    fd.append("benefit",benefit);
     fd.append("idd",id);
     fd.append("extype",type);
     fd.append("cheque_no",cheque);

    
   

    $.ajax({
      url: "save_mens_expenses.php",
      type: "POST",
      data: fd,
      contentType: false,
      cache: false,
      //dataType:"JSON",
      processData: false,
      success: function (data) {
        if (data != 0) {
          Toast.fire({
            icon: "success",
            title: data,
          });
  
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
           // window.location.href = "manage_expenses.php";
        }
      },
      error: function (err) {
        alert("In error: " + err.responseText);
      },
    });
  }
  


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
          },
          benefit: {
            required: true,
          },
          details: {
            required: true,
          },
          extype: {
            required:true,
          },
         
          
        },
        messages: {
          category: {
            required: "Please enter category",
          },
          date: {
            required: "Please choose date",
          },
          amount: {
            required: "Please enter amount(¢)",
          },
          benefit: {
            required: "Please enter Benefitiary name",
          },
          details: {
            required: "Please please enter details in case of futher explanation",
          },
          extype: {
            required: "Please choose expense type",
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