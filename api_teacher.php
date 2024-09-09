<?php
// Include config file
require_once "layouts/config.php";

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetch':
        echo fetchTeachers($link);
        break;
    case 'insert':
        echo insertTeacher($link, $_POST);
        break;
    case 'update':
        echo updateTeacher($link, $_POST);
        break;
    case 'fetchById':
        echo fetchTeacherById($link, $_GET['id'] ?? null);
        break;
    case 'fetchByRoomId':
        echo fetchTeachersByRoomId($link, $_GET['room_id'] ?? null);
        break;            
    case 'delete':
        echo deleteTeacher($link, $_POST['id']);
        break;
    default:
        echo json_encode(['error' => 'No action specified']);
}

function fetchTeachers($link) {
    $sql = "SELECT id, room_id, name, content, phone, create_at FROM teac_address";
    $result = mysqli_query($link, $sql);
    $teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode($teachers);
}

function fetchTeachersByRoomId($link, $name) {
    if (empty($name)) {
        return json_encode(['error' => 'name is required.']);
    }
    // Modify the SQL query to join the room table to get the room name
    $sql = "SELECT ta.id, ta.room_id, r.name AS room_name, ta.name, ta.content, ta.phone, ta.create_at 
    FROM teac_address AS ta
    JOIN room AS r ON ta.room_id = r.room_id
    WHERE r.name = '$name'";
    $result = mysqli_query($link, $sql);
    $teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode($teachers);
}

function fetchTeacherById($link, $id) {
    if (empty($id)) {
        return json_encode(['error' => 'Teacher ID is required.']);
    }
    $sql = "SELECT id, room_id, name, content, phone, create_at FROM teac_address WHERE id = $id";
    $result = mysqli_query($link, $sql);
    $teacher = mysqli_fetch_assoc($result);
    if ($teacher) {
        return json_encode($teacher);
    } else {
        return json_encode(['error' => 'Teacher not found.']);
    }
}

function insertTeacher($link, $data) {
    $room_id = $data['room_id'] ?? '';
    $name = $data['name'] ?? '';
    $address = $data['address'] ?? '';
    $phone = $data['phone'] ?? '';
   

    // Basic validation
    if (empty($room_id) || empty($name) || empty($address) || empty($phone)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }

    // Insert new teacher
    $sql_insert = "INSERT INTO teac_address (room_id, name, address, phone) VALUES ('$room_id', '$name', '$address', '$phone')";
    if (mysqli_query($link, $sql_insert)) {
        return json_encode(['success' => 'Teacher created successfully.']);
    } else {
        return json_encode(['error' => 'Failed to create teacher.']);
    }
}

function updateTeacher($link, $data) {
    $id = $data['id'] ?? '';
    $name = $data['name'] ?? '';
    $content = $data['content'] ?? '';
    $phone = $data['phone'] ?? '';
    $room_id = $data['room_id'] ?? '';

    // Basic validation
    if (empty($id) || empty($name) || empty($content) || empty($phone)|| empty($room_id)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }

    // Update teacher
    $sql = "UPDATE teac_address SET room_id = $room_id,  name = '$name', content = '$content', phone = '$phone' WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Teacher updated successfully.']);
    } else {
        return json_encode(['error' =>  $sql ]);
    }
}

function deleteTeacher($link, $id) {
    if (empty($id)) {
        return json_encode(['error' => 'Teacher ID is required.']);
    }

    // Delete teacher
    $sql = "DELETE FROM teac_address WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Teacher deleted successfully.']);
    } else {
        return json_encode(['error' => 'Failed to delete teacher.']);
    }
}
?>
