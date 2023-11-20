<?php
include 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    // Check if the input is an email address
    $isEmail = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL);

    // Prepare SQL statement based on whether input is an email or username
    if ($isEmail) {
        $sql = "SELECT id, username, password FROM users WHERE email = ?";
    } else {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;
            // Redirect to dashboard
            header("Location: ./dashboard/index.php");
            exit();
        } else {
            // wrong username or password redirect to invalid functions
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: login.php?error=invalid_credentials");
        exit();
    }

    $stmt->close();
}
?>

