<?php
header('Content-Type: application/json');
require_once '../include/database.php';

if (!isset($_POST['postId'], $_POST['userId'], $_POST['comment'])) {
  echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
  exit;
}

$postId = intval($_POST['postId']);
$userId = intval($_POST['userId']);
$comment = trim($_POST['comment']);

if ($postId === 0 || $userId === 0 || $comment === '') {
  echo json_encode(['success' => false, 'error' => 'Entrées invalides']);
  exit;
}

// Insertion dans la table commentaires
$stmt = $pdo->prepare("
  INSERT INTO commentaires (article_id, utilisateur_id, contenu, date_commentaire)
  VALUES (?, ?, ?, NOW())
");
$stmt->execute([$postId, $userId, $comment]);

// Récupérer le pseudo pour le retour
$userStmt = $pdo->prepare("SELECT pseudo FROM utilisateurs WHERE id = ?");
$userStmt->execute([$userId]);
$user = $userStmt->fetch();

echo json_encode([
  'success' => true,
  'postId' => $postId,
  'userId' => $userId,
  'comment' => $comment,
  'username' => $user['pseudo']
]);
?>