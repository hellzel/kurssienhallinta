<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nimi = $_POST['nimi'];
        $kapasiteetti = $_POST['kapasiteetti'];

        // Validate capacity
        if ($kapasiteetti <= 0) {
            throw new Exception("Kapasiteetin täytyy olla suurempi kuin 0");
        }

        $sql = "INSERT INTO tilat (nimi, kapasiteetti) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nimi, $kapasiteetti]);

        $_SESSION['success'] = "Tila lisätty onnistuneesti";
        header("Location: tilat.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "Virhe: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää Tila</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Lisää Tila</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Nimi:</label>
            <input type="text" name="nimi" required>
        </div>

        <div class="form-group">
            <label>Kapasiteetti:</label>
            <input type="number" name="kapasiteetti" min="1" required>
        </div>

        <button type="submit">Lisää tila</button>
        <a href="tilat.php" class="button">Peruuta</a>
    </form>
</body>
</html>
