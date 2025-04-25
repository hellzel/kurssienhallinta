<?php
include 'db.php';

try {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if (!$id) {
        throw new Exception("ID puuttuu");
    }

    $conn->beginTransaction();

    // Check if room is in use
    $check_usage = "SELECT COUNT(*) as count FROM kurssit WHERE tila_id = ?";
    $check_stmt = $conn->prepare($check_usage);
    $check_stmt->execute([$id]);
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        throw new Exception("Tilaa ei voi poistaa, koska se on käytössä kursseilla");
    }

    // Delete the room
    $sql = "DELETE FROM tilat WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    $conn->commit();
    $_SESSION['success'] = "Tila poistettu onnistuneesti";

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    $_SESSION['error'] = "Virhe: " . $e->getMessage();
}

header("Location: tilat.php");
exit();
?>
