<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido</h1>
        
        <!-- Login Form -->
        <div id="loginForm" class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Iniciar sesión</button>
            </form>
            <p><a href="#registerForm" class="toggle-link">Crea tu usuario</a></p>
        </div>
        
        <!-- Register Form -->
        <div id="registerForm" class="form-container hidden">
            <h2>Registro</h2>
            <form action="register.php" method="post">
                <label for="susername">Usuario:</label>
                <input type="text" id="susername" name="susername" required>
                <label for="spassword">Contraseña:</label>
                <input type="password" id="spassword" name="spassword" required>
                <button type="submit">Registrarse</button>
            </form>
            <p><a href="#loginForm" class="toggle-link">Ya tengo una cuenta, iniciar sesión</a></p>
        </div>
    </div>
</body>
</html>
