<?php
include 'db.php';

if (isset($_SESSION['error'])) {
    echo '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo '<div class="success-message">' . htmlspecialchars($_SESSION['success']) . '</div>';
    unset($_SESSION['success']);
}

$sql = "
    SELECT k.*, 
           CONCAT(o.etunimi, ' ', o.sukunimi) AS opettaja_nimi,
           t.nimi AS tila_nimi,
           (SELECT COUNT(*) FROM kurssikirjautumiset WHERE kurssi_id = k.id) AS osallistujat
    FROM kurssit k
    LEFT JOIN opettajat o ON k.opettaja_id = o.id
    LEFT JOIN tilat t ON k.tila_id = t.id";
$stmt = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Kurssit</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Kurssit</h1>
    <a href="lisaa_kurssi.php" class="button">Lisää uusi kurssi</a>
    
    <table>
        <thead>
            <tr>
                <th>Tunnus</th>
                <th>Nimi</th>
                <th>Kuvaus</th>
                <th>Alkupäivä</th>
                <th>Loppupäivä</th>
                <th>Opettaja</th>
                <th>Tila</th>
                <th>Osallistujat</th>
                <th>Toiminnot</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['tunnus']); ?></td>
                <td><?php echo htmlspecialchars($row['nimi']); ?></td>
                <td><?php echo htmlspecialchars($row['kuvaus']); ?></td>
                <td><?php echo htmlspecialchars($row['alkupaiva']); ?></td>
                <td><?php echo htmlspecialchars($row['loppupaiva']); ?></td>
                <td><?php echo htmlspecialchars($row['opettaja_nimi']); ?></td>
                <td><?php echo htmlspecialchars($row['tila_nimi']); ?></td>
                <td><?php echo htmlspecialchars($row['osallistujat']); ?></td>
                <td>
                    <a href="muokkaa_kurssi.php?id=<?php echo $row['id']; ?>">Muokkaa</a>
                    <a href="poista_kurssi.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Haluatko varmasti poistaa tämän kurssin?')">Poista</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
