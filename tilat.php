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

$sql = "SELECT * FROM tilat";
$stmt = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Tilat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Tilat</h1>
    <a href="lisaa_tila.php" class="button">Lisää uusi tila</a>
    
    <table>
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Kapasiteetti</th>
                <th>Toiminnot</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($stmt->rowCount() > 0): ?>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nimi']); ?></td>
                        <td><?php echo htmlspecialchars($row['kapasiteetti']); ?></td>
                        <td>
                            <a href="muokkaa_tila.php?id=<?php echo $row['id']; ?>">Muokkaa</a>
                            <a href="poista_tila.php?id=<?php echo $row['id']; ?>" 
                               onclick="return confirm('Haluatko varmasti poistaa tämän tilan?')">Poista</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Ei tiloja</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
