<?php
require_once('../database/dbConnection.php');
session_start();

// Uso esta variable por si falla el logeo
$error_message = "";

// Si le doy a logearse...
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Traigo los datos que el usuario haya puesto

    // Traigo el usuario
    $username = $_POST['username'];

    // Traigo la contraseña, la encripto y la guardo en esa variable
    $password = md5($_POST['password']);

    // A partir de los datos, hago la consulta con esos datos como filtros
    $query = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

    // Si encuentra un valor...
    if ($query->num_rows > 0) {
        $row = $query->fetch_array();

        // Almaceno el id del usuario, que será util para hacer las acciones como:
        // Crear, traer, modificar y eliminar guias
        $_SESSION['user'] = (int)$row['userid'];

        // Me redirige al dashboard donde estan las guias
        header("Location: ../dashboard.php");

        // Cierra el script
        exit();
    } else {

        //Si no encontro nada que concuerde
        // con el usuario o contraseña, sale
        $error_message = "Login fallido. Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
        .error-message {
            background-color: #ffcccc;
            color: #cc0000;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .button-container button {
            flex: 1;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="container-session">
        <h1>Bienvenido</h1>
        <div id="loginForm" class="form-container">
            <h2>Login</h2>

            <?php
            
            // Si hubo error en el login, tira el error
            if (!empty($error_message)) {
                echo "<div class='error-message'>$error_message</div>";
            }
            ?>
            <form action="login.php" method="post">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <div class="button-container">
                    <button type="submit">Iniciar sesión</button>
                    <button type="button" onclick="window.location.href='../index.php'">Volver al inicio</button>
                </div>
            </form>
            <p><a href="../register/register.php" class="toggle-link">Crea tu usuario</a></p>
        </div>
    </div>
</body>
</html>