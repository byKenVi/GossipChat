<?php
session_start();
if (!isset($_SESSION['verified_email'])) {
    // Rediriger si l'email n’a pas été vérifié par le code
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inscription - GossipChat</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

  <header>
    <a href="index.php">
      <img src="assets/images/logochat.png" alt="logo GossipChat" class="logo-pulse" style="width:56px; height:56px; margin:1rem;" />
    </a>
  </header>


<h2>Réinitialiser votre mot de passe</h2>
<main>
    <form id="formConnexion" class="fade-in"  onsubmit="return validateForm()"action="include/traitement_change_password.php "method="POST">
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" name="new_password" id="new_password" required>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit">Changer le mot de passe</button>
    </form>
 <div id="msgConnexion"></div>
    </form>
  </main>


  <footer>
    © GossipChat - Tous droits réservés
  </footer>


  </body>
</html>