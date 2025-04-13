
$(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
  

 // Handle the click event for the delete button
 $('.delbtn').on('click', function() {
  delete_dues();
});


      function delete_dues() {
        var fd = new FormData();
      
        // Collect form data
        var id = $(".tfid").val();
      
        fd.append("idd", id); // Change "odd" to "idd"
      
        $.ajax({
          url: "delete_benefit.php",
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
              setTimeout(function () {
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
              icon: "error",
              title: "An error occurred",
              text: err.responseText,
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
  $('.tfid').val(data[0]);

});







      $.validator.setDefaults({
        submitHandler: function () {
        record_benefits();
        },
      });

      function record_benefits() {
        var fd = new FormData();
    
      
        var name = $(".tfname").val();
        var member_id = $(".tfid").val();
        var amount = $(".tfamount").val();
        var benefit  = $(".tfbenefit").val();
        var telephone = $('.tftelephone').val();
        var adddress = $('.tfaddress').val();
        var comment = $('.tfcomment').val();
        var status = $('.tfstatus').val();
        var department = $('.tfdepartment').val();
      
        
    
        fd.append("name", name);
        fd.append("member_id", member_id);
        fd.append("amount", amount);
        fd.append("benefit", benefit);
        fd.append("member_id", member_id);
        fd.append("telephone", telephone);
        fd.append("address", adddress);
        fd.append("comment", comment);
        fd.append("status", status);
        fd.append("department", department);
        
       
    
        $.ajax({
          url: "record_benefit.php",
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
    
      $("#benefit_form").validate({
        rules: {
          fullname: {
            required: true,
          },
          member_id: {
            required: true,
          },
          benefit: {
            required: true,
          },
          amount: {
            required: true,
          },
          telephone: {
            required: true,
          },
          address: {
            required: true,
          },
          comment: {
            required: true,
          },
          status: {
            required: true,
          },
          approved_by: {
            required: true,
          },

          
        },
        messages: {
          fullname: {
            required: "Please choose fullname",
          },
          member_id: {
            required: "Please choose member id",
          },
          benefit: {
            required: "Please choose benefit type",
          },
          amount: {
            required: "Member ID not detected",
          },
          telephone: {
            required: "Member Name not detected",
          },
          address: {
            required: "Please enter address",
          },
            comment: {
                required: "Please enter comment",
            },
            status: {
                required: "Please select status",
            },
            approved_by: {
                required: "Please enter officer's Name",
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