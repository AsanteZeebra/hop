<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate PDF</title>
   

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <button id="generate-pdf">Generate PDF</button>

    
    <script>
        $('#generate-pdf').on('click', function() {
            // Fetch data via AJAX
            $.ajax({
                url: 'data.php',  // Fetch data from backend
                method: 'GET',
                success: function(response) {
                    // Send data to generate PDF
                    $.ajax({
                        url: 'generate_pdf.php',  // Send data for PDF creation
                        method: 'POST',
                        data: { data: JSON.stringify(response) },  // Stringify response
                        success: function() {
                            alert('PDF generated successfully');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
