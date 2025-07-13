<?php
require_once '../include/database.php';
session_start();

header('Content-Type: application/json');

$postId = isset($_GET['postId']) ? intval($_GET['postId']) : null;
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

if (!$postId || !$userId) {
    echo json_encode(['success' => false, 'error' => 'Paramètre(s) manquant(s)']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE article_id = ?");
    $stmt->execute([$postId]);
    $likeCount = (int)$stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE article_id = ? AND utilisateur_id = ?");
    $stmt->execute([$postId, $userId]);
    $hasLiked = $stmt->fetchColumn() > 0;

    echo json_encode([
        'success' => true,
        'postId' => $postId,
        'likes' => $likeCount,
        'hasLiked' => $hasLiked
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>