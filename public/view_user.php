<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// connection to database
require '../config.php';
$conn = getConnection();

// getting user ID
$user_id = $_GET['id'];
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

echo "Login: " . $user['username'] . "<br>";
echo "Name: " . $user['first_name'] . "<br>";
echo "Surname: " . $user['last_name'] . "<br>";
echo "Gender: " . $user['gender'] . "<br>";
echo "Date of birth: " . $user['birth_date'] . "<br>";
