<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit;
}

include_once __DIR__ . '/../../config/DatabaseConnection.php';
include_once __DIR__ . '/../../app/models/Book.php';

// Conectar a la base de datos y obtener libros
$db = new DatabaseConnection();
$connection = $db->getConnection();
$bookModel = new Book($connection);
$books = $bookModel->getAllBooks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audiobooks</title>
    <link rel="stylesheet" href="/2024_11_24_readwave/public/css/styles.css">
<link rel="stylesheet" href="/2024_11_24_readwave/public/css/audiobooks_php.css">
</head>
<body>
    <h1>Audiobooks</h1>
    <nav>
        <a href="index.php?page=dashboard">Dashboard</a>
        <a href="index.php?page=logout">Logout</a>
    </nav>
    <!-- Contenedor de audiolibros con estilo de fichas -->
    <div class="audiobooks-container">
        <?php foreach ($books as $book): ?>
            <div class="audiobook-card">
                <!-- Imagen del libro -->
                <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover of <?php echo htmlspecialchars($book['title']); ?>" class="audiobook-cover">

                <!-- Información del libro -->
                <div class="audiobook-info">
                    <h3 class="audiobook-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p class="audiobook-author">By <?php echo htmlspecialchars($book['author']); ?></p>
                    <p class="audiobook-description"><?php echo htmlspecialchars($book['description']); ?></p>
                    <a href="/2024_11_24_readwave/public/index.php?page=read&book_id=<?php echo htmlspecialchars($book['book_id']); ?>" class="view-details">Read & Listen</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>