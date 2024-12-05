<?php
require_once('../database/dbConnection.php');

if (isset($_POST['susername']) && isset($_POST['spassword'])) {
    $username = $_POST['susername'];
    $password = $_POST['spassword'];

    $query = $conn->query("SELECT * FROM users WHERE username='$username'");

    if ($query->num_rows > 0) {
        echo "<span>El nombre de usuario ya existe.</span>";
    } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
        echo "<span>Nombre de usuario inválido. Espacios y caracteres especiales no permitidos.</span>";
    } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $password)) {
        echo "<span>Contraseña inválida. Espacios y caracteres especiales no permitidos.</span>";
    } else {
        $mpassword = md5($password);
        $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$mpassword')");
        echo "<span>Registro exitoso.</span>";
    }
}
?>
