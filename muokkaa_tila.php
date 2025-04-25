<?php
include 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    $_SESSION['error'] = "ID puuttuu";
    header("Location: tilat.php");
    exit();
}

$sql = "SELECT * FROM tilat WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$tila = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tila) {
    $_SESSION['error'] = "Tilaa ei löytynyt";
    header("Location: tilat.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nimi = $_POST['nimi'];
        $kapasiteetti = $_POST['kapasiteetti'];

        if ($kapasiteetti <= 0) {
            throw new Exception("Kapasiteetin täytyy olla suurempi kuin 0");
        }

        $sql = "UPDATE tilat SET nimi = ?, kapasiteetti = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nimi, $kapasiteetti, $id]);

        $_SESSION['success'] = "Tila päivitetty onnistuneesti";
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
    <title>Muokkaa Tilaa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Muokkaa Tilaa</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Nimi:</label>
            <input type="text" name="nimi" value="<?php echo htmlspecialchars($tila['nimi']); ?>" required>
        </div>

        <div class="form-group">
            <label>Kapasiteetti:</label>
            <input type="number" name="kapasiteetti" value="<?php echo htmlspecialchars($tila['kapasiteetti']); ?>" min="1" required>
        </div>

        <button type="submit">Tallenna muutokset</button>
        <a href="tilat.php" class="button">Peruuta</a>
    </form>
</body>
</html>
