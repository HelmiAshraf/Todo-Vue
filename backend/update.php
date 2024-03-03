<?php
// update.php

// Allow requests from all origins
header("Access-Control-Allow-Origin: *");

// Allow specific headers in preflight response
header("Access-Control-Allow-Headers: Content-Type");

// Allow specific methods in preflight response
header("Access-Control-Allow-Methods: PUT");

// Check if the request method is OPTIONS (preflight request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond with HTTP status code 200 OK to indicate successful preflight request
    http_response_code(200);
    exit;
}

// Check if the ID parameter is present
if (isset($_GET['id'])) {
    // Get the ID from the query parameter
    $id = $_GET['id'];

    // Get the request payload (JSON data)
    $data = json_decode(file_get_contents("php://input"));

    // Check if the request payload contains title and description
    if (isset($data->title) && isset($data->description)) {
        // Connect to your MySQL database
        include 'db.php';

        // Prepare and execute the SQL query to update the todo
        $stmt = $pdo->prepare("UPDATE todos SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$data->title, $data->description, $id]);

        // Return success response
        echo json_encode(['message' => 'Todo updated successfully']);
    } else {
        // Return error response if title or description is missing in the request payload
        http_response_code(400);
        echo json_encode(['error' => 'Title and description are required']);
    }
} else {
    // Return error response if ID parameter is missing
    http_response_code(400);
    echo json_encode(['error' => 'ID parameter is missing']);
}
