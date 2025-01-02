$(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    // Initialize FullCalendar
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
                    console.log("Event data fetched:", data); // Debugging
                    if (data.error) {
                        Toast.fire({
                            icon: "error",
                            title: "Error fetching events: " + data.error,
                        });
                        return;
                    }

                    var events = [];
                    $.each(data, function(index, event) {
                        events.push({
                            title: event.title,
                            start: event.event_date + 'T' + event.start_time,
                            end: event.event_end_date + 'T' + event.end_time,
                            color: event.color
                        });
                    });
                    callback(events); // Render events on the calendar
                },
                error: function(err) {
                    Toast.fire({
                        icon: "error",
                        title: "Failed to load events: " + err.responseText,
                    });
                }
            });
        }
    });

    // Form validation and submission
    $("#event").validate({
        rules: {
            event_name: { required: true },
            event_start_date: { required: true },
            event_end_date: { required: true },
            event_start_time: { required: true },
            event_end_time: { required: true }
        },
        messages: {
            event_name: { required: "Please enter the event name" },
            event_start_date: { required: "Please enter the event start date" },
            event_end_date: { required: "Please enter the event end date" },
            event_start_time: { required: "Please choose event start time" },
            event_end_time: { required: "Please choose event end time" }
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function () {
            save_event();
        }
    });

    // Save event to the database
    function save_event() {
        var fd = new FormData();
        fd.append("event", $(".tfname").val());
        fd.append("start", $(".tfstart").val());
        fd.append("end", $(".tfend").val());
        fd.append("start_time", $(".tftimestart").val());
        fd.append("end_time", $(".tftimeend").val());

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

                    $('#calendar').fullCalendar('refetchEvents'); // Refresh events
                    setTimeout(function() {
                        location.reload(); // Reload after saving
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
            }
        });
    }
});
