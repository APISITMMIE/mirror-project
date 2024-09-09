<?php
include 'layouts/config.php'; // Adjust the path as necessary

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['success' => false];
    
    if ($_POST['action'] == 'toggleScreen') {
        // Toggle SCREEN_ONOFF value in the database
        // This is a simplified example. Use prepared statements to prevent SQL injection.
        $currentValue = (int)mysqli_query($link, "SELECT value_bool FROM config_app WHERE name='SCREEN_ONOFF'")->fetch_row()[0];
        $newValue = $currentValue ? 0 : 1;
        $update = mysqli_query($link, "UPDATE config_app SET value_bool = '$newValue' WHERE name='SCREEN_ONOFF'");
        
        if ($update) {
            $response = ['success' => true, 'screenOn' => $newValue];
        }
    } elseif ($_POST['action'] == 'toggleFeature') {
        // Toggle SCREEN_MIRRORMODE value in the database
        $currentValue = (int)mysqli_query($link, "SELECT value_bool FROM config_app WHERE name='SCREEN_MIRRORMODE'")->fetch_row()[0];
        $newValue = $currentValue ? 0 : 1;
        $update = mysqli_query($link, "UPDATE config_app SET value_bool = '$newValue' WHERE name='SCREEN_MIRRORMODE'");
        
        if ($update) {
            $response = ['success' => true, 'featureOn' => $newValue];
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
