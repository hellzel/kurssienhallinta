<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM opiskelijat WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

header("Location: opiskelijat.php");
exit();
?>
