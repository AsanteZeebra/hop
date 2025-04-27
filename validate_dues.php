<script>
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
    
      $('.mmonth').val(data[4]);
      $('.myear').val(data[3]);

    
    });
  
     // Handle form submission
     $.validator.setDefaults({
      submitHandler: function () {
        pay_dues();
      },
    });


    $(document).on('click', '.remove_input', function() {
     $(this).closest('.row').remove();
    });
     
     // Add more fields dynamically
     $('#add_more_fields').on('click', function() {
      var newFields = `
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                  
                    <select name="year[]" class="form-control tfyear">
                        <?php 
                            $currentYear = date('Y');
                            echo "<option value='{$currentYear}'>{$currentYear}</option>";
                            for ($i = 2008; $i <= $currentYear; $i++) {
                                echo "<option value='{$i}'>{$i}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                   
                    <select name="month[]" class="form-control tfmonth">
                        <?php
                            $months = [
                                'January', 'February', 'March', 'April', 'May', 
                                'June', 'July', 'August', 'September', 'October', 
                                'November', 'December'
                            ];
                            $currentMonth = date('F');
                            echo "<option value='{$currentMonth}'>{$currentMonth}</option>";
                            foreach ($months as $month) {
                                echo "<option value='{$month}'>{$month}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                
                    <input type="text" class="form-control tfamount text-center" name="amount[]" placeholder="0.00">
                </div>
            </div>
             <div class="col-2">
                    <div class="form-group">
                       
                       <button type="button" class="form-control btn btn-danger remove_input"><i class="fa fa-minus"></i></button>
                   
                    </div>
                </div>
        </div>`;
      $('#dynamic_fields').append(newFields);
    });

    
    // Method to save dues data
    function pay_dues() {
      var fd = new FormData();
      var name = $(".tfname").val();
      var member_id = $(".tfid").val();
      var dept = $(".tfdept").val();

      fd.append("member_name", name);
      fd.append("member_id", member_id);
      fd.append("department", dept);

      // Collect dynamic form data
      $("select[name='year[]']").each(function(index) {
        fd.append("year[]", $(this).val());
      });
      $("select[name='month[]']").each(function(index) {
        fd.append("month[]", $(this).val());
      });
      $("input[name='amount[]']").each(function(index) {
        fd.append("amount[]", $(this).val());
      });

      $.ajax({
        url: "save_dues.php",
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
  var month = $(".mmonth").val();
  var year = $(".myear").val();

  fd.append("month", month); // Change "odd" to "idd"
  fd.append("year", year);

  $.ajax({
    url: "delete_dues.php",
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

    // Validate the dues form
    $("#dues_form").validate({
      rules: {
        "year[]": { required: true },
        "month[]": { required: true },
        "amount[]": { required: true },
      },
      messages: {
        "year[]": { required: "Please select year" },
        "month[]": { required: "Please select month" },
        "amount[]": { required: "Please enter amount" },
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