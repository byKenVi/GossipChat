<?php
session_start();
require_once '../include/database.php';

$sql = "SELECT nom, prenom, pseudo, email, photo_profil FROM utilisateurs WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil - GossipChat</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
<header>
  <a href="index.php">
    <img src="../assets/images/logochat.png" alt="logo GossipChat" class="logo-pulse" style="width:56px; height:56px; margin:1rem;" />
  </a>
</header>

<form method="POST" action="../include/traitement_modifier_profil.php" enctype="multipart/form-data">
  <h2>Modifier profil</h2>

  <label for="pseudo">Pseudo</label>
  <input type="text" name="pseudo" value="<?= htmlspecialchars($user['pseudo']) ?>" required>

  <label for="password">mot de passe</label>
  <input type="password" name="password">

  <label for="photo_profil">Photo de profil</label><br>
  <img src="../img/<?= htmlspecialchars($user['photo_profil'] ?? 'default.jpg') ?>" alt="Photo de profil" width="100"><br>
  <input type="file" name="photo_profil">

  <button type="submit">Enregistrer</button>
</form>
</body>
</html>
