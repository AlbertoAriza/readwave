<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    // User is logged in, redirect to dashboard
    header("Location: index.php?page=dashboard");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to ReadWave</title>
    <link rel="stylesheet" href="/2024_11_24_readwave/public/css/styles.css">
</head>
<body>
    <h1>Welcome to ReadWave</h1>
    <p>Please choose an option below:</p>
    <a href="index.php?page=login">Log In</a> | 
    <a href="index.php?page=register">Register</a>
</body>
</html>