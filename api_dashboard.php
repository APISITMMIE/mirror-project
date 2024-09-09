<?php
include 'layouts/config.php'; // Ensure the correct path to your config file

// Set header to indicate JSON response
header('Content-Type: application/json');

// Initialize response array
$response = array();

// Check if action parameter is set
if(isset($_GET['action'])) {
    // Action to get total number of posts
    if($_GET['action'] == 'getTotalPosts') {
        $query = "SELECT COUNT(*) AS totalPosts FROM posts";
        $result = mysqli_query($link, $query);
        if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $response['totalPosts'] = $row['totalPosts'];
        } else {
            $response['error'] = "Failed to fetch total number of posts.";
        }
    }
    // Action to get total number of users
    elseif($_GET['action'] == 'getTotalUsers') {
        $query = "SELECT COUNT(*) AS totalUsers FROM users";
        $result = mysqli_query($link, $query);
        if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $response['totalUsers'] = $row['totalUsers'];
        } else {
            $response['error'] = "Failed to fetch total number of users.";
        }
    }
    // Action to get status of SCREEN_MIRRORMODE
    elseif($_GET['action'] == 'getScreenMirrorMode') {
        $query = "SELECT value_bool AS screenMirrorMode FROM config_app WHERE name = 'SCREEN_MIRRORMODE'";
        $result = mysqli_query($link, $query);
        if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $response['screenMirrorMode'] = (bool)$row['screenMirrorMode'];
        } else {
            $response['error'] = "Failed to fetch status of SCREEN_MIRRORMODE.";
        }
    }
    // Invalid action
    else {
        $response['error'] = "Invalid action.";
    }
} else {
    $response['error'] = "No action specified.";
}

// Output the JSON response
echo json_encode($response);
?>
