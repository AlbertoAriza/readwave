<?php
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Subtitle.php';
require_once __DIR__ . '/../models/AudioFile.php';

class BookController {
    private $bookModel;
    private $subtitleModel;
    private $audioFileModel;
    
    public function __construct($db) {
        $this->bookModel = new Book($db);
        $this->subtitleModel = new Subtitle($db);
        $this->audioFileModel = new AudioFile($db);
    }

    public function readBook($bookId) {
        $book = $this->bookModel->getBookById($bookId);
        $subtitles = $this->subtitleModel->getSubtitlesByBookId($bookId);
        $audioFile = $this->audioFileModel->getAudioFileByBookId($bookId);
    
        if ($book && $subtitles && $audioFile) {
            require_once __DIR__ . '/../views/read.php';
        } else {
            // Manejar error: libro no encontrado
            header("Location: index.php?page=audiobooks");
        }
    }

    public function displayBooks() {
        $books = $this->bookModel->getAllBooks();
        if (empty($books)) {
            echo "<p>No books available.</p>";
            return;
        }
        require_once __DIR__ . '/../views/booksList.php';
    }
}