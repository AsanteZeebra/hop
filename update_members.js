$(function () {
  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });





 


  // Handle update button click
  $(".upbtn").click(updateMember);

  // Function to update member info
  function updateMember() {
    var fd = new FormData();

    var name = $(".tfname").val();
    var dob = $(".tfdob").val();
    var age = $(".tfage").val();
    var alter = $(".tfalter").val();
    var gender = $(".cbgender").val();
    var marital = $(".cbmarital").val();
    var occupation = $(".tfoccupation").val();
    var telephone = $(".tftel").val();
    var spouse = $(".tfspouse").val();
    var children = $(".tfchild").val();
    var city = $(".tfcity").val();
    var region = $(".tfregion").val();
    var residence = $(".tfresidence").val();
    var postal = $(".tfpostal").val();
    var nextofkin = $(".tfnextofkin").val();
    var position = $(".tfposition").val();
    var member_id = $(".tfid").val();

    fd.append('fullname', name);
    fd.append('birthdate', dob);
    fd.append('age', age);
    fd.append('altercall', alter);
    fd.append('gender', gender);
    fd.append('marital', marital);
    fd.append('occupation', occupation);
    fd.append('telephone', telephone);
    fd.append('spouse', spouse);
    fd.append('child', children);
    fd.append('city', city);
    fd.append('region', region);
    fd.append('residence', residence);
    fd.append('postal', postal);
    fd.append('nextofkin', nextofkin);
    fd.append('position', position);
    fd.append('member_id', member_id);

    


    $.ajax({
      url: "update_members.php",
      type: "POST",
      data: fd,
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
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
      error: function(err) {
          Toast.fire({
              icon: "error",
              title: "Error: " + err.statusText,
          });
      },
  });
  }

  // Handle delete button click
  $(".delbtn").click(deleteMember);

  // Function to delete member info
  function deleteMember() {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        var ff = new FormData();
        ff.append("member_id", $(".tfid").val());

        $.ajax({
          url: "delete_profile.php",
          type: "POST",
          data: ff,
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
            handleResponse(data, "Information deleted successfully", "Unable to delete information");
            if (data != 0) setTimeout(() => window.history.back(), 1000);
          },
          error: function (err) {
            showErrorToast(err);
          },
        });
      }
    });
  }

  // Function to handle responses and display messages
  function handleResponse(data, successMessage, errorMessage) {
    if (data != 0) {
      Toast.fire({ icon: "success", title: successMessage });
      setTimeout(() => location.reload(), 1000);
    } else {
      Toast.fire({ icon: "error", title: errorMessage });
    }
  }

  // Function to show error toast
  function showErrorToast(err) {
    Toast.fire({ icon: "error", title: "Error: " + err.responseText });
  }
});
