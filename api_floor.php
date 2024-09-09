<?php
// Include config file
require_once "layouts/config.php";

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetch':
        echo fetchFloors($link);
        break;
    case 'update':
        echo updateFloor($link, $_POST);
        break;
    default:
        echo json_encode(['error' => 'No action specified']);
}

function fetchFloors($link) {
    $sql = "SELECT floor_id, name, path_image, sequent, create_at FROM floor";
    $result = mysqli_query($link, $sql);
    $floors = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode(['table' => 'floor', 'rows' => $floors]);
}

function updateFloor($link, $data) {
    $floor_id = $data['floor_id'] ?? '';
    $name = $data['name'] ?? '';
    $path_image = $data['path_image'] ?? '';
    $sequent = $data['sequent'] ?? '';

    // Basic validation
    if (empty($floor_id) || empty($name) || empty($path_image) || empty($sequent)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }

    // Update floor
    $sql = "UPDATE floor SET name = '$name', path_image = '$path_image', sequent = '$sequent' WHERE floor_id = $floor_id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Floor updated successfully.']);
    } else {
        return json_encode(['error' => 'Failed to update floor.']);
    }
}
?>
