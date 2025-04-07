<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember-me']);

    // Basic validation
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields";
        header("Location: ../view/login.php");
        exit();
    }

    try {
        // Get user from database with all necessary fields
        $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Handle remember me
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
                
                // Update remember token in database
                $stmt = $pdo->prepare("UPDATE users SET remember_token = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$token, $user['id']]);
            }

            // Create welcome notification
            $welcomeMsg = "Welcome back, " . $user['name'] . "!";
            $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $stmt->execute([$user['id'], $welcomeMsg]);

            header("Location: ../view/home.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header("Location: ../view/login.php");
            exit();
        }
    } catch(PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        $_SESSION['error'] = "Login failed. Please try again later.";
        header("Location: ../view/login.php");
        exit();
    }
} else {
    header("Location: ../view/login.php");
    exit();
}
?>