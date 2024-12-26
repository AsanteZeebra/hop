<?php 
include_once('load_session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webcam Capture</title>
</head>
<body>
    <h1>Webcam Capture</h1>
    <video id="webcam" autoplay></video>
    <canvas id="canvas" style="display:none;"></canvas>
    <button id="capture">Capture</button>
    <img id="photo" alt="Captured Image" />

    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const photo = document.getElementById('photo');
        const captureButton = document.getElementById('capture');
        const context = canvas.getContext('2d');

        // Access the webcam
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing webcam: ", err);
            });

        // Capture image from webcam
        captureButton.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            const dataURL = canvas.toDataURL('image/png');
            photo.src = dataURL;

            // Send the image to the server
            fetch('upload_capture.php', {
                method: 'POST',
                body: JSON.stringify({ image: dataURL }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.text())
            .then(result => {
                console.log('Server response:', result);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
