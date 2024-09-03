<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// connection to database
require '../config.php';
$conn = getConnection();

// sorting options
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc';
$new_order = $order == 'asc' ? 'desc' : 'asc';

// getting a list of users taking into account sorting and pagination
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM users ORDER BY id $order LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

echo "<h1>Administration panel</h1>";
echo "<a href='logout.php'>Logout</a><br><br>";
echo "<a href='add_user.php'>Create new user</a><br><br>";

echo "<table border='1'>";
echo "<tr>
        <th><a href='dashboard.php?page=$page&order=$new_order'>ID</a></th>
        <th>Login</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Actions</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['first_name'] . "</td>";
    echo "<td>" . $row['last_name'] . "</td>";
    echo "<td>
            <a href='view_user.php?id=" . $row['id'] . "'>Show</a> | 
            <a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> | 
            <a href='delete_user.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
          </td>";
    echo "</tr>";
}
echo "</table>";

// pagination navigation
$query = "SELECT COUNT(id) AS total FROM users";
$result = $conn->query($query);
$total_users = $result->fetch_assoc()['total'];
$total_pages = ceil($total_users / $limit);

if ($page > 1) {
    $prev_page = $page - 1;
    echo "<a href='dashboard.php?page=$prev_page&order=$order'>Previous</a> ";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> "; // current page
    } else {
        echo "<a href='dashboard.php?page=$i&order=$order'>$i</a> ";
    }
}

if ($page < $total_pages) {
    $next_page = $page + 1;
    echo "<a href='dashboard.php?page=$next_page&order=$order'>Next</a>";
}

echo "</div>";

$conn->close();
?>
