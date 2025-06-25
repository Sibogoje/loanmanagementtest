<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
     exit;
 }

include('auth.php'); // Include your database connection or configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newRole = mysqli_real_escape_string($conn, $_POST['role']);
    $newPassword = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Assuming you have a database connection established
    // Insert the new user profile
    $insertQuery = "INSERT INTO useraccounts (username, role, password) VALUES ('$newUsername', '$newRole', '$hashedPassword')";
    
    if (mysqli_query($conn, $insertQuery)) {
        // Profile inserted successfully
        header('Location: profile.php'); // Redirect back to the profile page
        exit;
    } else {
        echo "Error inserting profile: " . mysqli_error($conn);
    }
}
?>
