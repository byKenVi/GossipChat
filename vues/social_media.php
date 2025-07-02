<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion.php');
    exit;
}
$pseudo = htmlspecialchars($_SESSION['user_pseudo']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/style1.css">
</head>
<body>
  <div class="navbar">
    <div class="logo">Gossip Chat</div>
    <div class="center-bar">
    <input type="text" class="search-bar" placeholder="Rechercher...">
    <div class="nav-links">
     <p>Bonjour</p>
     <p>bonsoir</p>
    </div>
    </div>
    <div class="nav-right">
    <div class="icons">
       <img src="assets/images/message1.png" alt="">
      </div>
        <div class="icons">
      <img src="assets/images/menu.png" alt="menu">
    </div>
    <div class="icons"><img src="assets/images/notification.png" alt=></div>
  </div>
  </div>

  <!-- CORPS PRINCIPAL -->
  <div class="main">

    <!-- MENU GAUCHE -->
    <div class="sidebar">
      <div class="menu-item"><img src="assets/images/home (2).png" alt=""><p>Home</p> </div>
      <div class="menu-item"><img src="assets/images/amis (2).png" alt=""><p>Amis</p></div>
      <div class="menu-item"><img src="assets/images/souvenirs.png" alt=""><p>Souvenirs</p></div>
      <div class="menu-item"><img src="assets/images/enregistrer.png" alt=""><p>Enregistrer</p></div>
      <div class="menu-item"><img src="assets/images/groupe.png" alt=""><p>Groupe</p></div>
      <div class="menu-item"><img src="assets/images/live.png" alt=""><p>Réels</p></div>
      <div class="menu-item"><img src="assets/images/marketplace (2).png" alt=""><p>Marketplace</p></div>
      <div class="menu-item"><img src="assets/images/publicité.png" alt=""><p>Gestionnaire de publicités</p></div>
    </div>

    <!-- ZONE CENTRALE -->
    <div class="feed">
      <div class="post">
        <strong>POST2</strong> 
        <p>Aujourdh'hui</p>
        <img src="" alt="post image">
        <div class="actions">
          <div class="like"><img src="assets/images/like.png" alt=""> <p>j'aime</p></div>
          <div class="commenter"><img src="assets/images/commentaire.png" alt=""><p>comenter</p></div>
          <div class="share"><img src="assets/images/partager.png" alt=""><p>partager</p></div>
      </div>
    </div>
    </div>

    <!-- CONTACTS À DROITE -->
    <div class="contacts">
      <div><strong>Invitations</strong></div>
      <br> 
      <div class="contact">Supprimer</div>
      <br>
      <div><strong>Contacts</strong></div>
      <br>
      <div class="contact">Clément Bankole</div>
      <div class="contact">Rolland Rgp</div>
      <div class="contact">Aurel Oliveira</div>
      <div class="contact">Morel Morel</div>
      <div class="contact">Spry Riche</div>
      <div class="contact">It’z Grido</div>
      <div class="contact">Noé Nosme</div>
    </div>

    
  
</body>
</html>
