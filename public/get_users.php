<?php
session_start();
require_once '../include/database.php';

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'error' => 'Utilisateur non connecté']);
  exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id, pseudo FROM utilisateurs WHERE id != ?");
$stmt->execute([$userId]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'users' => $users]);
?>