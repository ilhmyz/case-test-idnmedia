<?php
include '../includes/db_connection.php';

// Handle post creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $user_id);

    if ($stmt->execute()) {
        // Trigger success modal after successful update
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var myModal = new bootstrap.Modal(document.getElementById("createSuccessModal"));
                    myModal.show();
                });
            </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
?>

<!-- Create Post Modal -->
<div class="modal fade" id="createSuccessModal" tabindex="-1" aria-labelledby="createSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSuccessModalLabel">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your post has been created successfully.</p>
            </div>
        </div>
    </div>
</div>

