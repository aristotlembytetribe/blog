<?php
// Logging function
function logMessage($message) {
    $logFile = 'blog.log'; // Log file
    $timestamp = date('Y-m-d H:i:s');
    $formattedMessage = "[$timestamp] $message\n";
    file_put_contents($logFile, $formattedMessage, FILE_APPEND);
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
   // logMessage("Database connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}
//logMessage("Database connection successful.");

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    //logMessage("Received POST request with action: $action");

    if ($action === 'create') {
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);
        $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
        if ($conn->query($sql)) {
           // logMessage("Post created successfully: Title = $title");
        } else {
           // logMessage("Error creating post: " . $conn->error);
        }
    } elseif ($action === 'update') {
        $id = intval($_POST['id']);
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);
        $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
        if ($conn->query($sql)) {
           // logMessage("Post updated successfully: ID = $id, Title = $title");
        } else {
           // logMessage("Error updating post: " . $conn->error);
        }
    } elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM posts WHERE id=$id";
        if ($conn->query($sql)) {
           // logMessage("Post deleted successfully: ID = $id");
        } else {
           // logMessage("Error deleting post: " . $conn->error);
        }
    }
    exit;
}

// Fetch posts
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
//logMessage("Executing query: $sql");
$result = $conn->query($sql);


// Log query result or error
if ($result === false) {
   // logMessage("Error fetching posts: " . $conn->error);
    $posts = [];
} else {
    // Check if rows were fetched
    $posts = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
    //logMessage("Number of posts fetched: " . count($posts));

    // Log the actual data fetched
    if (!empty($posts)) {
       // logMessage("Fetched posts: " . print_r($posts, true));
    } else {
        //logMessage("No posts found.");
    }
}

$conn->close();
logMessage("Database connection closed.");
?>
