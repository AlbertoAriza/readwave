<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php?page=dashboard");
    exit;
}

// Include necessary files
require_once __DIR__ . '/../../config/DatabaseConnection.php';
require_once __DIR__ . '/../models/User.php';

// Initialize database connection
$database = new DatabaseConnection();
$db = $database->getConnection();

// Create User model instance
$userModel = new User($db);

// Initialize error message
$error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Register the user
    $userId = $userModel->register($username, $password);

    if ($userId) {
        // Registration successful

        // Option 1: Redirect to login page with a success message
        // header("Location: index.php?page=login&registered=1");
        // exit;

        // Option 2: Auto-login and redirect to dashboard
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        session_regenerate_id(true); // Security measure
        header("Location: index.php?page=dashboard");
        exit;
    } else {
        $error = "Registration failed. Username may already exist.";
    }
}
?>

<!-- Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - ReadWave</title>
    <link rel="stylesheet" href="/2024_11_24_readwave/public/css/styles.css">
</head>
<body>
    <h1>Register</h1>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="index.php?page=register" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php?page=login">Log in here</a>.</p>
</body>
</html>