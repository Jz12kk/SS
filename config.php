<?php
// Change the values below to match your MySQL database
$host = 'localhost';
$name = 'corretora';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>