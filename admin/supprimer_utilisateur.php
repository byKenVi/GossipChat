<?php
require_once 'includes/check_admin.php';
require_once '../include/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
  $stmt->execute([$id]);
  header('Location: utilisateurs.php');
  exit;
}
?>