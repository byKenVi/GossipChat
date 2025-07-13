<?php
require_once 'includes/check_admin.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin - Dashboard</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="sidebar">
  <h2>ADMIN</h2>
  <ul>
    <li><a href="dashboard.php">Tableau de bord</a></li>
    <li><a href="utilisateurs.php">Utilisateurs</a></li>
    <li><a href="publications.php">Publications</a></li>
    <li><a href="deconnexion.php">Déconnexion</a></li>
  </ul>
</div>
<div class="main">
  <div class="cards">
    <div class="card"><h4>Utilisateurs</h4><p><strong>1200</strong></p></div>
    <div class="card"><h4>Publications</h4><p><strong>3500</strong></p></div>
    <div class="card"><h4>Commentaires</h4><p><strong>9800</strong></p></div>
    <div class="card"><h4>Signalements</h4><p><strong>75</strong></p></div>
  </div>
</div>
</body>
</html>
