<?php
require_once '../include/database.php';
header('Content-Type: application/json');

$posts = $pdo->query("SELECT a.*, u.pseudo FROM articles a JOIN utilisateurs u ON u.id = a.utilisateur_id ORDER BY date_publication DESC")->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($posts);
