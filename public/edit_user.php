<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// connection to database
require '../config.php';
$conn = getConnection();

$error = '';
$success = '';
$user_id = $_GET['id'];
$user = [];
$current_year = date('Y');

// getting current info of users
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
}

// processing the form on submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];

    // checking date format
    $birth_date_parts = explode('-', $birth_date);
    if (count($birth_date_parts) != 3 || !checkdate($birth_date_parts[1], $birth_date_parts[2], $birth_date_parts[0])) {
        $error = "Invalid date of birth format. Make sure the date is correct..";
    } elseif ($birth_date_parts[0] > $current_year) {
        $error = "The year of birth cannot be greater than the current year.";
    } elseif (empty($username) || empty($first_name) || empty($last_name) || empty($gender) || empty($birth_date)) {
        $error = "Please fill in all required fields.";
    } else {
        if (!empty($password)) {
            // if the password is specified, we hash it
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE users SET 
                      username='$username', 
                      password='$hashed_password', 
                      first_name='$first_name', 
                      last_name='$last_name', 
                      gender='$gender', 
                      birth_date='$birth_date' 
                      WHERE id='$user_id'";
        } else {
            // if the password is not specified, we do not update it
            $query = "UPDATE users SET 
                      username='$username', 
                      first_name='$first_name', 
                      last_name='$last_name', 
                      gender='$gender', 
                      birth_date='$birth_date' 
                      WHERE id='$user_id'";
        }

        if ($conn->query($query)) {
            $success = "User data updated successfully!";
            // After a successful update, we update the user data
            $result = $conn->query("SELECT * FROM users WHERE id='$user_id'");
            $user = $result->fetch_assoc();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit info</title>
</head>
<body>
<h1>Edit user's information</h1>

<?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<form action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
    <label for="first_name">Name:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars(isset($first_name) ? $first_name : $user['first_name']); ?>" required><br><br>

    <label for="last_name">Surname:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars(isset($last_name) ? $last_name : $user['last_name']); ?>" required><br><br>

    <label for="username">Login:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars(isset($username) ? $username : $user['username']); ?>" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="male" <?php echo (isset($gender) ? $gender : $user['gender']) == 'male' ? 'selected' : ''; ?>>Make</option>
        <option value="female" <?php echo (isset($gender) ? $gender : $user['gender']) == 'female' ? 'selected' : ''; ?>>Female</option>
    </select><br><br>

    <label for="birth_date">Date of birth:</label>
    <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars(isset($birth_date) ? $birth_date : $user['birth_date']); ?>" required><br><br>

    <input type="submit" value="Update information about user">
</form><br>

<a href="dashboard.php">Back to dashboard</a>
</body>
</html>
