<?php
include 'db.php';

$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Kurssit</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Kurssit</h1>
    <table>
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Kuvaus</th>
                <th>Alkupäivä</th>
                <th>Loppupäivä</th>
                <th>Opettaja</th>
                <th>Tila</th>
                <th>Opiskelijat</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td><?php echo $row['end_date']; ?></td>
                        <td><?php echo $row['teacher_name']; ?></td>
                        <td><?php echo $row['room_name']; ?></td>
                        <td><?php echo $row['student_count']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Ei kursseja</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>
