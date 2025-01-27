<?php
// Include the blog.php file to fetch posts and handle actions
include('blog.php'); // This will execute the code from blog.php, including fetching posts
//include('fetch_record.php'); // This will execute the code from fetch_record.php, including fetching a single post
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technology Blog Manager</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-header {
            font-weight: bold;
        }

        .card-body {
            font-size: 1.1rem;
        }

        .btn-sm {
            font-size: 0.875rem;
        }

        .container {
            max-width: 960px;
        }

        .no-posts-msg {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .btn-action {
            font-size: 1rem;
            margin-right: 10px;
        }

        .create-post-btn {
            margin-bottom: 1.5rem;
        }

        .modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  max-width: 600px;
  margin: 0 auto;
}

.modal-footer {
  text-align: right;
}

    </style>
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Blog Post Manager</h1>

        <!-- Button to toggle the create post form -->
        <button class="btn btn-primary btn-lg create-post-btn" data-bs-toggle="collapse" data-bs-target="#createPostForm" aria-expanded="false" aria-controls="createPostForm">
            Create a New Post
        </button>

        <!-- Form for creating a post -->
        <div id="createPostForm" class="collapse mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Create a New Post</div>
                <div class="card-body">
                    <form id="createPostForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Post Title</label>
                            <input type="text" id="title" class="form-control" placeholder="Enter post title" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Post Content</label>
                            <textarea id="content" class="form-control" rows="5" placeholder="Enter post content" required></textarea>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg w-100" onclick="createPost()">Add Post</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List of posts -->
        <h2 class="mb-4">All Posts</h2>
        <div id="posts" class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col mb-4">
                        <div class="card h-100" data-id="<?= $post['id'] ?>">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0"><?= htmlspecialchars($post['title']) ?></h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?= htmlspecialchars($post['content']) ?></p>
                                <button id="editBtn" class="btn btn-success " data-id="<?php echo  $post['id']; ?>" >Update</button>
                                <button class="btn btn-danger btn-action" onclick="deletePost(<?= $post['id'] ?>)">Delete</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-posts-msg text-center">No posts available. Create your first post!</p>
            <?php endif; ?>
        </div>

    </div>


<!-- Modal Structure for Editing -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <h4>Edit Record</h4>
    <form id="editForm">
      <input type="hidden" id="recordId" name="id">
      <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
      </div>
      <!-- Add other fields here -->
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
      <div>
        <button type="submit" class="btn">Save Changes</button>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button class="modal-close btn">Close</button>
  </div>
</div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>


<!-- Add this to include jQuery (if not already included) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
 $(document).ready(function() {
  // On edit button click
  $("#editBtn").click(function() {
    // Get the record ID from the button's data-id attribute
    const recordId = $(this).attr("data-id");
    //const recordId = $(this).data('id');
    alert('Edit record with ID: ' + recordId);  
    // Fetch record data via AJAX
    $.ajax({
      url: 'fetch_record.php', // Path to your PHP file
      type: 'GET',
      data: { id: recordId },
      success: function(response) {

        try {
    var record = JSON.parse(response);
} catch (e) {
    console.error("Error parsing JSON:", e);
    console.log("Response received:", response);
}

        // Parse the JSON response
       // var record = JSON.parse(response);
        alert('response: ' + record.content);  

        alert('response: ' + record.title);  
        // Pre-fill the modal form with the record data
        $('#recordId').val(record.id);
        $('#title').val(record.title);
        $('#content').val(record.content);
        // Pre-fill other fields as needed

        // Open the modal (if using Bootstrap or custom modal)
        $('#editModal').fadeIn();
      },
      error: function() {
        alert('Error fetching record data');
      }
    });
  });
});

  // Close modal on 'Close' button click
  $('.modal-close').click(function() {
    $('#editModal').fadeOut();
  });

  // Handle form submission (update record)
  $('#editForm').submit(function(event) {
    event.preventDefault(); // Prevent default form submission
    
    // Collect the form data
    const formData = $(this).serialize();
    
    // Send AJAX request to update the record
    $.ajax({
      url: 'update_record.php', // Path to your PHP file for updating
      type: 'POST',
      data: formData,
      success: function(response) {
        alert('Record updated successfully');
        $('#editModal').fadeOut();
        // Optionally, refresh the table or update the row with new data
      },
      error: function() {
        alert('Error updating record');
      }
    });
  });


</script>



