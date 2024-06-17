<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn->query("INSERT INTO usuarios (nome, email, password) VALUES ('$nome', '$email', '$password')");
    header("Location: index.html");
}
?>