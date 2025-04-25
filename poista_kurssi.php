<?php
include 'db.php';
session_start();

try {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if (!$id) {
        throw new Exception("ID puuttuu");
    }

    $conn->beginTransaction();

    $check_sql = "SELECT id FROM kurssit WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([$id]);
    
    if (!$check_stmt->fetch()) {
        throw new Exception("Kurssia ei löydy");
    }

    $sql_kirjautumiset = "DELETE FROM kurssikirjautumiset WHERE kurssi_id = ?";
    $stmt_kirjautumiset = $conn->prepare($sql_kirjautumiset);
    $stmt_kirjautumiset->execute([$id]);

    $sql_kurssi = "DELETE FROM kurssit WHERE id = ?";
    $stmt_kurssi = $conn->prepare($sql_kurssi);
    $stmt_kurssi->execute([$id]);

    $conn->commit();
    $_SESSION['success'] = "Kurssi poistettu onnistuneesti";

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    $_SESSION['error'] = "Virhe: " . $e->getMessage();
}

header("Location: kurssit.php");
exit();
?>
