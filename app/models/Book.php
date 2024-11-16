<?php
// app/models/Book.php

class Book {
    private $conn;
    private $table = 'books';

    // Propiedades
    public $book_id;
    public $title;
    public $author;
    public $description;
    public $cover_image;
    public $audio_path;
    public $created_at;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los libros
    public function getAllBooks() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un libro por ID
    public function getBookById($book_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE book_id = :book_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':book_id', $book_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>