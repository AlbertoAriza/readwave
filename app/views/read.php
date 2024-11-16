<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit;
}

include_once __DIR__ . '/../../config/DatabaseConnection.php';
include_once __DIR__ . '/../../app/models/Subtitle.php';
include_once __DIR__ . '/../../app/models/AudioFile.php';
include_once __DIR__ . '/../../app/models/Book.php';

$bookId = $_GET['book_id'] ?? null;
if (!$bookId) {
    header("Location: index.php?page=audiobooks");
    exit;
}

$db = new DatabaseConnection();
$connection = $db->getConnection();

$subtitleModel = new Subtitle($connection);
$audioFileModel = new AudioFile($connection);

$subtitles = $subtitleModel->getSubtitlesByBookId($bookId);
$audioFile = $audioFileModel->getAudioFileByBookId($bookId);

if (!$book || !$audioFile) {
    header("Location: index.php?page=audiobooks");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($book['title']); ?> - Read & Listen</title>
    <link rel="stylesheet" href="/2024_11_24_readwave/public/css/styles.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($book['title']); ?></h1>
    <audio id="audio" controls>
        <source src="/2024_11_24_readwave/public/<?php echo htmlspecialchars($audioFile['file_path']); ?>" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <div id="text-container">
        <?php foreach ($subtitles as $subtitle): ?>
            <span class="subtitle"
                data-start="<?php echo htmlspecialchars($subtitle['start_time']); ?>"
                data-end="<?php echo htmlspecialchars($subtitle['end_time']); ?>">
                <?php echo htmlspecialchars($subtitle['text']); ?>
            </span>
        <?php endforeach; ?>
    </div>
    <script src="/2024_11_24_readwave/public/js/sync.js"></script>
</body>
</html>