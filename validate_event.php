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
            save_event();
        },
    });

    display_events();
    function display_events() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay,listWeek'
        },
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: 'display_event.php',
                dataType: 'json',
                success: function(data) {
                    var events = [];
                    $.each(data, function(index, event) {
                        events.push({
                            title: event.title,
                            start: event.event_date + 'T' + event.start_time, // Date and time for start
                            end: event.event_end_date + 'T' + event.end_time, // Date and time for end
                            color: event.color, // Assuming 'color' is a field in your event data
                        });
                    });
                    callback(events); 
                },
                error: function(err) {
                    Toast.fire({
                        icon: "error",
                        title: "Failed to load events: " + err.responseText,
                    });
                }
            });
        },
    });
}



   

    // Save event to the database
    function save_event() {
        var fd = new FormData();
        var event_name = $(".tfname").val();
        var event_start_date = $(".tfstart").val();
        var event_end_date = $(".tfend").val();
        var event_start_time = $(".tftimestart").val();
        var event_end_time = $(".tftimeend").val();

        fd.append("event", event_name);
        fd.append("start", event_start_date);
        fd.append("end", event_end_date);
        fd.append("start_time", event_start_time);
        fd.append("end_time", event_end_time);

        $.ajax({
            url: "save_event.php",
            type: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data != 0) {
                    Toast.fire({
                        icon: "success",
                        title: data,
                    });

                    // Refresh events on the calendar
                    $('#calendar').fullCalendar('refetchEvents');
                    setTimeout(function() {
            location.reload(); // Reload the page after a short delay
          }, 1000);
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "Unable to save event",
                    });
                }
            },
            error: function (err) {
                Toast.fire({
                    icon: "error",
                    title: "Error occurred: " + err.responseText,
                });
            },
        });
    }

    // Form validation rules and messages
    $("#event").validate({
        rules: {
            event_name: {
                required: true,
            },
            event_start_date: {
                required: true,
            },
            event_end_date: {
                required: true,
            },
            event_start_time: {
                required: true,
            },
            event_end_time: {
                required: true,
            },

        },
        messages: {
            event_name: {
                required: "Please enter the event name",
            },
            event_start_date: {
                required: "Please enter the event start date",
            },
            event_end_date: {
                required: "Please enter the event end date",
            },
            event_start_time: {
                required: "Please choose event start time",
            },
            event_end_time: {
                required: "Please choose event end time",
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