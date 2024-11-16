<?php
class AudioFile {
    private $conn;
    private $table = 'audio_files'; // Asegúrate de que esta tabla exista en tu base de datos

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ejemplo de un método para obtener el archivo de audio por libro
    public function getAudioFileByBookId($bookId) {
        $query = "SELECT * FROM " . $this->table . " WHERE book_id = :book_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>