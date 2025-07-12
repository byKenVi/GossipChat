<?php
session_start();
require_once '../include/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Tous les utilisateurs sauf moi
$stmt = $pdo->prepare("SELECT id, pseudo FROM utilisateurs WHERE id != ?");
$stmt->execute([$userId]);
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Relations existantes
$relStmt = $pdo->prepare("
  SELECT * FROM amis
  WHERE (expediteur_id = :userId OR destinataire_id = :userId)
");
$relStmt->execute(['userId' => $userId]);
$relations = $relStmt->fetchAll(PDO::FETCH_ASSOC);

// Indexer les relations
$statuts = [];
foreach ($relations as $rel) {
    $autre = $rel['expediteur_id'] == $userId ? $rel['destinataire_id'] : $rel['expediteur_id'];
    $statuts[$autre] = [
        'statut' => $rel['statut'],
        'expediteur' => $rel['expediteur_id']
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des amis</title>
  <link rel="stylesheet" href="../assets/amis.css">
</head>
<body>
  <h2>Demandes d'amis reçues</h2>
  <ul class="amis-liste">
    <?php foreach ($statuts as $autreId => $info): ?>
      <?php if ($info['statut'] === 'en_attente' && $info['expediteur'] != $userId): ?>
        <li>
          <span>
            <?php
            $pseudoExp = '';
            foreach ($utilisateurs as $u) {
              if ($u['id'] == $autreId) {
                $pseudoExp = htmlspecialchars($u['pseudo']);
                break;
              }
            }
            echo $pseudoExp;
            ?>
          </span>
          <form method="POST" action="accepter_ami.php" style="display:inline;">
            <input type="hidden" name="expediteur_id" value="<?= $autreId ?>">
            <button type="submit">Accepter</button>
          </form>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>

  <h2>Tous les utilisateurs</h2>
  <ul class="amis-liste">
    <?php foreach ($utilisateurs as $u): ?>
      <li>
        <span><?= htmlspecialchars($u['pseudo']) ?></span>

        <?php if (!isset($statuts[$u['id']])): ?>
          <form action="ajouter_ami.php" method="POST" style="display:inline;">
            <input type="hidden" name="destinataire_id" value="<?= $u['id'] ?>">
            <button type="submit">Ajouter</button>
          </form>

        <?php elseif ($statuts[$u['id']]['statut'] === 'en_attente' && $statuts[$u['id']]['expediteur'] == $u['id']): ?>
          <form action="accepter_ami.php" method="POST" style="display:inline;">
            <input type="hidden" name="expediteur_id" value="<?= $u['id'] ?>">
            <button type="submit">Accepter</button>
          </form>

        <?php elseif ($statuts[$u['id']]['statut'] === 'accepte'): ?>
          <a href="javascript:void(0)" onclick="openChatWith(<?= $u['id'] ?>, '<?= addslashes($u['pseudo']) ?>')">Envoyer un Message</a>

        <?php else: ?>
          <span>Demande envoyée</span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<div class="chat-box" id="chatBox" style="display:none;">
  <div class="chat-header">
    Discussion avec <span id="chat-username">[Nom]</span>
    <button onclick="closeChat()">X</button>
  </div>
  <div class="chat-messages" id="chat-messages"></div>
  <div class="chat-input">
    <input type="text" id="chat-input" placeholder="Votre message...">
    <button onclick="sendMessage()">Envoyer</button>
  </div>
</div>

  <!-- Socket.IO + fonction de chat -->
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
  function closeChat() {
  document.getElementById("chatBox").style.display = "none";
}

  const socket = io("http://localhost:3000");
  const USER_ID = <?= json_encode($userId) ?>;
</script>
<script src="../public/messagerie.js"></script>


</body>
