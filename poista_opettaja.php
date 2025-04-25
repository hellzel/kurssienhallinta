<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM opettajat WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

header("Location: opettajat.php");
exit();
?>
