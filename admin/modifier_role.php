<?php
require_once '../include/database.php';
require_once 'includes/check_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Afficher formulaire modification rôle
    $userId = $_GET['id'] ?? null;
    if (!$userId || !is_numeric($userId)) {
        header('Location: dashboard.php?error=ID utilisateur invalide');
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, pseudo, role FROM utilisateurs WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: dashboard.php?error=Utilisateur introuvable');
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
      <meta charset="UTF-8" />
      <title>Modifier rôle - Admin</title>
      <link rel="stylesheet" href="../assets/style.css" />
    </head>
    <body>
      <h2>Modifier rôle de <?= htmlspecialchars($user['pseudo']); ?></h2>
      <form method="POST" action="modifier_role.php">
        <input type="hidden" name="id" value="<?= $user['id']; ?>" />
        <label for="role">Rôle :</label>
        <select name="role" id="role" required>
          <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
          <option value="moderateur" <?= $user['role'] === 'moderateur' ? 'selected' : ''; ?>>Modérateur</option>
          <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
        </select>
        <button type="submit">Modifier</button>
      </form>
      <p><a href="dashboard.php">Retour au dashboard</a></p>
    </body>
    </html>

    <?php
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement modification rôle
    $userId = $_POST['id'] ?? null;
    $newRole = $_POST['role'] ?? null;

    $validRoles = ['user', 'moderateur', 'admin'];

    if (!$userId || !is_numeric($userId) || !in_array($newRole, $validRoles)) {
        header('Location: dashboard.php?error=Données invalides');
        exit;
    }

    $stmt = $pdo->prepare("UPDATE utilisateurs SET role = ? WHERE id = ?");
    $stmt->execute([$newRole, $userId]);

    $_SESSION['success_message'] = "Rôle modifié avec succès.";
    header('Location: dashboard.php');
    exit;
} else {
    header('Location: dashboard.php');
    exit;
}
