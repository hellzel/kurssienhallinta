<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM opettajat WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$opettaja = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tunnusnumero = $_POST['tunnusnumero'];
    $etunimi = $_POST['etunimi'];
    $sukunimi = $_POST['sukunimi'];
    $aine = $_POST['aine'];

    $sql = "UPDATE opettajat SET tunnusnumero = ?, etunimi = ?, sukunimi = ?, aine = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tunnusnumero, $etunimi, $sukunimi, $aine, $id]);

    header("Location: opettajat.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muokkaa Opettajaa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Muokkaa Opettajaa</h1>
    <form method="post">
        <label>Tunnusnumero:</label>
        <input type="text" name="tunnusnumero" value="<?php echo htmlspecialchars($opettaja['tunnusnumero']); ?>" required><br>
        <label>Etunimi:</label>
        <input type="text" name="etunimi" value="<?php echo htmlspecialchars($opettaja['etunimi']); ?>" required><br>
        <label>Sukunimi:</label>
        <input type="text" name="sukunimi" value="<?php echo htmlspecialchars($opettaja['sukunimi']); ?>" required><br>
        <label>Aine:</label>
        <input type="text" name="aine" value="<?php echo htmlspecialchars($opettaja['aine']); ?>" required><br>
        <button type="submit">Tallenna</button>
    </form>
</body>
</html>
