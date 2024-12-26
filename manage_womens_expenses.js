$(function() {
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
  });

  // Handle edit button click
  $('.tdedit').on('click', function() {
      var $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
          return $(this).text().trim(); // Use trim() to remove any extra whitespace
      }).get();

      console.log(data);

      // Update fields with values from the selected row
      $('.td1').text(data[0]);
      $('.td2').text(data[1]);
      $('.td3').text(data[2]);
      $('.td4').text(data[3]);
      $('.td5').val(data[6]);
      $('.tf6').val(data[0]);
  });

  // Handle delete button click
  $('.btdel').on('click', function() {
      var $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
          return $(this).text().trim(); // Use trim() to remove any extra whitespace
      }).get();

      console.log(data);

      $('.ddt').val(data[0]);
  });

  // Handle delete expenses action
  $('.dbt').on('click', function() {
      delete_expenses();
  });

  // Handle make decision action
  $('.btt').on('click', function() {
      make_decision();
  });

  // Handle refuse action
  $('.btr').on('click', function() {
      refuse();
  });

  // Function to refuse action
  function refuse() {
      var ff = new FormData();
      var ucode = $('.tf6').val();

      ff.append('refer', ucode);

      $.ajax({
          url: "youth_reject.php",
          type: "POST",
          data: ff,
          contentType: false,
          cache: false,
          processData: false,
          success: function(data) {
              handleResponse(data, "Unable to record transaction");
          },
          error: function(err) {
              Toast.fire({
                  icon: 'error',
                  title: "Error: " + err.responseText
              });
          }
      });
  }

  // Function to make decision
  function make_decision() {
      var ff = new FormData();
      var ucode = $('.tf6').val();

      ff.append('refer', ucode);

      $.ajax({
          url: "youth_decide.php",
          type: "POST",
          data: ff,
          contentType: false,
          cache: false,
          processData: false,
          success: function(data) {
              handleResponse(data, "Unable to record transaction");
          },
          error: function(err) {
              Toast.fire({
                  icon: 'error',
                  title: "Error: " + err.responseText
              });
          }
      });
  }

  // Function to handle AJAX response
  function handleResponse(data, errorMessage) {
      if (data.trim() !== "0") {
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
              title: errorMessage
          });
      }
  }
});
