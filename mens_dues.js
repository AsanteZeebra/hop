
$(function () {
    var Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
    });



$('.btconfirm').on('click',function () {
    if($('.tfamount').val() ===""){
        alert("Please Enter Amount")
    }else{
        pay_dues();
    }
})
  //method to save data
  function pay_dues() {
    var fd = new FormData();

  
    var name = $(".tfname").val();
    var member_id = $(".tfid").val();
    var telephone = $(".tftel").val();
    var adddress = $(".tfaddress").val();
    var amount = $(".tfamount").val();

 


    fd.append("member_name", name);
    fd.append("member_id",member_id);
    fd.append("telephone",telephone);
    fd.append("address",adddress);
    fd.append("amount",amount);
   

    $.ajax({
      url: "save_mens_dues.php",
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
  
});