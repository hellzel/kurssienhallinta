<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM opiskelijat WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$opiskelija = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $opiskelijanumero = $_POST['opiskelijanumero'];
    $etunimi = $_POST['etunimi'];
    $sukunimi = $_POST['sukunimi'];
    $syntymapaiva = $_POST['syntymapaiva'];
    $vuosikurssi = $_POST['vuosikurssi'];

    $sql = "UPDATE opiskelijat SET opiskelijanumero = ?, etunimi = ?, sukunimi = ?, syntymapaiva = ?, vuosikurssi = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$opiskelijanumero, $etunimi, $sukunimi, $syntymapaiva, $vuosikurssi, $id]);

    header("Location: opiskelijat.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muokkaa Opiskelijaa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Muokkaa Opiskelijaa</h1>
    <form method="post">
        <label>Opiskelijanumero:</label>
        <input type="text" name="opiskelijanumero" value="<?php echo htmlspecialchars($opiskelija['opiskelijanumero']); ?>" required><br>
        <label>Etunimi:</label>
        <input type="text" name="etunimi" value="<?php echo htmlspecialchars($opiskelija['etunimi']); ?>" required><br>
        <label>Sukunimi:</label>
        <input type="text" name="sukunimi" value="<?php echo htmlspecialchars($opiskelija['sukunimi']); ?>" required><br>
        <label>Syntymäpäivä:</label>
        <input type="date" name="syntymapaiva" value="<?php echo htmlspecialchars($opiskelija['syntymapaiva']); ?>" required><br>
        <label>Vuosikurssi:</label>
        <input type="number" name="vuosikurssi" value="<?php echo htmlspecialchars($opiskelija['vuosikurssi']); ?>" min="1" max="3" required><br>
        <button type="submit">Tallenna</button>
    </form>
</body>
</html>
