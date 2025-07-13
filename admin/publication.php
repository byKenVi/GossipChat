<?php
require_once 'includes/check_admin.php';
require_once '../include/database.php';
$posts = $pdo->query("SELECT * FROM publications ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Publications</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h3>Publications</h3>
<?php foreach ($posts as $post): ?>
  <div class="post-item">
    <strong><?= htmlspecialchars($post['titre']) ?></strong>
    <p><?= htmlspecialchars($post['contenu']) ?></p>
    <form method="POST" action="supprimer_publication.php">
      <input type="hidden" name="id" value="<?= $post['id'] ?>">
      <button class="btn btn-danger">Supprimer</button>
    </form>
  </div>
<?php endforeach; ?>
</body>
</html>

// admin/supprimer_publication.php
<?php
require_once 'includes/check_admin.php';
require_once '../include/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $stmt = $pdo->prepare("DELETE FROM publications WHERE id = ?");
  $stmt->execute([$id]);
  header('Location: publications.php');
  exit;
}
?>