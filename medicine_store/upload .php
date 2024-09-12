<?php
// Specify the upload directory
$uploadDir = 'uploads/';

// Ensure the directory exists and is writable
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Check if a file has been uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['product_image']['tmp_name'];
        $name = basename($_FILES['product_image']['name']);
        $uploadFile = $uploadDir . $name;

        // Validate file size and type (optional)
        if ($_FILES['product_image']['size'] > 5000000) { // 5MB max size
            die('File is too large.');
        }
        if (!in_array(mime_content_type($tmpName), ['image/jpeg', 'image/png', 'image/gif'])) {
            die('Invalid file type.');
        }

        // Move the file to the upload directory
        if (move_uploaded_file($tmpName, $uploadFile)) {
            echo 'File successfully uploaded.';
            // You can now save the file path to the database
        } else {
            echo 'File upload failed.';
        }
    } else {
        echo 'No file uploaded or upload error.';
    }
}
?>
