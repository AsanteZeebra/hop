<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['image'])) {
        $dataURL = $data['image'];
        // Remove the data URL scheme part
        $dataURL = str_replace('data:image/png;base64,', '', $dataURL);
        $dataURL = str_replace(' ', '+', $dataURL);

        // Decode base64
        $image = base64_decode($dataURL);

        // Save the image to the server
        $filePath = 'uploads/photo_' . time() . '.png';
        file_put_contents($filePath, $image);

        echo 'Image uploaded successfully!';
    } else {
        echo 'No image data received.';
    }
} else {
    echo 'Invalid request method.';
}
