<?php
require_once '../include/database.php';
$term = '%' . ($_GET['q'] ?? '') . '%';
$stmt = $pdo->prepare("SELECT pseudo, nom, prenom, email FROM utilisateurs WHERE pseudo LIKE ? OR nom LIKE ? OR prenom LIKE ? OR email LIKE ? LIMIT 10");
$stmt->execute([$term, $term, $term, $term]);
echo json_encode($stmt->fetchAll());
?>