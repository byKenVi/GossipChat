<?php
require_once '../include/database.php';
header('Content-Type: application/json');

session_start();
$userId = $_SESSION['user_id'] ?? null;

$stmt = $pdo->query("
  SELECT a.*, u.pseudo AS username,
    (SELECT COUNT(*) FROM likes WHERE article_id = a.id) AS like_count
  FROM articles a
  JOIN utilisateurs u ON a.utilisateur_id = u.id
  ORDER BY a.date_publication DESC
");

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
  'success' => true,
  'posts' => $posts
]);
?>
