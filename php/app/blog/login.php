<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ./dashboard/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    
    <div class="container mt-5">
        <h2>Login</h2>
        <!-- Error Message Display -->
        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials') {
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Invalid username or password.';
            echo '</div>';
        }
        ?>

        <!-- Login Form -->
        <form action="login_process.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username or Email</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
            <a href="register.php" class="btn btn-primary">Register</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
