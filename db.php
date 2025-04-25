<?php
session_start();

$servername = "localhost";
$username = "22p_3302";
$password = "22p_3302";
$dbname = "Kurssienhallinta projekti";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
