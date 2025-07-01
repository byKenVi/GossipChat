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
    <form id="formConnexion" class="fade-in"  onsubmit="return validateForm();" method="POST" action="include/traitement_connexion.php" novalidate>
      <h2>Connexion</h2>
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required />

      <label for="motdepasse">Mot de passe</label>
      <input type="password" id="motdepasse" name="motdepasse" required />

      <button type="submit">Se connecter</button>

      <div id="msgConnexion"></div>
    </form>
    <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a></p>
      <?php
    if (isset($_GET['error'])) {
        echo '<p style="color:red; margin-top:10px;">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?></p>
  </main>

  <script>
  function validateForm() {
    const email = document.getElementById('email').value.trim();
    const pass = document.getElementById('motdepasse').value;

    if (!email) {
      alert("Veuillez saisir un email.");
      return false;
    }
    if (!pass) {
      alert("Veuillez saisir un mot de passe.");
      return false;
    }
    return true; // submit se fera normalement
  }
</script>

</body>
</html>
 