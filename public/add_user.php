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
$current_year = date('Y');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // getting data from form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];

    // validation
    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($gender) || empty($birth_date)) {
        $error = "Please fill in all required fields.";
    } else {
        // checking the uniqueness of date of birth
        $birth_date_parts = explode('-', $birth_date);
        if (count($birth_date_parts) != 3 || !checkdate($birth_date_parts[1], $birth_date_parts[2], $birth_date_parts[0])) {
            $error = "Invalid date of birth format. Make sure the date is correct.";
        } elseif ($birth_date_parts[0] > $current_year) {
            $error = "The year of birth cannot be greater than the current year.";
        } else {
            // checking the uniqueness of a login
            $query = "SELECT id FROM users WHERE username = '$username'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $error = "Этот логин уже занят. Пожалуйста, выберите другой.";
            } else {
                // hashing password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $query = "INSERT INTO users (username, password, first_name, last_name, gender, birth_date) 
                          VALUES ('$username', '$hashed_password', '$first_name', '$last_name', '$gender', '$birth_date')";

                if ($conn->query($query) === TRUE) {
                    $success = "Пользователь добавлен успешно!";
                } else {
                    $error = "Ошибка: " . $conn->error;
                }
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new user</title>
</head>
<body>
<h1>Create new user</h1>

<?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<form action="add_user.php" method="post">
    <label for="first_name">Name:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars(isset($first_name) ? $first_name : ''); ?>" required><br><br>

    <label for="last_name">Surname:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars(isset($last_name) ? $last_name : ''); ?>" required><br><br>

    <label for="username">Login:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars(isset($username) ? $username : ''); ?>" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="male" <?php echo (isset($gender) && $gender == 'male') ? 'selected' : ''; ?>>Male</option>
        <option value="female" <?php echo (isset($gender) && $gender == 'female') ? 'selected' : ''; ?>>Female</option>
    </select><br><br>

    <label for="birth_date">Date of birth</label>
    <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars(isset($birth_date) ? $birth_date : ''); ?>" required><br><br>

    <input type="submit" value="Create new user">
</form><br>

<a href="dashboard.php">Back to dashboard</a>
</body>
</html>
