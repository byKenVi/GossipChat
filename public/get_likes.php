<?php
require_once '../include/database.php';
header('Content-Type: application/json');

$postId = isset($_GET['postId']) ? intval($_GET['postId']) : null;

if (!$postId) {
    echo json_encode(['success' => false, 'error' => 'Paramètre postId manquant']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE article_id = ?");
    $stmt->execute([$postId]);
    $likeCount = (int)$stmt->fetchColumn();

    echo json_encode(['success' => true, 'likes' => $likeCount, 'postId' => $postId]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>