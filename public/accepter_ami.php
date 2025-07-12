<?php
session_start();
require_once '../include/database.php';

if (!isset($_SESSION['user_id'], $_POST['expediteur_id'])) exit;

$destinataire = $_SESSION['user_id'];
$expediteur = intval($_POST['expediteur_id']);

$stmt = $pdo->prepare("UPDATE amis SET statut = 'accepte' WHERE expediteur_id = ? AND destinataire_id = ?");
$stmt->execute([$expediteur, $destinataire]);

header("Location: amis.php");
exit;
