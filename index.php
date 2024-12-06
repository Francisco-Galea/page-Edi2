<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guías de Videojuegos</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
        <img src="assets/images/logo-nueve.png" alt="Logo" class="logo">
        <a href="login/login.php" class="login-button">Inicia sesión</a>
    </header>    
    <div class="hero">
        <h1>Bienvenido a las Guías de Videojuegos</h1>
    </div>
    <div class="container">
        <div class="all-guides">
        <?php
            require_once('database/dbConnection.php');
            $queryAll = "SELECT * FROM guides";
            $resultAll = $conn->query($queryAll);
            if ($resultAll->num_rows > 0) {
                while ($row = $resultAll->fetch_assoc()) {
                    $videoUrl = htmlspecialchars($row['video_url']);
                    preg_match('/v=([a-zA-Z0-9_-]{11})/', $videoUrl, $matches);
                    $videoId = $matches[1];
                    $thumbnailUrl = "https://img.youtube.com/vi/$videoId/maxresdefault.jpg";
                    $description = htmlspecialchars($row['description']);
                    $author = htmlspecialchars($row['author']);
                    echo '<div class="guide-card">';
                    echo '<a href="' . $videoUrl . '" target="_blank">';
                    echo '<img src="' . htmlspecialchars($thumbnailUrl) . '" alt="Miniatura">';
                    echo '</a>';
                    echo '<p>' . $description . '</p>';
                    echo '<p class="author">Autor: ' . $author . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay guías disponibles.</p>';        
            }
        ?>
        </div>
    </div>
</body>
</html>
