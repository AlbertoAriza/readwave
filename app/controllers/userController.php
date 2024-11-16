<?php
include_once __DIR__ . '/../models/user.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function registerUser($username, $email, $password) {
        // Validación de datos
        if (empty($username) || empty($email) || empty($password)) {
            return "All fields are required.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }

        // Verificar si el usuario existe
        if ($this->userModel->userExists($email)) {
            return "User already exists.";
        }

        // Registrar usuario
        $success = $this->userModel->register($username, $email, $password);
        return $success ? "Registration successful!" : "Error registering user.";
    }

    public function loginUser($email, $password) {
        $user = $this->userModel->authenticate($email, $password);

        if ($user) {
            // Almacena la información del usuario en la sesión
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirige al dashboard
            header("Location: index.php?page=audiobooks");
            exit; // Asegura que no se ejecuta más código después de la redirección
        } else {
            return "Invalid email or password.";
        }
    }
}
?>