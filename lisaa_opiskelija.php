<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $opiskelijanumero = $_POST['opiskelijanumero'];
    $etunimi = $_POST['etunimi'];
    $sukunimi = $_POST['sukunimi'];
    $syntymapaiva = $_POST['syntymapaiva'];
    $vuosikurssi = $_POST['vuosikurssi'];

    $sql = "INSERT INTO opiskelijat (opiskelijanumero, etunimi, sukunimi, syntymapaiva, vuosikurssi) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$opiskelijanumero, $etunimi, $sukunimi, $syntymapaiva, $vuosikurssi]);

    $_SESSION['success'] = "Opiskelija lisätty onnistuneesti";
    header("Location: opiskelijat.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää Opiskelija</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Lisää Opiskelija</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Opiskelijanumero:</label>
            <input type="text" name="opiskelijanumero" required>
        </div>

        <div class="form-group">
            <label>Etunimi:</label>
            <input type="text" name="etunimi" required>
        </div>

        <div class="form-group">
            <label>Sukunimi:</label>
            <input type="text" name="sukunimi" required>
        </div>

        <div class="form-group">
            <label>Syntymäpäivä:</label>
            <input type="date" name="syntymapaiva" required>
        </div>

        <div class="form-group">
            <label>Vuosikurssi:</label>
            <input type="number" name="vuosikurssi" min="1" max="3" required>
        </div>

        <button type="submit">Lisää opiskelija</button>
        <a href="opiskelijat.php" class="button">Peruuta</a>
    </form>
</body>
</html>
