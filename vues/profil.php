<?php
session_start();
require_once '../include/database.php';

// Message de succès (après modification par ex.)
if (isset($_SESSION['success_message'])) {
    echo '<p style="color:green; font-weight:bold;">' . htmlspecialchars($_SESSION['success_message']) . '</p>';
    unset($_SESSION['success_message']);
}

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit;
}

// Récupération des infos de l'utilisateur connecté
$sql = "SELECT nom, prenom, pseudo, email, photo_profil FROM utilisateurs WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GossipChat - Profil</title>
  <link rel="stylesheet" href="../assets/profil.css" />
</head>
<body>

  <!-- Barre de navigation -->
  <div class="navbar">
    <div class="logo">GossipChat</div>
    <div class="search-container">
      <input type="text" placeholder="Rechercher sur GossipChat..." />
    </div>
    <div class="nav-icons">
      <img src="../img/home.png" class="nav-img" />
      <img src="../img/message.png" class="nav-img" id="msgIcon" />
      <img src="../img/notification.png" class="nav-img" />
      <a href="../vues/profil.php">
        <img src="../img/profil.png" class="nav-img"/>
      </a>
    </div>
  </div>

  <!-- Contenu du profil -->
  <div class="profile-container">
    <div class="cover-photo"></div>

    <div class="profile-details">
      <div class="profile-pic">
        <img src="../img/<?= htmlspecialchars($user['photo_profil'] ?? 'default.jpg') ?>" alt="Photo de profil" style="width:100%; height:100%; border-radius:50%;" />
      </div>
      <div>
        <h2><?= htmlspecialchars($user['pseudo']) ?></h2>
        <p><?= htmlspecialchars($user['prenom'] . " " . $user['nom']) ?> - Développeur PHP</p>
        <p>Email : <?= htmlspecialchars($user['email']) ?></p>
      </div>
      <a href="../include/modifier_profil.php">
        <button class="add-friend-btn">Modifier le profil</button>
      </a>
    </div>

    <div class="profile-navigation">
      <ul>
        <li class="active">Publications</li>
        <li>À propos</li>
        <li>Amis</li>
        <li>Photos</li>
      </ul>
    </div>

    <div class="create-post">
      <div class="create-post-top">
        <div class="profile-pic small">
          <img src="../img/<?= htmlspecialchars($user['photo_profil'] ?? 'default.jpg') ?>" alt="Photo" style="width:100%; height:100%; border-radius:50%;" />
        </div>
        <form id="post-form" enctype="multipart/form-data" method="post" action="../include/traitement_post.php">
          <textarea name="description" placeholder="Exprime-toi..." required></textarea>
          <input type="file" name="media" accept="image/*,video/*" />
          <button type="submit">Publier</button>
        </form>
      </div>
    </div>

    <div class="posts-container">
      <p style="text-align:center;color:#aaa;">Les publications seront injectées ici par JS/PHP</p>
    </div>
  </div>

  <!-- <script src="../public/script.js"></script>
  <script src="../public/script_post.js"></script> -->
</body>
</html>
