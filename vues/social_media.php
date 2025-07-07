<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>GossipChat - Accueil</title>
<link rel="stylesheet" href="../assets/style1.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
</head>
<body>

<div class="navbar">
  <div class="logo">GossipChat</div>
  <div class="search-bar">
    <input type="search" placeholder="Rechercher...">
  </div>
  <div class="icons">
    <svg class="icon-btn" id="msgIcon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-label="Messages" role="img" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
    </svg>
    <svg class="icon-btn" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-label="Menu" role="img" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="3" y1="12" x2="21" y2="12"/>
      <line x1="3" y1="6" x2="21" y2="6"/>
      <line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
    <svg class="icon-btn" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-label="Notifications" role="img" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
      <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
    </svg>
  </div>
</div>

<div class="main">
  <div class="sidebar">
    <div class="menu-item">
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 12l18 0" stroke="none"/></svg>
      <p>Home</p>
    </div>
    <div class="menu-item">
      <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
      <p>Amis</p>
    </div>
    <div class="menu-item">
      <svg viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="4" width="16" height="16"/></svg>
      <p>Souvenirs</p>
    </div>
    <!-- autres menu items ici -->
  </div>

  <div class="feed">
    <div class="post">
      <strong>POST2</strong>
      <p>Aujourd'hui</p>
      <img src="https://picsum.photos/600/300" alt="Post Image"/>
      <div class="actions">
        <div class="like" title="J'aime">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.74 0 3.41 1 4.5 2.09C12.09 5 13.76 4 15.5 4 18 4 20 6 20 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg> J'aime
        </div>
        <div class="commenter" title="Commenter">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 6h-18v12h18v-12zM19 8l-7 5-7-5V6l7 5 7-5v2z"/></svg> Commenter
        </div>
        <div class="share" title="Partager">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 8a3 3 0 1 1-3-3"/></svg> Partager
        </div>
      </div>
    </div>
  </div>

  <div class="messagerie-panel" id="messageriePanel" aria-hidden="true">
    <header>
      <h2>Messagerie</h2>
      <button id="closeMessagerie" aria-label="Fermer la messagerie">&times;</button>
    </header>
    <div class="messagerie-list">
      <div class="messagerie-item">Clément Bankole</div>
      <div class="messagerie-item">Rolland Rgp</div>
      <div class="messagerie-item">Aurel Oliveira</div>
      <div class="messagerie-item">Morel Morel</div>
    </div>
  </div>
</div>

<script>
  const msgIcon = document.getElementById('msgIcon');
  const messageriePanel = document.getElementById('messageriePanel');
  const closeBtn = document.getElementById('closeMessagerie');

  msgIcon.addEventListener('click', () => {
    messageriePanel.classList.add('open');
    messageriePanel.setAttribute('aria-hidden', 'false');
  });

  closeBtn.addEventListener('click', () => {
    messageriePanel.classList.remove('open');
    messageriePanel.setAttribute('aria-hidden', 'true');
  });

  // Optionnel: fermer messagerie en cliquant hors panneau
  window.addEventListener('click', (e) => {
    if (messageriePanel.classList.contains('open') && !messageriePanel.contains(e.target) && e.target !== msgIcon) {
      messageriePanel.classList.remove('open');
      messageriePanel.setAttribute('aria-hidden', 'true');
    }
  });
</script>

</body>
</html>
