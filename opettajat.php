<?php
include 'db.php';

$sql = "SELECT * FROM opettajat";
$stmt = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opettajat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Opettajat</h1>
    <a href="lisaa_opettaja.php" class="button">Lisää uusi opettaja</a>
    
    <table>
        <thead>
            <tr>
                <th>Tunnusnumero</th>
                <th>Etunimi</th>
                <th>Sukunimi</th>
                <th>Aine</th>
                <th>Toiminnot</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['tunnusnumero']); ?></td>
                <td><?php echo htmlspecialchars($row['etunimi']); ?></td>
                <td><?php echo htmlspecialchars($row['sukunimi']); ?></td>
                <td><?php echo htmlspecialchars($row['aine']); ?></td>
                <td>
                    <a href="muokkaa_opettaja.php?id=<?php echo $row['id']; ?>">Muokkaa</a>
                    <a href="poista_opettaja.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Haluatko varmasti poistaa tämän opettajan?')">Poista</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
