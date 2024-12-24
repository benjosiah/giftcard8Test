<?php
require_once 'Database.php';
require_once 'Validation.php';
require_once 'Register.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Initialize classes
    $db = new Database();
    $validation = new Validation();
    $register = new Register($db->connection);

    // Validate inputs
    $validation->validateRequired('Name', $name);
    $validation->validateRequired('Email', $email);
    $validation->validateRequired('Password', $password);
    $validation->validateEmail($email);
    $validation->validatePasswordMatch($password, $confirmPassword);

    // Check for errors
    if ($validation->hasErrors()) {
        foreach ($validation->getErrors() as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        // Register user
        $result = $register->registerUser($name, $email, $password);
        if ($result === true) {
            echo "Registration successful!";
        } else {
            echo "<p style='color: red;'>$result</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
<h2>Register</h2>
<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br><br>

    <button type="submit">Register</button>
</form>
</body>
</html>
