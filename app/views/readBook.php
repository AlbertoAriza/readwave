<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Readwave - Read and Listen</title>
    <link rel="stylesheet" href="/css/styles.css"> <!-- Archivo de estilos -->
</head>
<body>
    <div class="container">
        <h1 id="bookTitle">Book Title</h1>

        <!-- Reproductor de audio -->
        <audio id="audioPlayer" controls>
            <source src="/audio/tom_sawyer.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>

        <!-- Contenedor para el texto -->
        <div id="textContainer" class="text-content">
            <!-- El texto será inyectado dinámicamente aquí -->
        </div>
    </div>

    <script src="/js/readBook.js"></script> <!-- Archivo JavaScript para la lógica -->
</body>
</html>