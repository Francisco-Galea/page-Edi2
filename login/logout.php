<?php
session_start();

// Cierra la sesion
session_destroy();

// Cuando la cierra, te manda a login.php
header("Location: login.php");

// Cierra el script para que no quede en segundo plano
exit();
?>