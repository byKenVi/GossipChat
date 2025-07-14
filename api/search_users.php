<?php
require_once '../include/database.php';
header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');

if (strlen($q) < 2) {
    echo json_encode(['error' => 'Requête trop courte']);
    exit;
}

// Recherche sur nom, prénom, email, pseudo
$stmt = $pdo->prepare("
    SELECT id, nom, prenom, email
    FROM utilisateurs
    WHERE nom LIKE :q OR prenom LIKE :q OR email LIKE :q OR pseudo LIKE :q
    LIMIT 10
");
$stmt->execute(['q' => "%$q%"]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['results' => $results]);
