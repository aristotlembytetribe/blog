<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'create') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
        $conn->query($sql);
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
        $conn->query($sql);
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        $sql = "DELETE FROM posts WHERE id=$id";
        $conn->query($sql);
    }

    exit;
}

// Fetch posts
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
