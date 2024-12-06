<?php
$servername = "localhost"; // Nombre del servidor

// Generalmente estos datos son los default
$username = "root";  // Usuario del sv
$password = "";  // Clave del sv

// Nombre de la db con la que trabajo
$dbname = "edi2";

// Consulta para hacer la conexion a la db
$conn = new mysqli($servername, $username, $password, $dbname);

// Si no se logra la conexion, tira error
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
