<?php
require_once '../include/database.php';
header('Content-Type: application/json');
session_start();

// Vérifie si l'utilisateur est bien connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Utilisateur non connecté']);
    exit;
}

$userId = intval($_SESSION['user_id']);
$postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;

if ($postId === 0) {
    echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
    exit;
}

try {
    // Vérifier si le like existe déjà
    $stmt = $pdo->prepare("SELECT id FROM likes WHERE article_id = ? AND utilisateur_id = ?");
    $stmt->execute([$postId, $userId]);

    if ($stmt->rowCount() > 0) {
        // Déjà liké ➔ on retire le like
        $pdo->prepare("DELETE FROM likes WHERE article_id = ? AND utilisateur_id = ?")->execute([$postId, $userId]);
        $action = 'unliked';
    } else {
        // Pas encore liké ➔ on ajoute le like
        $pdo->prepare("INSERT INTO likes (article_id, utilisateur_id, type) VALUES (?, ?, 'like')")->execute([$postId, $userId]);
        $action = 'liked';
    }

    // Compter le nombre total de likes
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE article_id = ?");
    $stmt->execute([$postId]);
    $likeCount = (int)$stmt->fetchColumn();

    // Réponse au format JSON
    echo json_encode([
        'success' => true,
        'action' => $action,
        'postId' => $postId,
        'likes' => $likeCount,
        'userId' => $userId
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
