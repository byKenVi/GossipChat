<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: connexion.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>GossipChat - Chat</title>
  <link rel="stylesheet" href="assets/chat.css">
</head>
<body>
<div class="chat-container">
  <div class="chat-box" id="chatBox"></div>
  <form id="chatForm">
    <input type="text" id="message" placeholder="Écrivez un message..." autocomplete="off" required>
    <button type="submit">Envoyer</button>
  </form>
</div>
<script src="assets/chat.js"></script>
</body>
</html>
