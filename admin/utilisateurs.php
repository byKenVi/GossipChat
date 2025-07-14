<?php
require_once '../include/check_admin.php';
require_once '../include/database.php';

if (isset($_POST['supprimer'])) {
    $id = $_POST['id'];

    // Supprimer d'abord les messages de cet utilisateur
    $stmt = $pdo->prepare("DELETE FROM messages WHERE expediteur_id = ?");
    $stmt->execute([$id]);

    // Puis supprimer l'utilisateur
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
}

$users = $pdo->query("SELECT id, pseudo, email, role FROM utilisateurs")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Utilisateurs</title><link rel="stylesheet" href="../assets/style3.css"></head>
<body>
<h2>Liste des utilisateurs</h2>
<table border="1">
<tr><th>ID</th><th>Pseudo</th><th>Email</th><th>Rôle</th><th>Actions</th></tr>
<?php foreach ($users as $user): ?>
<tr>
  <td><?= $user['id'] ?></td>
  <td><?= htmlspecialchars($user['pseudo']) ?></td>
  <td><?= htmlspecialchars($user['email']) ?></td>
  <td><?= $user['role'] ?></td>
  <td>
    <form method="POST" style="display:inline;">
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      <button name="supprimer" onclick="return confirm('Supprimer ?')">Supprimer</button>
    </form>
  </td>
</tr>
<?php endforeach; ?>
</table>
<a href="dashboard.php">Retour</a>
</body>
</html>
