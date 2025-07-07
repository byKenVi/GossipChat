<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../include/database.php'; 

$postId = $_POST['postId'] ?? null;
$userId = $_POST['userId'] ?? null;

if (!$postId || !$userId) {
    echo json_encode(['error' => 'Missing postId or userId']);
    exit;
}
// Vérifie si l'utilisateur a déjà liké (optionnel)
// $alreadyLiked = ... (requête SQL)

// Incrémente le compteur de likes
$sql = "UPDATE articles SET nombre_likes = nombre_likes + 1 WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$postId]);

// Récupère le nouveau nombre de likes
$sql = "SELECT nombre_likes FROM articles WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$postId]);
$likes = $stmt->fetchColumn();

echo json_encode(['likes' => $likes]);