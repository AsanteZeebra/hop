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
         initiate_move();
          },
        });




        
  //method to save data
  function initiate_move() {
    var fd = new FormData();

    var name = $(".tfname").val();
    var member_id = $(".tfid").val();
    var department = $(".tfdepartment").val();
   


    fd.append("fullname", name);
    fd.append("member_id",member_id);
    fd.append("department",department);
   
    $.ajax({
      url: "move.php",
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




        $('.btm').on('click', function() {
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);


            var id = $('.tfid').val(data[1]);
            var name = $('.tfname').val(data[2]);
          
           
        })
        

        $("#ppp").validate({
            rules: {
              memid: {
                required: true,
              },
              fullname: {
                required: true,
              },
              department: {
                required: true,
              },
             
              
            },
            messages: {
              memid: {
                required: "Unable to detect Member ID",
              },
              fullname: {
                required: "Unable to detect Member's Name",
              },
              department: {
                required: "Unable to detect department",
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