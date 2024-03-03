<?php
// read.php

// Allow requests from all origins
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

try {
    // Prepare and execute the SQL query to select all todos
    $stmt = $pdo->prepare("SELECT * FROM todos");
    $stmt->execute();
    
    // Fetch all todos as associative array
    $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the todos as JSON response
    echo json_encode($todos);
} catch (PDOException $e) {
    // Handle database errors
    http_response_code(500);
    echo json_encode(array("error" => "Database error: " . $e->getMessage()));
}
?>
