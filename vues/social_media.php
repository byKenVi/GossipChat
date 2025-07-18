<?php
session_start();
require_once '../include/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Récupère les infos de l'utilisateur
$stmt = $pdo->prepare("SELECT pseudo, photo_profil, role FROM utilisateurs WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
$role = $user['role'] ?? 'utilisateur';

// Récupère les autres utilisateurs pour la messagerie
$stmt = $pdo->prepare("SELECT id, pseudo FROM utilisateurs WHERE id != ?");
$stmt->execute([$userId]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GossipChat - Accueil</title>
  <link rel="icon" type="image/png" href="../assets/images/logochat.png" />
  <link rel="stylesheet" href="../assets/style1.css" />
  <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
</head>
<body>
  <div id="main-content">
    <div class="navbar">
      <div class="logo">GossipChat</div>
      <div class="search-container">
        <input type="text" id="searchInput" placeholder="Rechercher sur GossipChat..." autocomplete="off" />
        <div id="searchResults" class="search-results"></div>
      </div>
      <div class="nav-icons">
        <img src="../img/home.png" class="nav-img" alt="Accueil" />
        <img src="../img/message.png" class="nav-img" id="msgIcon" alt="Messages" />
        <div class="notification-container">
          <img src="../img/notification.png" class="nav-img" id="notifIcon" alt="Notifications" />
          <span id="notifCount" class="notif-badge">0</span>
          <div id="notifMenu" class="notif-menu">
            <p>Aucune notification</p>
          </div>
        </div>
        <a href="../vues/profil.php"><img src="../img/profil.png" class="nav-img" alt="Profil" /></a>
      </div>
    </div>

    <div class="content">
      <div class="sidebar">
        <div class="sidebar-item">
          <img src="../img/friends.png" alt="Amis" />
          <span><button class="switch-page" data-page="../public/amis.php">Amis</button></span>
        </div>
        <br /><br />
        <div class="sidebar-item">
          <img src="../img/<?= htmlspecialchars($user['photo_profil'] ?? 'default.jpg') ?>" alt="Profil" />
          <span><a href="../vues/profil.php">Profil</a></span>
        </div>
        <br /><br />
        <br /><br />
        <div class="sidebar-item">
          <img src="../img/logout.png" alt="Déconnexion" />
          <span><a href="../include/deconnexion.php">Déconnexion</a></span>
        </div>
      </div>

      <div class="feed">
        <div class="create-post">
          <div class="create-post-top">
            <img src="../img/<?= htmlspecialchars($user['photo_profil'] ?? 'default.jpg') ?>" alt="Photo profil" />
            <form id="post-form" enctype="multipart/form-data">
              <textarea name="description" placeholder="Exprime-toi, <?= htmlspecialchars($user['pseudo']) ?>..." required></textarea>
              <input type="file" name="media" accept="image/*,video/*" />
              <button type="submit">Publier</button>
            </form>
          </div>
        </div>
        <div class="posts-container" id="posts-container"></div>
      </div>
    </div>

    <div class="messagerie" id="messageriePanel">
      <div class="messagerie-header">
        <span>Messagerie</span>
        <button id="closeMsg">&times;</button>
      </div>
      <div class="messagerie-body">
        <?php foreach ($users as $u): ?>
          <div class="message-user" onclick="openChatWith(<?= $u['id'] ?>, '<?= htmlspecialchars($u['pseudo']) ?>')">
            <?= htmlspecialchars($u['pseudo']) ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Popup Commentaire -->
  <div id="comment-popup" style="display: none;">
    <div class="popup-overlay" onclick="closeCommentPopup()"></div>
    <div class="popup-content">
      <h3>Commentaires</h3>
      <div id="comment-list" class="comment-list"></div>
      <input type="text" id="comment-input" placeholder="Votre commentaire..." />
      <div class="comment-actions">
        <button id="submit-comment">Envoyer</button>
        <button onclick="closeCommentPopup()">Fermer</button>
      </div>
    </div>
  </div>

  <script>
    const socket = io("http://localhost:3000");
    const USER_ID = <?= json_encode($userId) ?>;

    document.getElementById('msgIcon').addEventListener('click', () => {
      document.getElementById('messageriePanel').style.right = '0';
    });
    document.getElementById('closeMsg').addEventListener('click', () => {
      document.getElementById('messageriePanel').style.right = '-300px';
    });

    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    let timeout = null;

    searchInput.addEventListener('input', () => {
      clearTimeout(timeout);
      const query = searchInput.value.trim();

      if (query.length < 2) {
        searchResults.innerHTML = '';
        searchResults.style.display = 'none';
        return;
      }

      timeout = setTimeout(() => {
        fetch(`../api/search_users.php?q=${encodeURIComponent(query)}`)
          .then(res => res.json())
          .then(data => {
            if (data.error) {
              searchResults.innerHTML = `<div class="no-results">${data.error}</div>`;
            } else if (data.results.length === 0) {
              searchResults.innerHTML = `<div class="no-results">Aucun utilisateur trouvé</div>`;
            } else {
              searchResults.innerHTML = data.results.map(user => `
                <div class="search-result-item" onclick="goToProfile(${user.id})">
                  <strong>${user.prenom} ${user.nom}</strong><br>
                  <small>${user.email}</small>
                </div>
              `).join('');
            }
            searchResults.style.display = 'block';
          })
          .catch(() => {
            searchResults.innerHTML = `<div class="no-results">Erreur de recherche</div>`;
            searchResults.style.display = 'block';
          });
      }, 300);
    });

    function goToProfile(userId) {
      window.location.href = `../vues/profil.php?id=${userId}`;
    }

    document.addEventListener('click', (e) => {
      if (!searchResults.contains(e.target) && e.target !== searchInput) {
        searchResults.style.display = 'none';
      }
    });

    function openChatWith(userId, username) {
      // Ici tu dois afficher la fenêtre chat (à implémenter)
      // Par exemple :
      alert(`Ouvrir chat avec ${username} (ID: ${userId})`);
      // Ou afficher un div chat personnalisé si tu en as un
    }

    document.querySelectorAll('.switch-page').forEach(button => {
      button.addEventListener('click', function () {
        const pageUrl = this.getAttribute('data-page');
        fetch(pageUrl)
          .then(response => response.text())
          .then(html => {
            document.getElementById('main-content').innerHTML = html;
            window.history.pushState({}, '', pageUrl);
          })
          .catch(err => console.error('Erreur de chargement de la page', err));
      });
    });

    // Gestion du retour arrière du navigateur
    window.addEventListener('popstate', () => {
      location.reload();
    });
  </script>
  <script src="../public/script.js"></script>
  <script src="../public/messagerie.js"></script>
</body>
</html>
