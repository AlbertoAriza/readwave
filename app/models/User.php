<!--  Un modelo User.php que verifique si un usuario existe en la base de datos 
      o almacene uno nuevo durante el registro. -->
<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }


    // Method to check if a user exists by email
    public function userExists($email) {
        $query = "SELECT user_id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function register($username, $password) {
        // Check if the username already exists
        $query = "SELECT user_id FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->fetch()) {
            // Username exists
            return false;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user
        $query = "INSERT INTO " . $this->table . " (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            // Return the newly created user's ID
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    // Otros métodos relevantes

    public function authenticate($email, $password) {
        $query = "SELECT user_id, username, password FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Si el usuario existe, verifica la contraseña
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                // Retorna los datos del usuario si la autenticación es exitosa
                return [
                    'id' => $row['user_id'],
                    'username' => $row['username']
                ];
            }
        }
    
        // Retorna false si la autenticación falla
        return false;
    }
}
?>