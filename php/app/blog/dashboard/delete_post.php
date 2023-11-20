<?php
include '../includes/db_connection.php';

// Handle post deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];

    $sql = "DELETE FROM posts WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        // Trigger success modal after successful update
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var myModal = new bootstrap.Modal(document.getElementById("deleteModal"));
                    myModal.show();
                });
            </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
?>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>The post has been deleted successfully.</p>
            </div>
        </div>
    </div>
</div>
