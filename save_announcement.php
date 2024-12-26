<script>
   $(function() {
    
   var Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
    });

    $.validator.setDefaults({
        submitHandler: function () {
      confirm_send();
        },
      });


      function confirm_send() {
        $('.sbtn').click(function(){
        var note = $('.note').val();
     if(note ==""){
         alert("Please body cannot be empty");
     }else{
        send_report();
     }
    });
      }

   
  //method to save data
  function send_report() {
    var fd = new FormData();

  
    var name = $(".tfname").val();
    var tittle = $('.tfsave').val();
    var message = $('.note').val();
  


    
    fd.append("member_name", name);
    fd.append("tit",tittle);
    fd.append("message",message);
    

   

    $.ajax({
      url: "send_announcement.php",
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
        }
      },
      error: function (err) {
        alert("In error: " + err.responseText);
      },
    });
  }


  $("#atform").validate({
    rules: {
      saveas: {
        required: true,
      },
      name: {
        required: true,
      },
      id: {
        required: true,
      },
      message: {
        required: true,
      },
      
      
    },
    messages: {
      saveas: {
        required: "Please give your report a name",
      },
      name: {
        required: "Please enter your name",
      },
      message: {
        required: "Cannot save empty report",
      },
      id: {
        required: "Member your member ID#",
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
})
</script>