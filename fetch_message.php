<?php
session_start();
require_once 'include/database.php';
$messages = $pdo->query("SELECT m.*, u.pseudo FROM messages m JOIN utilisateurs u ON m.user_id = u.id ORDER BY m.id DESC LIMIT 50")->fetchAll();
$messages = array_reverse($messages);
echo json_encode($messages);
?>