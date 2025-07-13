<?php
session_start();
if (!isset($_SESSION['user_id'])) exit;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <input type="text" id="search" placeholder="Rechercher un utilisateur...">
  <div id="results"></div>
  <script src="assets/recherche.js"></script>
</body>
</html>