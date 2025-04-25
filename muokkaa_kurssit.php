<?php
include 'db.php'; 

if (!isset($_GET['id'])) {
    die('Course ID is required');
}

$course_id = $_GET['id'];

$sql = "
    SELECT k.*, 
           CONCAT(o.etunimi, ' ', o.sukunimi) AS opettaja_nimi, 
           t.nimi AS tila_nimi
    FROM kurssit k
    LEFT JOIN opettajat o ON k.opettaja_id = o.id
    LEFT JOIN tilat t ON k.tila_id = t.id
    WHERE k.id = :course_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
$stmt->execute();

$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die('Course not found');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tunnus = $_POST['tunnus'];
    $nimi = $_POST['nimi'];
    $kuvaus = $_POST['kuvaus'];
    $alkupaiva = $_POST['alkupaiva'];
    $loppupaiva = $_POST['loppupaiva'];
    $opettaja_id = $_POST['opettaja_id'];
    $tila_id = $_POST['tila_id'];

    $update_sql = "
        UPDATE kurssit
        SET tunnus = :tunnus,
            nimi = :nimi,
            kuvaus = :kuvaus,
            alkupaiva = :alkupaiva,
            loppupaiva = :loppupaiva,
            opettaja_id = :opettaja_id,
            tila_id = :tila_id
        WHERE id = :course_id";
    
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindParam(':tunnus', $tunnus);
    $update_stmt->bindParam(':nimi', $nimi);
    $update_stmt->bindParam(':kuvaus', $kuvaus);
    $update_stmt->bindParam(':alkupaiva', $alkupaiva);
    $update_stmt->bindParam(':loppupaiva', $loppupaiva);
    $update_stmt->bindParam(':opettaja_id', $opettaja_id, PDO::PARAM_INT);
    $update_stmt->bindParam(':tila_id', $tila_id, PDO::PARAM_INT);
    $update_stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    
    if ($update_stmt->execute()) {
        $_SESSION['success'] = 'Kurssi p�ivitetty onnistuneesti';
        header('Location: kurssit.php');
        exit;
    } else {
        $_SESSION['error'] = 'Kurssin p�ivitys ep�onnistui';
    }
}
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
    <h1>Muokkaa kurssia: <?php echo htmlspecialchars($course['nimi']); ?></h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="kurssi_muokkaa.php?id=<?php echo $course['id']; ?>">
        <label for="tunnus">Tunnus:</label>
        <input type="text" id="tunnus" name="tunnus" value="<?php echo htmlspecialchars($course['tunnus']); ?>" required>

        <label for="nimi">Nimi:</label>
        <input type="text" id="nimi" name="nimi" value="<?php echo htmlspecialchars($course['nimi']); ?>" required>

        <label for="kuvaus">Kuvaus:</label>
        <textarea id="kuvaus" name="kuvaus"><?php echo htmlspecialchars($course['kuvaus']); ?></textarea>

        <label for="alkupaiva">Alkup�iv�:</label>
        <input type="date" id="alkupaiva" name="alkupaiva" value="<?php echo $course['alkupaiva']; ?>" required>

        <label for="loppupaiva">Loppup�iv�:</label>
        <input type="date" id="loppupaiva" name="loppupaiva" value="<?php echo $course['loppupaiva']; ?>" required>

        <label for="opettaja_id">Opettaja:</label>
        <select id="opettaja_id" name="opettaja_id">
            <?php
            
            $teachers_sql = "SELECT * FROM opettajat";
            $teachers_stmt = $conn->query($teachers_sql);
            while ($teacher = $teachers_stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
                <option value="<?php echo $teacher['id']; ?>" <?php echo $teacher['id'] == $course['opettaja_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($teacher['etunimi'] . ' ' . $teacher['sukunimi']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="tila_id">Tila:</label>
        <select id="tila_id" name="tila_id">
            <?php
            
            $rooms_sql = "SELECT * FROM tilat";
            $rooms_stmt = $conn->query($rooms_sql);
            while ($room = $rooms_stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
                <option value="<?php echo $room['id']; ?>" <?php echo $room['id'] == $course['tila_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($room['nimi']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">P�ivit� kurssi</button>
    </form>
</body>
</html>
