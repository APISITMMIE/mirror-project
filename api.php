<?php
// Include config file
require_once "layouts/config.php";

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetch':
        echo fetchUsers($link);
        break;
    case 'insert':
        echo insertUser($link, $_POST);
        break;
    case 'update':
        echo updateUser($link, $_POST);
        break;
    case 'delete':
        echo deleteUser($link, $_POST['id']);
        break;
    case 'getUser': // Add a new action to fetch a specific user's data
        echo getUser($link, $_GET['id'] ?? '');
        break;
    default:
        echo json_encode(['error' => 'No action specified']);
}

function fetchUsers($link) {
    $sql = "SELECT id, useremail, username, token, created_at FROM users";
    $result = mysqli_query($link, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode($users);
}

function insertUser($link, $data) {
    $useremail = $data['useremail'] ?? '';
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';
    
    // Basic validation
    if (empty($useremail) || empty($username) || empty($password)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }
    
    // Check if user email already exists
    $sql_email = "SELECT id FROM users WHERE useremail = '$useremail'";
    $result_email = mysqli_query($link, $sql_email);
    if (mysqli_num_rows($result_email) > 0) {
        return json_encode(['error' => 'User email already exists.']);
    }

    // Check if username already exists
    $sql_username = "SELECT id FROM users WHERE username = '$username'";
    $result_username = mysqli_query($link, $sql_username);
    if (mysqli_num_rows($result_username) > 0) {
        return json_encode(['error' => 'Username already exists.']);
    }

    // Insert new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql_insert = "INSERT INTO users (useremail, username, password) VALUES ('$useremail', '$username', '$hashed_password')";
    if (mysqli_query($link, $sql_insert)) {
        return json_encode(['success' => 'User created successfully.']);
    } else {
        return json_encode(['error' => 'Failed to create user.']);
    }
}

function updateUser($link, $data) {
    $id = $data['id'] ?? '';
    $useremail = $data['useremail'] ?? '';
    $username = $data['username'] ?? '';
    // Basic validation
    if (empty($id) || empty($useremail) || empty($username)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }
    // Update user
    $sql = "UPDATE users SET useremail = '$useremail', username = '$username' WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'User updated successfully.']);
    } else {
        return json_encode(['error' => 'Failed to update user.']);
    }
}

function deleteUser($link, $id) {
    if (empty($id)) {
        return json_encode(['error' => 'User ID is required.']);
    }

    // Check if the user is a super admin before deletion
    $sqlCheckSuperAdmin = "SELECT superadmin FROM users WHERE id = $id";
    $result = mysqli_query($link, $sqlCheckSuperAdmin);
    $user = mysqli_fetch_assoc($result);
    
    if ($user['superadmin'] == 1) {
        return json_encode(['error' => 'Cannot delete super admin.']);
    }

    // Delete user
    $sql = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'User deleted successfully.']);
    } else {
        return json_encode(['error' => 'Failed to delete user.']);
    }
}


function getUser($link, $id) {
    if (empty($id)) {
        return json_encode(['error' => 'User ID is required.']);
    }
    // Fetch user data
    $sql = "SELECT id, useremail, username, token, created_at FROM users WHERE id = $id";
    $result = mysqli_query($link, $sql);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        return json_encode($user);
    } else {
        return json_encode(['error' => 'User not found.']);
    }
}
?>
