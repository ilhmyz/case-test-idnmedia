<?php
include '../includes/db_connection.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Update site title
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_title'])) {
    $newTitle = $_POST['new_title'];

    $sqlUpdateTitle = "UPDATE site_settings SET title = ?";
    $stmt = $conn->prepare($sqlUpdateTitle);
    $stmt->bind_param("s", $newTitle);

    if ($stmt->execute()) {
        // Update successful
        $successMessage = "Site title updated successfully!";
    } else {
        $errorMessage = "Error updating title: " . $conn->error;
    }

    $stmt->close();
}

$sqlGetTitle = "SELECT title FROM site_settings WHERE id = 1";
$resultTitle = $conn->query($sqlGetTitle);
$rowTitle = $resultTitle->fetch_assoc();
$currentTitle = $rowTitle['title'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Settings</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation Menu -->
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
        <h2>Settings</h2>
        <!-- Site Title Update Form -->
        <form action="settings.php" method="POST">
            <div class="mb-3">
                <label for="newTitle" class="form-label">Site Title</label>
                <input type="text" class="form-control" id="newTitle" name="new_title" value="<?php echo $currentTitle; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="update_title">Update Title</button>
        </form>

        <!-- Display success or error message -->
        <?php if (isset($successMessage)) : ?>
            <div class="alert alert-success mt-3" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php elseif (isset($errorMessage)) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
