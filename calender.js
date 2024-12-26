$(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    $('.btdel').on('click', function() {
        var $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        
        console.log(data);

        $('.ddt').val(data[0]); // Correctly setting the value
    });

    $('.bbt').on('click', function() {
        delete_event();
    });

    function delete_event() {
        var ff = new FormData();
        var ucode = $('.ddt').val();
        
        ff.append('refer', ucode);

        $.ajax({
            url: "delete_event.php",
            type: "POST",
            data: ff,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if(data != 0) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Successfully deleted'
                    });

                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Unable to delete transaction'
                    });
                }
            },
            error: function(err) {
                Toast.fire({
                    icon: 'error',
                    title: 'Error occurred: ' + err.responseText
                });
            }
        });
    }
});
