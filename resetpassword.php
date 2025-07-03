

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Connexion - GossipChat</title>
  <link rel="stylesheet" href="assets/style.css" />
</head>
<body>

  <header>
    <a href="index.php">
      <img src="assets/images/logochat.png" alt="logo GossipChat" class="logo-pulse" style="width:56px; height:56px; margin:1rem;" />
    </a>
  </header>

  <main>
    <form id="formConnexion" class="fade-in"  onsubmit="return validateForm();" method="POST" action="include/traitement_resetpassword.php" novalidate>
      <h2>Modifier mot de passe </h2>
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required />

      

      <button type="submit">envoyer code</button>

      <div id="msgConnexion"></div>
    </form>