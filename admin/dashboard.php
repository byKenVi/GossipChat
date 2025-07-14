<?php
require_once '../include/check_admin.php';
require_once '../include/database.php';

$nbUsers = $pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();
$nbPosts = $pdo->query("SELECT COUNT(*) FROM publications")->fetchColumn();
$nbReports = $pdo->query("SELECT COUNT(*) FROM signalements")->fetchColumn();
?>
<!DOCTYPE html>
<html><head><title>Dashboard</title><link rel="stylesheet" href="../assets/style2.css"></head><body>
<h1>Dashboard</h1>
<ul>
  <li>Utilisateurs : <?= $nbUsers ?></li>
  <li>Publications : <?= $nbPosts ?></li>
  <li>Signalements : <?= $nbReports ?></li>
</ul>
<nav>
  <a href="utilisateurs.php">Utilisateurs</a> |
  <a href="publications.php">Signalements</a> |
  <a href="logout.php">Déconnexion</a>
</nav>
</body></html>