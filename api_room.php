<?php
// Include config file
require_once "layouts/config.php";

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetch':
        echo fetchRooms($link);
        break;
    case 'insert':
        echo insertRoom($link, $_POST);
        break;
    case 'update':
        echo updateRoom($link, $_POST);
        break;
    case 'delete':
        echo deleteRoom($link, $_POST['room_id']);
        break;
    case 'getById':
        $room_id = $_GET['floor_id'] ?? '';
        if (!empty($room_id)) {
            echo getRoomByFloorId($link, $room_id);
        } else {
            echo json_encode(['error' => 'Room ID is required.']);
        }
        break;
    case 'getByRoomId':
        $room_id = $_GET['room_id'] ?? '';
        if (!empty($room_id)) {
            echo getRoomById($link, $room_id);
        } else {
            echo json_encode(['error' => 'Room ID is required.']);
        }
        break;
     case 'updateImage':
        $room_id = $_POST['room_id'] ?? '';
        $path_image = $_POST['path_image'] ?? '';

        if (!empty($room_id) && !empty($path_image)) {
            echo updateRoomImage($link, $room_id, $path_image);
        } else {
            echo json_encode(['error' => 'Room ID and image path are required.']);
        }
        break;           
    default:
        echo json_encode(['error' => 'No action specified']);
}

function fetchRooms($link) {
    $sql = "SELECT * FROM room";
    $result = mysqli_query($link, $sql);
    $rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode($rooms);
}

function insertRoom($link, $data) {
    $floor_id = $data['floor_id'] ?? '';
    $name = $data['name'] ?? '';
    // Additional fields can be added here

    // Basic validation
    if (empty($floor_id) || empty($name)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }

    // Insert new room
    $sql_insert = "INSERT INTO room (floor_id, name) VALUES ('$floor_id', '$name')";
    if (mysqli_query($link, $sql_insert)) {
        return json_encode(['success' => 'Room created successfully.']);
    } else {
        return json_encode(['error' => 'Failed to create room.']);
    }
}

function updateRoom($link, $data) {
    $room_id = $data['room_id'] ?? '';
    $is_teac = $data['is_teac'] ?? '';
    $name = $data['name'] ?? '';
    $remask = $data['remask'] ?? '';
    // Additional fields can be added here

    // Basic validation
    if (empty($room_id) || empty($is_teac) || empty($name)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }

    // Update room
    $sql = "UPDATE room SET is_teac = '$is_teac', name = '$name', remask = '$remask' WHERE room_id = $room_id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Room updated successfully.']);
    } else {
        return json_encode(['error' => 'Failed to update room.']);
    }
}

function updateRoomImage($link, $room_id, $path_image) {
    $sql = "UPDATE room SET path_image = '$path_image' WHERE room_id = $room_id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Room image updated successfully.']);
    } else {
        return json_encode(['error' => 'Failed to update room image.']);
    }
}
function deleteRoom($link, $room_id) {
    if (empty($room_id)) {
        return json_encode(['error' => 'Room ID is required.']);
    }

    // Delete room
    $sql = "DELETE FROM room WHERE room_id = $room_id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Room deleted successfully.']);
    } else {
        return json_encode(['error' => 'Failed to delete room.']);
    }
}

function getRoomByFloorId($link, $floor_id) {
    $sql = "SELECT * FROM room WHERE floor_id = $floor_id";
    $result = mysqli_query($link, $sql);
    $rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if ($rooms) {
        return json_encode($rooms);
    } else {
        return json_encode(['error' => 'No rooms found for the provided floor ID.']);
    }
}
function getRoomById($link, $room_id) {
    $sql = "SELECT * FROM room WHERE room_id = $room_id";
    $result = mysqli_query($link, $sql);
    $room = mysqli_fetch_assoc($result);
    if ($room) {
        return json_encode($room);
    } else {
        return json_encode(['error' => 'No room found for the provided room ID.']);
    }
}
?>
