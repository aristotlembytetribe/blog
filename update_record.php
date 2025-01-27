<?php

// Include the blog.php file to fetch posts and handle actions
include('blog.php'); // This will execute the code from blog.php, including fetching posts
//include('fetch_record.php'); // This will execute the code from fetch_record.php, including fetching a single post

// Database connection (use your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data from the POST request
$id = $_POST['id'];
$title = $_POST['title']; // Add other fields here
$content = $_POST['content'];

logMessage("id: $id");
logMessage("title: $title");
logMessage("content: $content");
// Prepare the update query
$query = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $title, $content, $id); // "si" for string and integer
$stmt->execute();

$conn->close();

echo 'success'; // You can send a response to indicate success
?>
