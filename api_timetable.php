<?php
// Include config file
require_once "layouts/config.php";

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetch':
        echo fetchTimetable();
        break;
    case 'fetchById':
        $id = $_GET['id'] ?? '';
        echo fetchTimetableById($id);
        break;
    case 'fetchByName':
        $name = $_GET['name'] ?? '';
        echo fetchTimetableByName($name);
        break;        
    case 'update':
        $id = $_POST['id'] ?? '';
        $path_image = $_POST['path_image'] ?? '';
        echo updateTimetable($id, $path_image);
        break;
    case 'delete':
        $id = $_GET['id'] ?? '';
        echo deleteTimetable($id);
        break;
    default:
        echo json_encode(['error' => 'Invalid action specified']);
}

function fetchTimetable() {
    global $link;

    $sql = "SELECT ct.id, r.name AS room_name, f.name AS floor_name, ct.path_image, ct.create_at 
            FROM classroom_timetable ct
            INNER JOIN room r ON ct.room_id = r.room_id
            INNER JOIN floor f ON r.floor_id = f.floor_id";

    $result = mysqli_query($link, $sql);
    if ($result) {
        $timetables = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return json_encode($timetables);
    } else {
        return json_encode(['error' => 'Failed to fetch timetables']);
    }
}
function fetchTimetableByName($name) {
    global $link;

    // Assuming room names are unique, otherwise you might need to handle multiple results
    $sql = "SELECT ct.id, r.name AS room_name, f.name AS floor_name, ct.path_image, ct.create_at 
            FROM classroom_timetable ct
            INNER JOIN room r ON ct.room_id = r.room_id
            INNER JOIN floor f ON r.floor_id = f.floor_id
            WHERE r.name = '$name'";

    $result = mysqli_query($link, $sql);
    if ($result) {
        $timetables = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return json_encode($timetables);
    } else {
        return json_encode(['error' => 'Failed to fetch timetables']);
    }
}
function fetchTimetableById($id) {
    global $link;

    $sql = "SELECT ct.id, r.name AS room_name, f.name AS floor_name, ct.path_image, ct.create_at 
            FROM classroom_timetable ct
            INNER JOIN room r ON ct.room_id = r.room_id
            INNER JOIN floor f ON r.floor_id = f.floor_id
            WHERE ct.id = $id";

    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $timetable = mysqli_fetch_assoc($result);
        return json_encode($timetable);
    } else {
        return json_encode(['error' => 'Timetable not found']);
    }
}

function updateTimetable($id, $path_image) {
    global $link;

    $sql = "UPDATE classroom_timetable SET path_image = '$path_image' WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Timetable path image updated successfully']);
    } else {
        return json_encode(['error' => 'Failed to update timetable path image']);
    }
}

function deleteTimetable($id) {
    global $link;

    $sql = "UPDATE classroom_timetable SET path_image = NULL WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Timetable path image deleted successfully']);
    } else {
        return json_encode(['error' => 'Failed to delete timetable path image']);
    }
}
?>
