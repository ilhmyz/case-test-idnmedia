<?php
include '../includes/db_connection.php';

session_start();

// Redirect to login if user not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Include create_post, update_post, delete_post
include 'create_post.php';
include 'update_post.php';
include 'delete_post.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post.php">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Manage Your Posts</h2>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPostModal">
            Create New Post
        </button>

        <!-- Display list of user's posts -->
        <?php
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT id, title, content, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) :
            while ($row = $result->fetch_assoc()) :
        ?>
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text"><?php echo $row['content']; ?></p>
                        <p class="text-muted">Posted on <?php echo $row['created_at']; ?></p>

                        <!-- Edit and Delete buttons -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                            Delete
                        </button>

                        <!-- Edit Post Modal -->
                        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                <!-- Form to edit post -->
                                <form action="post.php" method="POST">
                                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="new_title" class="form-label">New Title</label>
                                        <input type="text" class="form-control" id="new_title" name="new_title" value="<?php echo $row['title']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_content" class="form-label">New Content</label>
                                        <textarea class="form-control" id="new_content" name="new_content" rows="5" required><?php echo $row['content']; ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="update_post">Update Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                        <!-- Delete Post Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this post?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="post.php" method="POST">
                                            <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger" name="delete_post">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            endwhile;
        else :
        ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPostModalLabel">Create a New Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Post creation form -->
                        <form action="post.php" method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="create_post">Create Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
