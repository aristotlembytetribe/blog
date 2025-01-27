<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post Manager</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Blog Post Manager</h1>
    <!-- Form for creating a post -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Create a New Post</div>
        <div class="card-body">
            <form id="createPostForm">
                <div class="mb-3">
                    <label for="title" class="form-label">Post Title</label>
                    <input type="text" id="title" class="form-control" placeholder="Enter post title">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Post Content</label>
                    <textarea id="content" class="form-control" rows="5" placeholder="Enter post content"></textarea>
                </div>
                <button type="button" class="btn btn-primary" onclick="createPost()">Add Post</button>
            </form>
        </div>
    </div>

    <!-- List of posts -->
    <h2>All Posts</h2>
    <div id="posts">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="card mb-3" data-id="<?= $post['id'] ?>">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?= htmlspecialchars($post['title']) ?></h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= htmlspecialchars($post['content']) ?></p>
                    <button class="btn btn-success btn-sm me-2" onclick="updatePost(<?= $post['id'] ?>)">Save</button>
                    <button class="btn btn-danger btn-sm" onclick="deletePost(<?= $post['id'] ?>)">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No posts available. Create your first post!</p>
    <?php endif; ?>
</div>

</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
