<?php
$host = 'localhost';
$user = 'root'; // change if needed
$pass = '';     // change if needed
$db   = 'feedback_tree';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
