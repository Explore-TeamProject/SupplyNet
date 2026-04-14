<?php
session_start();
require_once '../config/db.php';

// Prevent users from accessing if they are already authenticated successfully
if (isset($_SESSION['UserID'])) {
    $role = strtolower($_SESSION['Role']);
    header("Location: ../" . ($role === 'delivery_person' ? 'Delivery' : $role) . "/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store POST data to preserve form inputs on error
    $_SESSION['post_data'] = $_POST;
    
    $username = mysqli_real_escape_string($conn, trim($_POST['username'] ?? ''));
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $mobile = mysqli_real_escape_string($conn, trim($_POST['mobile'] ?? ''));
    $address = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));
    
    // Explicitly enforce hardcoded top-level admin security layer context
    $role = 'admin'; 
    
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Standard Form Layer Checks
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please fill out all required fields marked with an asterisk (*).';
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match. Please ensure both fields are exactly the same.';
    } elseif (strlen($password) < 6) {
        $_SESSION['error'] = 'For security reasons, your password must be at least 6 characters long.';
    } else {
        // Prevent registering a duplicate email inside Users
        $chk_email = mysqli_query($conn, "SELECT UserID FROM Users WHERE Email = '$email'");
        if (mysqli_num_rows($chk_email) > 0) {
            $_SESSION['error'] = 'An account with that email already exists. Please <a href="../login.php" style="color:inherit; text-decoration:underline;">login</a> securely instead.';
        } else {
            // Provide exact same hashing mechanism for compatibility explicitly securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Commit to Database
            $query = "INSERT INTO Users (UserName, Password, Email, Role, mobile_number, address) 
                      VALUES ('$username', '$hashed_password', '$email', '$role', '$mobile', '$address')";
            
            if (mysqli_query($conn, $query)) {
                unset($_SESSION['post_data']);
                $_SESSION['success'] = 'System Administrator account successfully created! You may now <a href="../login.php" class="alert-link">proceed to login</a>.';
                header("Location: newAdmin.php");
                exit();
            } else {
                $_SESSION['error'] = 'Database Configuration Error: ' . mysqli_error($conn);
            }
        }
    }
    
    // If we reach here, there was an error
    header("Location: newAdmin.php");
    exit();
} else {
    // If not POST, redirect back to the form
    header("Location: newAdmin.php");
    exit();
}
?>
