$(function() {
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
  });

  // Edit button click handler
  $('.tdedit').on('click', function() {
      var $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
          return $(this).text().trim(); // trim to remove extra spaces
      }).get();

      console.log(data);

      // Update fields with values from the selected row
      $('.td1').text(data[0]);
      $('.td2').text(data[1]);
      $('.td3').text(data[2]);
      $('.td4').text(data[3]);
      $('.tf6').val(data[0]);
      $('.tfamount').val(data[6]); // assuming this is the correct index for amount
  });

  // Delete button click handler
  $('.btdel').on('click', function() {
      var $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
          return $(this).text().trim(); // trim to remove extra spaces
      }).get();

      console.log(data);

      $('.ddt').val(data[0]);
  });

  // Refuse action
  $('.btr').click(function() {
      performAction('youth_reject.php', 'refer', '.tf6');
  });

  // Make decision action
  $('.btt').click(function() {
      performAction('youth_decide.php', 'refer', '.tf6');
  });

  // Common function to handle form actions
  function performAction(url, fieldName, fieldSelector) {
      var ff = new FormData();
      var fieldValue = $(fieldSelector).val();

      ff.append(fieldName, fieldValue);

      $.ajax({
          url: url,
          type: "POST",
          data: ff,
          contentType: false,
          cache: false,
          processData: false,
          success: function(data) {
              if (data.trim() != "0") {
                  Toast.fire({
                      icon: 'success',
                      title: data
                  });
                  setTimeout(function() {
                      location.reload();
                  }, 1000);
              } else {
                  Toast.fire({
                      icon: 'error',
                      title: "UNABLE TO RECORD TRANSACTION"
                  });
              }
          },
          error: function(err) {
              Toast.fire({
                  icon: 'error',
                  title: "Error: " + err.responseText
              });
          }
      });
  }
});
