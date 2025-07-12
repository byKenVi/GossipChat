<?php
require_once '../include/database.php';
header('Content-Type: application/json');

$postId = isset($_POST['postId']) ? intval($_POST['postId']) : null;
$userId = isset($_POST['userId']) ? intval($_POST['userId']) : null;

if (!$postId || !$userId) {
    echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
    exit;
}

try {
    // Vérifie si l'utilisateur a déjà liké ce post
    $stmt = $pdo->prepare("SELECT id FROM likes WHERE article_id = ? AND utilisateur_id = ?");
    $stmt->execute([$postId, $userId]);

    if ($stmt->rowCount() > 0) {
        // UNLIKE
        $pdo->prepare("DELETE FROM likes WHERE article_id = ? AND utilisateur_id = ?")->execute([$postId, $userId]);
        $action = 'unliked';
    } else {
        // LIKE
        $pdo->prepare("INSERT INTO likes (article_id, utilisateur_id) VALUES (?, ?)")->execute([$postId, $userId]);
        $action = 'liked';
    }

    // Nombre total de likes du post
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE article_id = ?");
    $stmt->execute([$postId]);
    $likeCount = (int)$stmt->fetchColumn();

    echo json_encode([
        'success' => true,
        'action' => $action,
        'postId' => $postId,
        'likes' => $likeCount
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
