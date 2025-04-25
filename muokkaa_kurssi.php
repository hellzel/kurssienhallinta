<?php
include 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    $_SESSION['error'] = "ID puuttuu";
    header("Location: kurssit.php");
    exit();
}

// Fetch current course data
$sql = "
    SELECT k.*, 
           CONCAT(o.etunimi, ' ', o.sukunimi) AS opettaja_nimi, 
           t.nimi AS tila_nimi
    FROM kurssit k
    LEFT JOIN opettajat o ON k.opettaja_id = o.id
    LEFT JOIN tilat t ON k.tila_id = t.id
    WHERE k.id = :course_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':course_id', $id, PDO::PARAM_INT);
$stmt->execute();
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    $_SESSION['error'] = "Kurssia ei löytynyt";
    header("Location: kurssit.php");
    exit();
}

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

        $sql = "
            UPDATE kurssit
            SET tunnus = :tunnus, 
                nimi = :nimi, 
                kuvaus = :kuvaus, 
                alkupaiva = :alkupaiva, 
                loppupaiva = :loppupaiva, 
                opettaja_id = :opettaja_id, 
                tila_id = :tila_id
            WHERE id = :course_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tunnus', $tunnus);
        $stmt->bindParam(':nimi', $nimi);
        $stmt->bindParam(':kuvaus', $kuvaus);
        $stmt->bindParam(':alkupaiva', $alkupaiva);
        $stmt->bindParam(':loppupaiva', $loppupaiva);
        $stmt->bindParam(':opettaja_id', $opettaja_id);
        $stmt->bindParam(':tila_id', $tila_id);
        $stmt->bindParam(':course_id', $id);
        
        $stmt->execute();

        $_SESSION['success'] = "Kurssi päivitetty onnistuneesti";
        header("Location: kurssit.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "Virhe: " . $e->getMessage();
    }
}

// Fetch teachers and rooms for dropdowns
$teachers = $conn->query("SELECT id, CONCAT(etunimi, ' ', sukunimi) as nimi FROM opettajat ORDER BY sukunimi")->fetchAll(PDO::FETCH_ASSOC);
$rooms = $conn->query("SELECT id, nimi FROM tilat ORDER BY nimi")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muokkaa Kurssia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="container">
        <h1>Muokkaa Kurssia</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="post" class="form-container">
            <div class="form-group">
                <label for="tunnus">Tunnus:</label>
                <input type="text" id="tunnus" name="tunnus" 
                       value="<?php echo htmlspecialchars($course['tunnus']); ?>" required>
            </div>

            <div class="form-group">
                <label for="nimi">Nimi:</label>
                <input type="text" id="nimi" name="nimi" 
                       value="<?php echo htmlspecialchars($course['nimi']); ?>" required>
            </div>

            <div class="form-group">
                <label for="kuvaus">Kuvaus:</label>
                <textarea id="kuvaus" name="kuvaus" required><?php echo htmlspecialchars($course['kuvaus']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="alkupaiva">Alkupäivä:</label>
                <input type="date" id="alkupaiva" name="alkupaiva" 
                       value="<?php echo htmlspecialchars($course['alkupaiva']); ?>" required>
            </div>

            <div class="form-group">
                <label for="loppupaiva">Loppupäivä:</label>
                <input type="date" id="loppupaiva" name="loppupaiva" 
                       value="<?php echo htmlspecialchars($course['loppupaiva']); ?>" required>
            </div>

            <div class="form-group">
                <label for="opettaja_id">Opettaja:</label>
                <select id="opettaja_id" name="opettaja_id" required>
                    <option value="">Valitse opettaja</option>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?php echo $teacher['id']; ?>" 
                                <?php echo ($teacher['id'] == $course['opettaja_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($teacher['nimi']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tila_id">Tila:</label>
                <select id="tila_id" name="tila_id" required>
                    <option value="">Valitse tila</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?php echo $room['id']; ?>" 
                                <?php echo ($room['id'] == $course['tila_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($room['nimi']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="button-group">
                <button type="submit">Tallenna muutokset</button>
                <a href="kurssit.php" class="button">Peruuta</a>
            </div>
        </form>
    </div>
</body>
</html>
