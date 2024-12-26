$(function () {
  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });

  // Handle click event for the confirm button
  $('.btconfirm').on('click', function () {
    if ($('.tfamount').val().trim() === "") {
      Toast.fire({
        icon: "error",
        title: "Please enter an amount",
      });
    } else {
      pay_dues();
    }
  });

  // Method to save dues data
  function pay_dues() {
    var fd = new FormData();

    var name = $(".tfname").val();
    var member_id = $(".tfid").val();
    var telephone = $(".tftel").val();
    var address = $(".tfaddress").val();  // Fixed typo: 'adddress' to 'address'
    var amount = $(".tfamount").val();

    fd.append("member_name", name);
    fd.append("member_id", member_id);
    fd.append("telephone", telephone);
    fd.append("address", address);
    fd.append("amount", amount);

    $.ajax({
      url: "save_womens_dues.php",
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
});
