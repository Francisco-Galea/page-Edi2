<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login/login.php");
    exit();
}

require_once('database/dbConnection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_guide'])) {
    $video_url = $_POST['video_url'];
    $author = $_SESSION['user'];  
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO guides (video_url, author, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $video_url, $author, $description);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_guide'])) {
    $id = $_POST['guide_id'];
    $video_url = $_POST['video_url'];
    $author = $_SESSION['user'];  
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE guides SET video_url=?, author=?, description=? WHERE id=?");
    $stmt->bind_param("sssi", $video_url, $author, $description, $id);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_guide'])) {
    $id = $_POST['guide_id'];

    $stmt = $conn->prepare("DELETE FROM guides WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$editGuide = null;
if (isset($_GET['edit_id'])) {
    $id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT * FROM guides WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editGuide = $result->fetch_assoc();
    $stmt->close();
}

$queryAll = "SELECT * FROM guides WHERE author = ?";  
$stmtAll = $conn->prepare($queryAll);
$stmtAll->bind_param("s", $_SESSION['user']);  
$stmtAll->execute();
$resultAll = $stmtAll->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración de Guías</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
        <a href="index.php" class="home-button">Volver al Inicio</a>
    </header>
    <div class="container">
        <h1>Panel de Administración de Guías</h1>
        <form action="dashboard.php" method="post">
            <h2><?php echo $editGuide ? 'Actualizar Guía' : 'Agregar Nueva Guía'; ?></h2>
            <input type="hidden" name="guide_id" value="<?php echo $editGuide ? $editGuide['id'] : ''; ?>">
            <label for="video_url">URL del Video:</label>
            <input type="text" id="video_url" name="video_url" value="<?php echo $editGuide ? htmlspecialchars($editGuide['video_url']) : ''; ?>" required>
            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required><?php echo $editGuide ? htmlspecialchars($editGuide['description']) : ''; ?></textarea>
            <button type="submit" name="<?php echo $editGuide ? 'update_guide' : 'add_guide'; ?>">
                <?php echo $editGuide ? 'Actualizar Guía' : 'Agregar Guía'; ?>
            </button>
        </form>
        <h2>Mis Guías</h2>
        <div class="all-guides">
            <?php
            if ($resultAll->num_rows > 0) {
                while ($row = $resultAll->fetch_assoc()) {
                    $videoUrl = htmlspecialchars($row['video_url']);
                    $author = htmlspecialchars($row['author']);
                    $description = htmlspecialchars($row['description']);
                    $thumbnailUrl = "https://img.youtube.com/vi/" . preg_replace('/.*v=([a-zA-Z0-9_-]{11}).*/', '$1', $videoUrl) . "/maxresdefault.jpg";
                    echo '<div class="guide-card">';
                    echo '<a href="' . $videoUrl . '" target="_blank">';
                    echo '<img src="' . $thumbnailUrl . '" alt="Miniatura">';
                    echo '</a>';
                    echo '<p>' . $description . '</p>';
                    echo '<p class="author">Autor: ' . $author . '</p>';
                    echo '<form action="dashboard.php" method="post" style="display:inline;">
                            <input type="hidden" name="guide_id" value="' . $row['id'] . '">
                            <button type="submit" name="delete_guide">Eliminar</button>
                        </form>';
                    echo '<form action="dashboard.php" method="get" style="display:inline;">
                            <input type="hidden" name="edit_id" value="' . $row['id'] . '">
                            <button type="submit">Actualizar</button>
                        </form>';
                    echo '</div>';
                }
            } else {
                echo '<p>No tienes guías subidas.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
