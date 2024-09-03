<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// connection to database
require '../config.php';
$conn = getConnection();

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// getting user ID
$user_id = $_GET['id'];

// deleting of user
$query = "DELETE FROM users WHERE id='$user_id'";
if ($conn->query($query)) {
    header('Location: dashboard.php');
    exit();
} else {
    echo "Ошибка: " . $conn->error;
}

$conn->close();
?>
