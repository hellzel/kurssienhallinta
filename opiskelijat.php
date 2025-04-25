<?php
include 'db.php';

// Fetch students
$sql = "SELECT * FROM opiskelijat";
$stmt = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opiskelijat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Opiskelijat</h1>
    <a href="lisaa_opiskelija.php" class="button">Lisää uusi opiskelija</a>
    
    <table>
        <thead>
            <tr>
                <th>Opiskelijanumero</th>
                <th>Etunimi</th>
                <th>Sukunimi</th>
                <th>Syntymäpäivä</th>
                <th>Vuosikurssi</th>
                <th>Toiminnot</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['opiskelijanumero']); ?></td>
                <td><?php echo htmlspecialchars($row['etunimi']); ?></td>
                <td><?php echo htmlspecialchars($row['sukunimi']); ?></td>
                <td><?php echo htmlspecialchars($row['syntymapaiva']); ?></td>
                <td><?php echo htmlspecialchars($row['vuosikurssi']); ?></td>
                <td>
                    <a href="muokkaa_opiskelija.php?id=<?php echo $row['id']; ?>">Muokkaa</a>
                    <a href="poista_opiseklija.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Haluatko varmasti poistaa tämän opiskelijan?')">Poista</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
