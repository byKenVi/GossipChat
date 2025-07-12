<?php
session_start();
require_once '../include/database.php';
header('Content-Type: application/json');

$postId = isset($_GET['postId']) ? intval($_GET['postId']) : 0;

if ($postId === 0) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("
  SELECT c.contenu, u.pseudo
  FROM commentaires c
  JOIN utilisateurs u ON c.utilisateur_id = u.id
  WHERE c.article_id = ?
  ORDER BY c.date_commentaire ASC
");
$stmt->execute([$postId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($comments);
?>
