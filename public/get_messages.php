<?php
session_start();
require_once '../include/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Non connecté']);
    exit;
}

$expediteur_id = $_SESSION['user_id'];
$destinataire_id = intval($_GET['destinataire_id'] ?? 0);

if ($destinataire_id === 0) {
    echo json_encode(['success' => false, 'error' => 'Destinataire manquant']);
    exit;
}

$stmt = $pdo->prepare("
  SELECT m.*, u.pseudo AS expediteur_pseudo
  FROM messages m
  JOIN utilisateurs u ON m.expediteur_id = u.id
  WHERE (m.expediteur_id = ? AND m.destinataire_id = ?)
     OR (m.expediteur_id = ? AND m.destinataire_id = ?)
  ORDER BY m.date_envoi ASC
");

$stmt->execute([$expediteur_id, $destinataire_id, $destinataire_id, $expediteur_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'messages' => $messages]);
