-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS language_learning_app;
USE language_learning_app;

/* Usamos la DB para las pruebas del programa de palabras. */
use db6tmmkdf528dw;

-- Crear la tabla de usuarios
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    preferences JSON DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear la tabla de libros
CREATE TABLE books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    category VARCHAR(100) DEFAULT NULL,
    level ENUM('A1', 'A2', 'B1', 'B2', 'C1', 'C2') NOT NULL,
    cover_image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear la tabla de archivos de audio
CREATE TABLE audio_files (
    audio_id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    duration INT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

-- Crear la tabla de subtítulos
CREATE TABLE subtitles (
    subtitle_id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    text TEXT NOT NULL,
    start_time FLOAT NOT NULL,
    end_time FLOAT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

-- Crear la tabla de progreso de usuario
CREATE TABLE user_progress (
    progress_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    last_position FLOAT DEFAULT 0,
    completed BOOLEAN DEFAULT FALSE,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

-- Crear la tabla de vocabulario de usuario
CREATE TABLE vocabulary (
    vocab_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    word VARCHAR(50) NOT NULL,
    meaning TEXT,
    favorite BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

-- Opcional: Agregar índices para optimizar búsquedas en los campos comunes
CREATE INDEX idx_user_book ON user_progress(user_id, book_id);
CREATE INDEX idx_user_word ON vocabulary(user_id, word);
CREATE INDEX idx_start_time ON subtitles(start_time);


-- Desactivar las verificaciones de claves foráneas temporalmente
SET FOREIGN_KEY_CHECKS = 0;
-- Eliminar la tabla de vocabulario de usuario
DROP TABLE IF EXISTS vocabulary;
-- Eliminar la tabla de progreso de usuario
DROP TABLE IF EXISTS user_progress;
-- Eliminar la tabla de subtítulos
DROP TABLE IF EXISTS subtitles;
-- Eliminar la tabla de archivos de audio
DROP TABLE IF EXISTS audio_files;
-- Eliminar la tabla de libros (si ya existe)
DROP TABLE IF EXISTS books;
-- Eliminar la tabla de usuarios
DROP TABLE IF EXISTS users;
-- Reactivar las verificaciones de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;


-- Poblar la tabla de usuarios
INSERT INTO users (username, email, password, preferences)
VALUES
('john_doe', 'john@example.com', 'hashed_password1', NULL),
('jane_smith', 'jane@example.com', 'hashed_password2', NULL);

-- Poblar la tabla de libros con enlaces a imágenes para testear
INSERT INTO books (title, author, description, category, level, cover_image)
VALUES
('The Adventures of Tom Sawyer', 'Mark Twain', 'A classic tale of adventure and friendship.', 'Fiction', 'B1', 'https://readwave.londoneyepad.com/imgs/tom_swayer.webp'),
('Pride and Prejudice', 'Jane Austen', 'A romantic story set in early 19th-century England.', 'Romance', 'B2', 'https://readwave.londoneyepad.com/imgs/pride_and_prejudice.webp'),
('A Brief History of Time', 'Stephen Hawking', 'An overview of the universe and its mysteries.', 'Science', 'C1', 'https://readwave.londoneyepad.com/imgs/brief_history_of_time.webp'),
('Harry Potter and the Phylosopher Stone', 'J.K. Rowling', 'A boy discovers he\'s a wizard and faces a dark foe.', 'Fantasy', 'B2', 'https://readwave.londoneyepad.com/imgs/hp_philosopher_stone.webp');

-- Poblar la tabla de archivos de audio
INSERT INTO audio_files (book_id, file_path, duration)
VALUES
(1, '/audio/tom_sawyer.mp3', 3600),
(2, '/audio/pride_prejudice.mp3', 4200),
(3, '/audio/brief_history.mp3', 5400),
(4, '/audio/HPatPS_ Ch01_The_Boy_Who_Lived.mp3', 5400);

-- Poblar la tabla de subtítulos
INSERT INTO subtitles (book_id, start_time, end_time, text)
VALUES
(1, 0.0, 3.5, 'Tom was a mischievous boy living in a small town.'),
(1, 3.6, 7.0, 'He loved exploring and causing trouble.'),
(2, 0.0, 4.0, 'It is a truth universally acknowledged, that a single man in possession of a good fortune, must be in want of a wife.'),
(3, 0.0, 5.0, 'The universe is a vast and mysterious place.'),
(4, 0.0, 7.0, 'Harry Potter and the Philosopher\'s Stone by J. K. Rowling.'),
(4, 7.1, 13.0, 'Chapter 1 The Boy Who Lived.'),
(4, 13.1, 19.0, 'Mr. and Mrs. Dursley of Number 4, Privet Drive, were proud to say that they were perfectly'),
(4, 19.1, 24.0, 'normal, thank you very much. They were the last people you\'d expect to be involved in'),
(4, 24.1, 31.0, 'anything strange or mysterious, because they just didn\'t hold with such nonsense.'),
(4, 31.1, 38.0, 'Mr. Dursley was the director of a firm called Grunnings, which made drills. He was a big,');

-- Poblar la tabla de progreso de usuario
INSERT INTO user_progress (user_id, book_id, last_position, completed)
VALUES
(1, 1, 15.0, FALSE),
(2, 2, 120.0, TRUE);

-- Poblar la tabla de vocabulario de usuario
INSERT INTO vocabulary (user_id, book_id, word, meaning, favorite)
VALUES
(1, 1, 'mischievous', 'causing trouble in a playful way', TRUE),
(1, 2, 'universally', 'in every case or situation', FALSE),
(2, 3, 'vast', 'extremely large', TRUE);


ALTER TABLE books
ADD COLUMN cover_image VARCHAR(255) DEFAULT NULL;



SELECT * FROM books;
SELECT * FROM subtitles;

DELETE FROM books
	WHERE book_id = 1;