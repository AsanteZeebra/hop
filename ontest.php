<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Input Form</title>
    <?php include_once('head.php') ?>

</head>
<body>
    <div class="container mt-5">
        <h1>Dynamic Input Form</h1>
        <form id="dynamicForm">
            <div id="inputContainer">
                <!-- Initial Input -->
                <div class="row mb-3 input-row">
                    <div class="col-md-3">
                        <select name="month[]" class="form-control" required>
                            <option value="" disabled selected>Select Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="year[]" class="form-control" required>
                            <option value="" disabled selected>Select Year</option>
                           <script> ${(() => {
                                const currentYear = new Date().getFullYear();
                                let options = '';
                                for (let i = currentYear - 10; i <= currentYear + 10; i++) {
                                    options += `<option value="${i}">${i}</option>`;
                                }
                                return options;
                            })()}</script>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="amount[]" class="form-control" placeholder="Amount" required>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger remove-input">Remove</button>
                    </div>
                </div>

            </div>
            
            <button type="button" id="addInput" class="btn btn-primary mb-3">Add More</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
        <div id="response" class="mt-3"></div>
    </div>
<?php include_once('script.php') ?>
   <script>
        $(document).ready(function () {
            // Add new input fields
            $("#addInput").click(function () {
                $("#inputContainer").append(`
                    <div class="row mb-3 input-row">
                        <div class="col-md-3">
                            <select name="month[]" class="form-control" required>
                                <option value="" disabled selected>Select Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="year[]" class="form-control" required>
                                <option value="" disabled selected>Select Year</option>
                                ${(() => {
                                    const currentYear = new Date().getFullYear();
                                    let options = '';
                                    for (let i = currentYear - 10; i <= currentYear + 10; i++) {
                                        options += `<option value="${i}">${i}</option>`;
                                    }
                                    return options;
                                })()}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="amount[]" class="form-control" placeholder="Amount" required>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-danger remove-input">Remove</button>
                        </div>
                    </div>
                `);
            });

            // Remove input fields
            $("#inputContainer").on("click", ".remove-input", function () {
                $(this).closest(".input-row").remove();
            });

            // Handle form submission
            $("#dynamicForm").submit(function (e) {
                e.preventDefault();

                // Serialize form data
                const formData = $(this).serialize();

                // AJAX request to save data
                $.ajax({
                    url: "save_data.php",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        $("#response").html(`<div class="alert alert-success">${response}</div>`);
                        $("#dynamicForm")[0].reset();
                        $("#inputContainer").html(`
                            <div class="row mb-3 input-row">
                                <div class="col-md-3">
                                    <select name="month[]" class="form-control" required>
                                        <option value="" disabled selected>Select Month</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="year[]" class="form-control" required>
                                        <option value="" disabled selected>Select Year</option>
                                        ${(() => {
                                            const currentYear = new Date().getFullYear();
                                            let options = '';
                                            for (let i = currentYear - 10; i <= currentYear + 10; i++) {
                                                options += `<option value="${i}">${i}</option>`;
                                            }
                                            return options;
                                        })()}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="amount[]" class="form-control" placeholder="Amount" required>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-danger remove-input">Remove</button>
                                </div>
                            </div>
                        `);
                    },
                    error: function () {
                        $("#response").html(`<div class="alert alert-danger">An error occurred while saving data.</div>`);
                    }
                });
            });
        });
    </script>
</body>
</html>
