<?php
require_once '../include/database.php';

header('Content-Type: application/json');

// Récupération sécurisée
$postId = isset($_POST['postId']) ? intval($_POST['postId']) : null;
$userId = isset($_POST['userId']) ? intval($_POST['userId']) : null;

// Vérification des paramètres
if (!$postId || !$userId) {
    echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
    exit;
}

try {
    // Vérifie si l'utilisateur a déjà liké ce post
    $check = $pdo->prepare("SELECT id FROM likes WHERE article_id = ? AND utilisateur_id = ?");
    $check->execute([$postId, $userId]);

    if ($check->rowCount() > 0) {
        // Déjà liké : on supprime (unlike)
        $pdo->prepare("DELETE FROM likes WHERE article_id = ? AND utilisateur_id = ?")->execute([$postId, $userId]);
    } else {
        // Nouveau like
        $pdo->prepare("INSERT INTO likes (article_id, utilisateur_id) VALUES (?, ?)")->execute([$postId, $userId]);
    }

    // Récupérer le nombre de likes
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE article_id = ?");
    $stmt->execute([$postId]);
    $likes = (int)$stmt->fetchColumn();

    // Mise à jour du compteur dans la table articles (facultatif)
    $pdo->prepare("UPDATE articles SET nombre_likes = ? WHERE id = ?")->execute([$likes, $postId]);

    // Réponse unique
    echo json_encode([
        'success' => true,
        'postId' => $postId,
        'likes' => $likes
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
