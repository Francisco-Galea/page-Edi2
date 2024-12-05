<?php
require_once('../database/dbConnection.php');

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['susername']) && isset($_POST['spassword'])) {
        $username = $_POST['susername'];
        $password = $_POST['spassword'];

        $query = $conn->query("SELECT * FROM users WHERE username='$username'");

        if ($query->num_rows > 0) {
            $error_message = "El nombre de usuario ya existe.";
        } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
            $error_message = "Nombre de usuario inválido. Espacios y caracteres especiales no permitidos.";
        } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $password)) {
            $error_message = "Contraseña inválida. Espacios y caracteres especiales no permitidos.";
        } else {
            $mpassword = md5($password);
            $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$mpassword')");
            $success_message = "Registro exitoso.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container-session">
        <h1>Registro</h1>
        <div id="registerForm" class="form-container">
            <h2>Registro</h2>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form action="register.php" method="post">
                <label for="susername">Usuario:</label>
                <input type="text" id="susername" name="susername" required>
                <label for="spassword">Contraseña:</label>
                <input type="password" id="spassword" name="spassword" required>
                <button type="submit">Registrarse</button>
            </form>
            <p><a href="../login/login.html" class="toggle-link">Ya tengo una cuenta, iniciar sesión</a></p>
        </div>
    </div>
</body>
</html>