<?php
require_once('../database/dbConnection.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = $conn->query("SELECT * FROM user WHERE username='$username' AND password='$password'");

    if ($query->num_rows > 0) {
        $row = $query->fetch_array();
        $_SESSION['user'] = (int)$row['userid'];
        echo "<span>WASAAA</span>";
        exit();
    } else {
        echo "<span>Login fallido. Usuario no encontrado.</span>";
    }
}
?>
