<?php
// Récupère le nombre de likes pour le post 1
require_once '../include/database.php';
$postId = 1;
$stmt = $pdo->prepare("SELECT nombre_likes FROM articles WHERE id = ?");
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
      <img src="../img/home.png" alt="Accueil" title="Accueil" class="nav-img" />
      <img src="../img/message.png" alt="Messagerie" title="Messagerie" class="nav-img" id="msgIcon" />
      <img src="../img/notification.png" alt="Notifications" title="Notifications" class="nav-img" />
    </div>
  </div>

  <div class="content">
    <div class="sidebar">
      <div class="sidebar-item">
        <img src="../img/friends.png" alt="Amis" /> <span>Amis</span>
      </div>
      <div class="sidebar-item">
        <img src="../img/groups.png" alt="Groupes" /> <span>Groupes</span>
      </div>
      <div class="sidebar-item">
        <img src="../img/saved.png" alt="Sauvegardes" /> <span>Sauvegardes</span>
      </div>
      <div class="sidebar-item">
        <img src="../assets/images/profil.jpg" alt="Photo de profil" /> <span>Profil</span>
      </div>
    </div>
    <div class="feed">
            <div class="create-post">
        <div class="create-post-top">
          
            <img src="../assets/images/profil.jpg" alt="Photo de profil" />
          <input type="text" placeholder="Quoi de neuf, Kevin ?" />
        </div>
        <div class="create-post-options">
          <div class="create-post-option">
            <img src="../img/live.png" alt="Vidéo en direct" />
            <span>Vidéo en direct</span>
          </div>
          <div class="create-post-option">
            <img src="../img/photo.png" alt="Photo/vidéo" />
            <span>Photo/Vidéo</span>
          </div>
          <div class="create-post-option">
            <img src="../img/feeling.png" alt="Humeur/activité" />
            <span>Humeur/Activité</span>
          </div>
        </div>
      </div>
      <div class="stories">
        <div class="story">
          <img src="../img/story1.jpg" alt="Story 1" />
          <span>Toi</span>
        </div>
        <div class="story">
          <img src="../img/story2.jpg" alt="Story 2" />
          <span>Clara</span>
        </div>
        <div class="story">
          <img src="../img/story3.jpg" alt="Story 3" />
          <span>Marc</span>
        </div>
      </div>
      <div class="post">
        <div class="post-header">
          <strong>Clara</strong><br />Aujourd'hui
        </div>
        <img src="../img/post1.png" alt="Post image" class="post-img"  />
        <div class="post-actions">
          <button class="like-btn" data-postid="1" data-userid="2"><img src="../img/like.png" alt=""></button>
          <span id="likes-<?= $postId ?>"><?= $likes ?></span>
          <img src="../img/comment.png" alt="Comment" />
          <img src="../img/share.png" alt="Share" />

        </div>
        <form class="comment-form" data-postid="1" data-userid="123">
        <input type="text" placeholder="Écrire un commentaire..." />
        </form>
        <div class="comment-list" id="comments-1"></div>
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
