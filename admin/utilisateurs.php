<?php
require_once 'includes/check_admin.php';
require_once '../include/database.php';
$users = $pdo->query("SELECT * FROM utilisateurs")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Utilisateurs</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h3>Liste des utilisateurs</h3>
<?php foreach ($users as $user): ?>
  <div class="user-item">
    <strong><?= htmlspecialchars($user['pseudo']) ?></strong> (<?= $user['role'] ?>)
    <form method="POST" action="modifier_role.php" style="display:inline">
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      <select name="role">
        <option value="user">User</option>
        <option value="moderateur">Modérateur</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit">Changer</button>
    </form>
    <form method="POST" action="supprimer_utilisateur.php" style="display:inline" onsubmit="return confirm('Supprimer cet utilisateur ?')">
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      <button class="btn btn-danger">Supprimer</button>
    </form>
  </div>
<?php endforeach; ?>
</body>
</html>