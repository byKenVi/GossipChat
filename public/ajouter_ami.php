<?php
session_start();
require_once '../include/database.php';

if (!isset($_SESSION['user_id'], $_POST['destinataire_id'])) exit;

$expediteur = $_SESSION['user_id'];
$destinataire = intval($_POST['destinataire_id']);

$stmt = $pdo->prepare("INSERT INTO amis (expediteur_id, destinataire_id, statut, date_invitation) VALUES (?, ?, 'en_attente', NOW())");
$stmt->execute([$expediteur, $destinataire]);

header("Location: amis.php");
exit;
?>