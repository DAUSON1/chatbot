<?php
$host = "localhost";
$user = "root";   // default kwa XAMPP
$pass = "";       // kama huna password
$db   = "chatbot_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
