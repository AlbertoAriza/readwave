<?php
class Subtitle {
    private $conn;
    private $table = 'subtitles';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSubtitlesByBookId($bookId) {
        $query = "SELECT subtitle_id, book_id, text, start_time, end_time 
                  FROM " . $this->table . " 
                  WHERE book_id = :book_id 
                  ORDER BY start_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>