<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amis</title>
     <link rel="icon" type="image/png" href="../assets/images/logochat.png">
  <link rel="stylesheet" href="../assets/style1.css" />
  <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
</head>
<body>
   
  <div class="search-container">
    <input type="text" id="searchInput" placeholder="Rechercher sur GossipChat..." autocomplete="off" />
    <div id="searchResults" class="search-results"></div>
  </div>
  <div class="nav-icons">
    <a href="../vues/social_media.php"><img src="../img/home.png" class="nav-img" /></a>
    <img src="../img/message.png" class="nav-img" id="msgIcon" />
    <img src="../img/notification.png" class="nav-img" />
    <a href="../vues/profil.php"><img src="../img/profil.png" class="nav-img" /></a>
  </div>
  
</body>
</html>
