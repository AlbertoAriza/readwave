<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the Database Connection
require_once __DIR__ . '/../config/DatabaseConnection.php';

// Initialize the Database Connection
$database = new DatabaseConnection();
$db = $database->getConnection();

// Include the BookController
require_once __DIR__ . '/../app/controllers/BookController.php';

if (isset($_GET['page'])) {
    $page = $_GET['page'];

    // Route to the requested page
    switch ($page) {
        case 'register':
            include_once __DIR__ . '/../app/views/register.php';
            break;
        case 'login':
            include_once __DIR__ . '/../app/views/login.php';
            break;
        case 'logout':
            // Handle logout
            session_destroy();
            header("Location: index.php");
            exit;
        case 'dashboard':
            include_once __DIR__ . '/../app/views/dashboard.php';
            break;
        case 'audiobooks':
            include_once __DIR__ . '/../app/views/audiobooks.php';
            break;
        case 'read':
            $bookId = $_GET['book_id'] ?? null;
            if ($bookId) {
                // Ensure $db is initialized before this point
                $bookController = new BookController($db);
                $bookController->readBook($bookId);
            } else {
                header("Location: index.php?page=audiobooks");
                exit;
            }
            break;
        case 'home':
        default:
            include_once __DIR__ . '/../app/views/home.php';
            break;
    }
} else {
    // Default page
    include_once __DIR__ . '/../app/views/home.php';
}
?>