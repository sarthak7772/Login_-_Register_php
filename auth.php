<?php
session_start();
require_once 'config.php';

// Initialize alerts array
if (!isset($_SESSION['alerts'])) {
    $_SESSION['alerts'] = [];
}

// Check if database connection is available
if (!isset($conn) || $conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Handle registration
if (isset($_POST['register_btn'])) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password_raw = isset($_POST['password']) ? $_POST['password'] : '';
    $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Email is already registered'
        ];
        $_SESSION['active_form'] = 'register';
    } else {
        // Insert new user
        $stmt->close(); // Close previous statement before reuse
        $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password_hashed);

        if ($stmt->execute()) {
            $_SESSION['alerts'][] = [
                'type' => 'success',
                'message' => 'Registration successful. Please log in.'
            ];
            $_SESSION['active_form'] = 'login';
        } else {
            $_SESSION['alerts'][] = [
                'type' => 'error',
                'message' => 'Registration failed. Please try again.'
            ];
            $_SESSION['active_form'] = 'register';
        }
    }

    $stmt->close();
    header('Location: index.php');
    exit();
}

// Handle login
if (isset($_POST['login_btn'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $stmt = $conn->prepare("SELECT name, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['name'] = $name;
            $_SESSION['alerts'][] = [
                'type' => 'success',
                'message' => 'Login successful'
            ];
        } else {
            $_SESSION['alerts'][] = [
                'type' => 'error',
                'message' => 'Invalid email or password'
            ];
            $_SESSION['active_form'] = 'login';
        }
    } else {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Invalid email or password'
        ];
        $_SESSION['active_form'] = 'login';
    }

    $stmt->close();
    header('Location: index.php');
    exit();
}
?>
