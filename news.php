<?php
include 'config.php';

// Utility function to send JSON responses
function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    sendJsonResponse(['message' => 'Database connection failed: ' . $mysqli->connect_error], 500);
}

// Handles POST requests
function handlePostRequest($api, $mysqli) {
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($api) {
        case 'webhook':
            // Assuming the JSON structure is validated
            $body = $input['body'];
            $from = $body['from'];
            $user = $from['user'];
            $channelIdentity = $body['channelIdentity'];
            $date = new DateTime($body['createdDateTime'], new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('Asia/Bangkok'));
            $adjustedCreatedDateTime = $date->format('Y-m-d H:i:s');

            $stmt = $mysqli->prepare("INSERT INTO webhook_messages (id, etag, messageType, subject, importance, userId, userName, userTenantId, bodyContent, channelTeamId, channelChannelId, createdDateTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssss",
                $body['id'],
                $body['etag'],
                $body['messageType'],
                $body['subject'],
                $body['importance'],
                $user['id'],
                $user['displayName'],
                $user['tenantId'],
                $body['body']['content'],
                $channelIdentity['teamId'],
                $channelIdentity['channelId'],
                $adjustedCreatedDateTime
            );

            if (!$stmt->execute()) {
                sendJsonResponse(['message' => 'Failed to store webhook data'], 500);
            }
            sendJsonResponse(['message' => 'Webhook data received and stored']);
            break;

        case 'webhook-team':
            $teams = $input['body']['value'];

            foreach ($teams as $teamData) {
                $stmt = $mysqli->prepare("INSERT INTO team_webhook_messages (id, displayName, description) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE displayName = VALUES(displayName), description = VALUES(description)");
                $stmt->bind_param("sss",
                    $teamData['id'],
                    $teamData['displayName'],
                    $teamData['description']
                );

                if (!$stmt->execute()) {
                    sendJsonResponse(['message' => 'Failed to store team webhook data'], 500);
                }
            }
            sendJsonResponse(['message' => 'Team webhook data received and processed']);
            break;

        default:
            sendJsonResponse(['message' => 'Invalid API request for POST'], 400);
            break;
    }
}

// Handles GET requests
function handleGetRequest($api, $mysqli) {
    switch ($api) {
        case 'news':
            $result = $mysqli->query("SELECT wm.*, twm.displayName AS displayName, twm.description AS description FROM webhook_messages wm LEFT JOIN team_webhook_messages twm ON wm.channelChannelId = twm.id");
            if (!$result) {
                sendJsonResponse(['message' => 'Failed to fetch news data'], 500);
            }
            $data = $result->fetch_all(MYSQLI_ASSOC);
            sendJsonResponse($data);
            break;

        default:
            sendJsonResponse(['message' => 'Invalid API request for GET'], 400);
            break;
    }
}

$api = $_GET['api'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest($api, $mysqli);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    handleGetRequest($api, $mysqli);
} else {
    sendJsonResponse(['message' => 'Unsupported request method'], 405);
}

$mysqli->close();
