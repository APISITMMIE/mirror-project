<?php

// Ensure the key matches what's used in formData.append('image', file);
if (isset($_FILES['image'])) { // Change 'upload' to 'image'
    $file = $_FILES['image'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tempName = $file['tmp_name'];
        $uploadDir = 'uploads/';
        $fileName = preg_replace("/[^a-zA-Z0-9_.]/", "", $file['name']);
        
        // Generate a unique filename to avoid overwriting existing files
        $uniqueFileName = uniqid() . '_' . time() . '_' . $fileName;
        
        if (move_uploaded_file($tempName, $uploadDir . $uniqueFileName)) {
            echo json_encode(['uploaded' => 1, 'url' => $uploadDir . $uniqueFileName]);
            exit;
        } else {
            // Log the error if move_uploaded_file fails
            error_log('Error moving uploaded file');
        }
    } else {
        // Log the error if file upload encounters an error
        error_log('File upload error: ' . $file['error']);
    }
} else {
    // Log the error if $_FILES['image'] is not set
    error_log('$_FILES["image"] is not set');
}

echo json_encode(['uploaded' => 0, 'error' => 'Error uploading file.']);
