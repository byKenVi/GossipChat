<?php
require_once '../include/database.php';

if (!isset($_GET['q'])) {
    echo json_encode([]);
    exit;
}

$q = '%' . $_GET['q'] . '%';

$stmt = $pdo->prepare("SELECT id, pseudo FROM utilisateurs WHERE pseudo LIKE ? OR email LIKE ?");
$stmt->execute([$q, $q]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($results);
?>