<?php
include '../includes/db_connection.php';

// Handle post update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_post'])) {
    $post_id = $_POST['post_id'];
    $new_title = $_POST['new_title'];
    $new_content = $_POST['new_content'];

    $sql = "UPDATE posts SET title=?, content=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $new_title, $new_content, $post_id);

    if ($stmt->execute()) {
        // Trigger success modal after successful update
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var myModal = new bootstrap.Modal(document.getElementById("successUpdateModal"));
                    myModal.show();
                });
            </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
?>

<!-- Success Modal -->
<div class="modal fade" id="successUpdateModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>The post has been updated successfully.</p>
            </div>
        </div>
    </div>
</div>
