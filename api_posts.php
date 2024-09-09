<?php
// Include config file
require_once "layouts/config.php";

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetch':
        echo fetchPosts($link);
        break;
    case 'insert':
        echo insertPost($link, $_POST);
        break;
    case 'update':
        echo updatePost($link, $_POST);
        break;
    case 'delete':
        echo deletePost($link, $_POST['id']);
        break;
    case 'getPost': // Add a new action to fetch a specific post's data
        echo getPost($link, $_GET['id'] ?? '');
        break;
    default:
        echo json_encode(['error' => 'No action specified']);
}

function fetchPosts($link) {
    $sql = "SELECT id, header, content,create_by, create_at FROM posts";
    $result = mysqli_query($link, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode($posts);
}

function insertPost($link, $data) {
    $header = $data['header'] ?? '';
    $content = $data['content'] ?? '';
    $create_by = $data['create_by'] ?? '';

    // Basic validation
    if (empty($header) || empty($content) || empty($create_by)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }

    // Insert new post
    $sql_insert = "INSERT INTO posts (header, content, create_by) VALUES ('$header', '$content', '$create_by')";
    if (mysqli_query($link, $sql_insert)) {
        return json_encode(['success' => 'Post created successfully.']);
    } else {
        return json_encode(['error' => 'Failed to create post.']);
    }
}

function updatePost($link, $data) {
    $id = $data['id'] ?? '';
    $header = $data['header'] ?? '';
    $content = $data['content'] ?? '';

    // Basic validation
    if (empty($id) || empty($header) || empty($content)) {
        return json_encode(['error' => 'Required fields are missing.']);
    }

    // Update post
    $sql = "UPDATE posts SET header = '$header', content = '$content' WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Post updated successfully.']);
    } else {
        return json_encode(['error' => 'Failed to update post.']);
    }
}

function deletePost($link, $id) {
    if (empty($id)) {
        return json_encode(['error' => 'Post ID is required.']);
    }

    // Delete post
    $sql = "DELETE FROM posts WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        return json_encode(['success' => 'Post deleted successfully.']);
    } else {
        return json_encode(['error' => 'Failed to delete post.']);
    }
}

function getPost($link, $id) {
    if (empty($id)) {
        return json_encode(['error' => 'Post ID is required.']);
    }
    // Fetch post data
    $sql = "SELECT id, header, content, create_by, create_at FROM posts WHERE id = $id";
    $result = mysqli_query($link, $sql);
    $post = mysqli_fetch_assoc($result);
    if ($post) {
        return json_encode($post);
    } else {
        return json_encode(['error' => 'Post not found.']);
    }
}
?>
