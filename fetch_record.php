<?php

// Include the blog.php file to fetch posts and handle actions
include('blog.php'); // This will execute the code from blog.php, including fetching posts
//include('fetch_record.php'); // This will execute the code from fetch_record.php, including fetching a single post

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the record ID from the request (e.g., via GET)
$recordId = $_GET['id'];

logMessage("record Id: $recordId");
// Fetch the record from the database
$query = "SELECT id, title, content FROM posts WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $recordId);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

$conn->close();

$jasonifiedrecord = json_encode($record);

logMessage("json: $jasonifiedrecord");

// Return the record as JSON
echo $jasonifiedrecord
?>
