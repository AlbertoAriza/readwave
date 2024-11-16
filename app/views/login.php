<?php
include_once __DIR__ . '/../../config/DatabaseConnection.php';
include_once __DIR__ . '/../../app/controllers/userController.php';

// Crear una conexión a la base de datos y el controlador de usuario
$db = new DatabaseConnection();
$connection = $db->getConnection();
$controller = new UserController($connection);

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Llama al método loginUser en el controlador
    $message = $controller->loginUser($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Login</h2>

    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>

    <?php if (!empty($message)) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>