<?php
require_once('../database/dbConnection.php');

// Uso variables para guardar errores y despues mostrarlos
$error_message = '';
$success_message = '';

// Envio el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifico que los datos del formulario estan completos
    if (isset($_POST['susername']) && isset($_POST['spassword'])) {

        // Agarro los valores del formulario
        $username = $_POST['susername'];
        $password = $_POST['spassword'];

        // Filtro los usuarios por el username
        $query = $conn->query("SELECT * FROM users WHERE username='$username'");

        // Si encuentra un usuario 
        // (es decir que ya existe uno con ese nombre)
        // Tiro error
        if ($query->num_rows > 0) {
            $error_message = "El nombre de usuario ya existe.";
        } 

        // Si pone una contraseña con caracteres especiales
        // No le dejo (estoy limitado)
        elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
            $error_message = "Nombre de usuario inválido. Espacios y caracteres especiales no permitidos.";
        } 
        
        // Si en la contraseña pone caracteres especiales
        // No le dejo, no llego a tanto jajaja
        elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $password)) {
            $error_message = "Contraseña inválida. Espacios y caracteres especiales no permitidos.";
        } 
        
        // Si no encuentra un usuario con ese nombre, le permite crear el usuario
        else {
            // md5 es el formato para encriptar la constraseña
            $mpassword = md5($password);

            // Ejecuto una consulta para guardar el nuevo usuario 
            // Importante: Guardo la contraseña encriptada
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
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container-session">
        <h1>Registro de Usuario</h1>
        <div id="registerForm" class="form-container">
            <h2>Crear Cuenta</h2>
            <?php

            // Si hay un error cuando se crea la cuenta, 
            // Muestra el error que sea
            if (!empty($error_message)) {
                echo "<div class='error-message'>$error_message</div>";
            }

            // Si no hay error
            // Muestra el mensaje que se creo bien la cuenta
            if (!empty($success_message)) {
                echo "<div class='success-message'>$success_message</div>";
            }
            ?>
            <form action="register.php" method="post">
                <label for="susername">Usuario:</label>
                <input type="text" id="susername" name="susername" required>
                <label for="spassword">Contraseña:</label>
                <input type="password" id="spassword" name="spassword" required>
                <div class="button-container">
                    <button type="submit">Registrarse</button>
                    <button type="button" onclick="window.location.href='../index.php'">Volver al inicio</button>
                </div>
            </form>
            <p><a href="../login/login.php" class="toggle-link">¿Ya tienes una cuenta? Inicia sesión</a></p>
        </div>
    </div>
</body>
</html>