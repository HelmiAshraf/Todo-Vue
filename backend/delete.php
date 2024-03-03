<?php
// delete.php

// Allow requests from all origins
header("Access-Control-Allow-Origin: *");

// Allow specific headers in preflight response
header("Access-Control-Allow-Headers: Content-Type");

// Allow DELETE method
header("Access-Control-Allow-Methods: DELETE");

// Check if the ID parameter is present
if (isset($_GET['id'])) {
    // Connect to your MySQL database
    include 'db.php';
    
    // Prepare and execute the SQL query to delete the todo
    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    
    // Return success response
    echo json_encode(['message' => 'Todo deleted successfully']);
} else {
    // Return error response if ID parameter is missing
    http_response_code(400);
    echo json_encode(['error' => 'ID parameter is missing']);
}
