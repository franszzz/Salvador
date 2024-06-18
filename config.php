<?php
$servername = "localhost";
$username = "id22331576_root";
$password = "@Fran0515";
$dbname = "id22331576_task";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

