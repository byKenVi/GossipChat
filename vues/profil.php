
<?php
session_start();
if (isset($_SESSION['success_message'])) {
    echo '<p style="color:green; font-weight:bold;">' . htmlspecialchars($_SESSION['success_message']) . '</p>';
    unset($_SESSION['success_message']); // Pour afficher le message une seule fois
}
require_once '../include/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit;
}
$sql = "SELECT nom, prenom, pseudo, email, photo_profil FROM utilisateurs WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}
?>

<!-- 4. Affichage HTML -->
<!DOCTYPE html>
<html lang="fr">
 <head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>profil - GossipChat</title>
   <link rel="stylesheet" href="../assets/style.css" />
 </head>
<body>
  <header>
    <a href="index.php">
      <img src="../assets/images/logochat.png" alt="logo GossipChat" class="logo-pulse" style="width:56px; height:56px; margin:1rem;" />
    </a>
  </header>

       <h2>Mon profil</h2>
<table >
  <tr>
    <td>Photo de profil :</td>
    <td>
      <img src="../img/<?= htmlspecialchars($user['photo_profil'] ?? 'default.jpg') ?>" alt="Photo" width="120" />
    </td>
  </tr>
    
  <tr>
    <td>Pseudo :</td>
    <td><?= htmlspecialchars($user['pseudo']) ?></td>
  </tr>
  <tr>
    <td>Email :</td>
    <td><?= htmlspecialchars($user['email']) ?></td>
  </tr>
</table>
  <a href="../include/modifier_profil.php">
    <button type="submit">Modifier profil</button>
 </a>
<footer>
    © GossipChat - Tous droits réservés
  </footer>