<?php
session_start();
require_once '../include/database.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit;
}

$userId = $_SESSION['user_id'];
$postId = 1; // à remplacer par une boucle de post dans un vrai fil d'actualité

// Nombre de likes sur le post
$stmt = $pdo->prepare("SELECT count(*) FROM likes WHERE article_id = ?");
$stmt->execute([$postId]);
$likes = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GossipChat - Accueil</title>
  <link rel="stylesheet" href="../assets/style1.css" />
</head>
<body>
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

  <div class="content">
    <div class="sidebar">
      <div class="sidebar-item"><img src="../img/friends.png" /><span>Amis</span></div>
      <div class="sidebar-item"><img src="../img/groups.png" /><span>Groupes</span></div>
      <div class="sidebar-item"><img src="../img/saved.png" /><span>Sauvegardes</span></div>
      <div class="sidebar-item"><img src="../assets/images/profil.jpg" /><span>Profil</span></div>
    </div>

    <div class="feed">
      <div class="create-post">
        <div class="create-post-top">
          <img src="../assets/images/profil.jpg" />
          <input type="text" placeholder="Quoi de neuf, Kevin ?" />
        </div>
        <div class="create-post-options">
          <div class="create-post-option"><img src="../img/live.png" /><span>Vidéo en direct</span></div>
          <div class="create-post-option"><img src="../img/photo.png" /><span>Photo/vidéo</span></div>
          <div class="create-post-option"><img src="../img/feeling.png" /><span>Humeur/Activité</span></div>
        </div>
      </div>

      <div class="stories">
        <div class="story"><img src="../img/story1.jpg" /><span>Toi</span></div>
        <div class="story"><img src="../img/story2.jpg" /><span>Clara</span></div>
        <div class="story"><img src="../img/story3.jpg" /><span>Marc</span></div>
      </div>

      <div class="post">
        <div class="post-header"><strong>Clara</strong><br />Aujourd'hui</div>
        <img src="../img/post1.png" class="post-img" />

        <div class="post-actions">
          <button class="like-btn" data-postid="<?= $postId ?>" data-userid="<?= $userId ?>">
            <img src="../img/like.png" alt="Like">
          </button>
          <span id="likes-<?= $postId ?>"><?= $likes ?></span>
          <img src="../img/comment.png" alt="Comment" class="comment-icon" data-postid="<?= $postId ?>" data-userid="<?= $userId ?>" style="cursor:pointer; width:24px;" />
          <img src="../img/share.png" alt="Share" class="comment-icon" data-postid="<?= $postId ?>" data-userid="<?= $userId ?>" style="cursor:pointer; width:24px;" />
        </div>

          <div id="comment-popup" style="display:none;">
      <div class="popup-overlay" onclick="closeCommentPopup()"></div>
      <div class="popup-content">
        <h3>Commentaires</h3>
        <div id="comment-list" class="comment-list"></div>
        <input type="text" id="comment-input" placeholder="Votre commentaire...">
        <div class="comment-actions">
          <button id="submit-comment">Envoyer</button>
          <button onclick="closeCommentPopup()">Fermer</button>
        </div>
      </div>
    </div>

      </div>
    </div>

    <div class="messagerie" id="messageriePanel">
      <div class="messagerie-header">
        <span>Messagerie</span>
        <button id="closeMsg">&times;</button>
      </div>
      <div class="messagerie-body">
        <div class="message-user">Rolland Rgp</div>
        <div class="message-user">Clément Bankole</div>
        <div class="message-user">Aurel Oliveira</div>
      </div>
    </div>

    <script>
      document.getElementById('msgIcon').addEventListener('click', () => {
        document.getElementById('messageriePanel').style.right = '0';
      });
      document.getElementById('closeMsg').addEventListener('click', () => {
        document.getElementById('messageriePanel').style.right = '-300px';
      });
    </script>

    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <script src="../public/script.js"></script>
</body>
</html>
