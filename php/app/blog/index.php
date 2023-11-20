<?php
include 'includes/db_connection.php';

$sql = "SELECT p.id, p.title, p.content, p.created_at, u.username 
        FROM posts p 
        INNER JOIN users u ON p.user_id = u.id 
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include 'includes/db_connection.php';

    $sqlTitle = "SELECT title FROM site_settings WHERE id = 1";
    $resultTitle = $conn->query($sqlTitle);

    if ($resultTitle->num_rows > 0) {
        $rowTitle = $resultTitle->fetch_assoc();
        echo '<title>' . $rowTitle['title'] . ' - Home</title>';
    } else {
        echo '<title>Blog - Home</title>';
    }

    $conn->close();
    ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo.png" alt="Logo" width="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome to the Blog!</h1>

        <!-- Display posts -->
        <?php if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text"><?php echo $row['content']; ?></p>
                        <p class="text-muted">Posted by <?php echo $row['username']; ?> on <?php echo date('Y-m-d', strtotime($row['created_at'])); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
</body>

</html>
