<?php
$servername = "db";
$username = "deku";
$password = "bnha";
$dbname = "db_simple_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
