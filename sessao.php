<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['usuarios_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.html");
        exit();
    }
}
?>
