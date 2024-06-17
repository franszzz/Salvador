<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM usuarios WHERE email='$email' AND password='$password'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['usuarios_id'] = $user['id'];
        $_SESSION['usuarios_name'] = $user['nome'];
        header("Location: cd.php");
    } else {
        echo "Login inválido.";
    }
}
?>

