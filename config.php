<?php
function getConnection() {
    $conn = new mysqli('localhost', 'username', 'password', 'users_db');

    // Checking connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>