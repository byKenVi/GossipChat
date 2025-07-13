<?php
session_start();
$stmt = $pdo->prepare("INSERT INTO messages (expediteur_id, destinataire_id, contenu) VALUES (?, ?, ?)");
$stmt->execute([$expediteur_id, $destinataire_id, $contenu]);
?>