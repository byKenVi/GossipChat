<?php
header('Content-Type: application/json');
require_once '../include/database.php'; 

$postId = isset($_GET['postId']) ? intval($_GET['postId']) : 0;
if (!$postId) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("
  SELECT commentaires.contenu, utilisateurs.pseudo
  FROM commentaires
  JOIN utilisateurs ON utilisateurs.id = commentaires.utilisateur_id
  WHERE commentaires.article_id = ?
  ORDER BY commentaires.date_commentaire ASC
");
$stmt->execute([$postId]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

?>