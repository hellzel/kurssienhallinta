<?php
include 'db.php';

// Fetch teachers for dropdown
$sql_opettajat = "SELECT id, CONCAT(etunimi, ' ', sukunimi) as nimi FROM opettajat ORDER BY sukunimi";
$stmt_opettajat = $conn->query($sql_opettajat);
$opettajat = $stmt_opettajat->fetchAll(PDO::FETCH_ASSOC);

// Fetch rooms for dropdown
$sql_tilat = "SELECT id, nimi FROM tilat ORDER BY nimi";
$stmt_tilat = $conn->query($sql_tilat);
$tilat = $stmt_tilat->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $tunnus = $_POST['tunnus'];
        $nimi = $_POST['nimi'];
        $kuvaus = $_POST['kuvaus'];
        $alkupaiva = $_POST['alkupaiva'];
        $loppupaiva = $_POST['loppupaiva'];
        $opettaja_id = $_POST['opettaja_id'];
        $tila_id = $_POST['tila_id'];

        // Validate dates
        if ($alkupaiva > $loppupaiva) {
            throw new Exception("Alkupäivä ei voi olla loppupäivän jälkeen");
        }

        $sql = "INSERT INTO kurssit (tunnus, nimi, kuvaus, alkupaiva, loppupaiva, opettaja_id, tila_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$tunnus, $nimi, $kuvaus, $alkupaiva, $loppupaiva, $opettaja_id, $tila_id]);

        $_SESSION['success'] = "Kurssi lisätty onnistuneesti";
        header("Location: kurssit.php");
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
    <title>Lisää Kurssi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Lisää Kurssi</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Tunnus:</label>
            <input type="text" name="tunnus" required>
        </div>

        <div class="form-group">
            <label>Nimi:</label>
            <input type="text" name="nimi" required>
        </div>

        <div class="form-group">
            <label>Kuvaus:</label>
            <textarea name="kuvaus" required></textarea>
        </div>

        <div class="form-group">
            <label>Alkupäivä:</label>
            <input type="date" name="alkupaiva" required>
        </div>

        <div class="form-group">
            <label>Loppupäivä:</label>
            <input type="date" name="loppupaiva" required>
        </div>

        <div class="form-group">
            <label>Opettaja:</label>
            <select name="opettaja_id" required>
                <option value="">Valitse opettaja</option>
                <?php foreach ($opettajat as $opettaja): ?>
                    <option value="<?php echo $opettaja['id']; ?>">
                        <?php echo htmlspecialchars($opettaja['nimi']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tila:</label>
            <select name="tila_id" required>
                <option value="">Valitse tila</option>
                <?php foreach ($tilat as $tila): ?>
                    <option value="<?php echo $tila['id']; ?>">
                        <?php echo htmlspecialchars($tila['nimi']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Lisää kurssi</button>
        <a href="kurssit.php" class="button">Peruuta</a>
    </form>
</body>
</html>