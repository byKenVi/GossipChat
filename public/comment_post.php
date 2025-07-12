<?php
session_start();
require_once '../include/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Non connecté']);
    exit;
}

$postId = intval($_POST['postId'] ?? 0);
$comment = trim($_POST['comment'] ?? '');
$userId = intval($_SESSION['user_id']);

if ($postId === 0 || $comment === '') {
    echo json_encode(['success' => false, 'error' => 'Champs manquants']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO commentaires (article_id, utilisateur_id, contenu, date_commentaire) VALUES (?, ?, ?, NOW())");
$stmt->execute([$postId, $userId, $comment]);

$userStmt = $pdo->prepare("SELECT pseudo FROM utilisateurs WHERE id = ?");
$userStmt->execute([$userId]);
$username = $userStmt->fetchColumn();

echo json_encode([
    'success' => true,
    'postId' => $postId,
    'comment' => htmlspecialchars($comment),
    'username' => $username
]);
?>
