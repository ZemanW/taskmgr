<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email already exists";
        }
    }

    // Validate password
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    // Validate password confirmation
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        try {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $stmt->execute([$name, $email, $hashedPassword]);
            
            // Create welcome notification
            $userId = $pdo->lastInsertId();
            $welcomeMsg = "Welcome to TaskManager, " . $name . "!";
            $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $stmt->execute([$userId, $welcomeMsg]);
            
            $_SESSION['success'] = "Account created successfully! Please login.";
            header("Location: ../view/login.php");
            exit();
        } catch(PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $_SESSION['error'] = "Registration failed. Please try again later.";
            header("Location: ../view/signup.php");
            exit();
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: ../view/signup.php");
        exit();
    }
}
?>