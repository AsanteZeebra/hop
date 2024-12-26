<script>

  $(function () {
    var Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
    });



    $('.btmark').on('click', function () {
      $tr = $(this).closest('tr');

      var data = $tr.children("td").map(function () {
        return $(this).text();
      }).get();

      console.log(data);


      var fullname = $('.tfname').val(data[1]);
      var id = $('.tfid').val(data[0]);


    });

    $('.btmark1').on('click', function () {
      $tr = $(this).closest('tr');

      var data = $tr.children("td").map(function () {
        return $(this).text();
      }).get();

      console.log(data);


      var fullname = $('.tfname1').val(data[1]);
      var id = $('.tfid1').val(data[0]);


    });

    $('.ll').on('click', function () {
      $tr = $(this).closest('tr');

      var data = $tr.children("td").map(function () {
        return $(this).text();
      }).get();

      console.log(data);


      var month = $('.tfm').val(data[3]);
      var id = $('.tfd').val(data[0]);
      var year = $('.tfy').val(data[2]);
      var week = $('.tfw').val(data[4]);


    });



    //method to save data
    function attendance() {
      var fd = new FormData();


      var name = $(".tfname").val();
      var member_id = $(".tfid").val();
      var year = $(".tfyear").val();
      var month = $(".tfmonth").val();
      var week = $(".tfweek").val();
      var stat = $('.sttt').val();


      fd.append("member_name", name);
      fd.append("member_id", member_id);
      fd.append("year", year);
      fd.append("month", month);
      fd.append("week", week);
      fd.append("st", stat);



      $.ajax({
        url: "mark_attendance.php",
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
            setTimeout(function () {
              location.reload();
            }, 1000)
          }
        },
        error: function (err) {
          alert("In error: " + err.responseText);
        },
      });
    }




    //method to save data
    function abscent() {
      var fd = new FormData();


      var name = $(".tfname1").val();
      var member_id = $(".tfid1").val();




      fd.append("member_name", name);
      fd.append("member_id", member_id);


      $.ajax({
        url: "mark_abscent.php",
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
            setTimeout(function () {
              location.reload();
            }, 1000)
          }
        },
        error: function (err) {
          alert("In error: " + err.responseText);
        },
      });
    }

    $.validator.setDefaults({
      submitHandler: function () {
        attendance();
      },
    });

    $('.delbtn').click(function () {
      delete_attendance();
    })
    //delete
    //method to save data
    function delete_attendance() {



      var fa = new FormData();

      var id = $(".tfd").val();
      var month = $(".tfm").val();
      var year = $(".tfy").val();
      var week = $(".tfw").val();
      var status = $('.tfstatus').val();


      fa.append("idd", id);
      fa.append("yy", year);
      fa.append("mm", month);
      fa.append("ww", week);
      fa.append("stat", status);


      $.ajax({
        url: "delete_attendance.php",
        type: "POST",
        data: fa,
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
            setTimeout(function () {
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
        year: {
          required: true,
        },
        month: {
          required: true,
        },
        week: {
          required: true,
        },
        idd: {
          required: true,
        },
        nmm: {
          required: true,
        },
        status: {
          required: true,
        },

      },
      messages: {
        year: {
          required: "Please select year",
        },
        month: {
          required: "Please select month",
        },
        week: {
          required: "Please select week",
        },
        idd: {
          required: "Member ID not detected",
        },
        nmm: {
          required: "Member Name not detected",
        },
        status: {
          required: "Please choose status",
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