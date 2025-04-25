<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tunnusnumero = $_POST['tunnusnumero'];
    $etunimi = $_POST['etunimi'];
    $sukunimi = $_POST['sukunimi'];
    $aine = $_POST['aine'];

    $sql = "INSERT INTO opettajat (tunnusnumero, etunimi, sukunimi, aine) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tunnusnumero, $etunimi, $sukunimi, $aine]);

    $_SESSION['success'] = "Opettaja lisätty onnistuneesti";
    header("Location: opettajat.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää Opettaja</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Lisää Opettaja</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Tunnusnumero:</label>
            <input type="text" name="tunnusnumero" required>
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
            <label>Aine:</label>
            <input type="text" name="aine" required>
        </div>

        <button type="submit">Lisää opettaja</button>
        <a href="opettajat.php" class="button">Peruuta</a>
    </form>
</body>
</html>
