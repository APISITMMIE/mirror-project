<?php
include 'layouts/config.php'; // Make sure this path is correct

// Initialize default response
$response = [
    'success' => false,
    'screenOn' => false,
    'featureOn' => false
];

// Query the database for the current settings
$query = "SELECT `name`, `value_bool` FROM `config_app` WHERE `name` IN ('SCREEN_ONOFF', 'SCREEN_MIRRORMODE')";
$result = mysqli_query($link, $query);

if ($result) {
    $response['success'] = true; // Indicate successful retrieval of data
    
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['name'] == 'SCREEN_ONOFF') {
            $response['screenOn'] = (bool)$row['value_bool'];
        } elseif ($row['name'] == 'SCREEN_MIRRORMODE') {
            $response['featureOn'] = (bool)$row['value_bool'];
        }
    }
}

// Set header to indicate JSON response
header('Content-Type: application/json');
// Return the JSON-encoded response
echo json_encode($response);
?>
