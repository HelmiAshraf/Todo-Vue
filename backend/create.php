<?php
// create.php

// create.php

// Allow requests from all origins
header("Access-Control-Allow-Origin: *");

// Allow specific headers in preflight response
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';

// Retrieve data sent from the frontend
$data = json_decode(file_get_contents("php://input"));

// Prepare and execute the SQL query to insert a new todo
$stmt = $pdo->prepare("INSERT INTO todos (title, description) VALUES (?, ?)");
$stmt->execute([$data->title, $data->description]);

// Return success response
echo json_encode(['message' => 'Todo created successfully']);
