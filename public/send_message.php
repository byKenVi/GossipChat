<?php
session_start();
require_once '../include/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Non connecté']);
    exit;
}

$expediteur_id = $_SESSION['user_id'];
$destinataire_id = intval($_POST['destinataire_id'] ?? 0);
$contenu = trim($_POST['contenu'] ?? '');

if ($destinataire_id === 0 || $contenu === '') {
    echo json_encode(['success' => false, 'error' => 'Champs manquants']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO messages (expediteur_id, destinataire_id, contenu, date_envoi) VALUES (?, ?, ?, NOW())");
$stmt->execute([$expediteur_id, $destinataire_id, $contenu]);

$userStmt = $pdo->prepare("SELECT pseudo FROM utilisateurs WHERE id = ?");
$userStmt->execute([$expediteur_id]);
$pseudo = $userStmt->fetchColumn();

echo json_encode([
    'success' => true,
    'expediteur_id' => $expediteur_id,
    'destinataire_id' => $destinataire_id,
    'contenu' => htmlspecialchars($contenu),
    'pseudo' => $pseudo,
    'date' => date('Y-m-d H:i:s')
]);

