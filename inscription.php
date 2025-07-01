<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inscription - GossipChat</title>
  <link rel="stylesheet" href="assets/style.css" />
</head>
<body>

  <header>
    <a href="index.php">
      <img src="assets/images/logochat.png" alt="logo GossipChat" class="logo-pulse" style="width:56px; height:56px; margin:1rem;" />
    </a>
  </header>

  <main>
    <form id="formInscription" class="fade-in" method="POST" action="include/traitement_inscription.php" novalidate>
      <h2>Créer un compte</h2>

      <label for="nom">Nom</label>
      <input type="text" id="nom" name="nom" required />

      <label for="prenom">Prénom</label>
      <input type="text" id="prenom" name="prenom" required />

      <label for="username">Nom d'utilisateur</label>
      <input type="text" id="username" name="username" required />

      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" required />

      <label for="passwordConfirm">Confirmer le mot de passe</label>
      <input type="password" id="passwordConfirm" name="passwordConfirm" required />

      <button type="submit">S'inscrire</button>

      <div id="msgInscription"></div>
    </form>
  </main>

 <script>
document.getElementById('formInscription').addEventListener('submit', async function(e) {
  e.preventDefault();

  const form = e.target;
  const msg = document.getElementById('msgInscription');
  msg.textContent = '';
  msg.style.color = '';

  const mdp = form.password.value;
  const mdpConf = form.passwordConfirm.value;

  if (mdp !== mdpConf) {
    msg.textContent = "Les mots de passe ne correspondent pas.";
    msg.style.color = 'red';
    return;
  }

  try {
    const formData = new FormData(form);
    const response = await fetch('include/traitement_inscription.php', {
      method: 'POST',
      body: formData
    });

    const data = await response.json();

    if (!response.ok || !data.success) {
      msg.textContent = data.message || 'Erreur lors de l\'inscription.';
      msg.style.color = 'red';
      return;
    }

    msg.textContent = data.message;
    msg.style.color = 'green';

    setTimeout(() => {
      window.location.href = 'connexion.php';
    }, 1500);

  } catch (error) {
    msg.textContent = 'Erreur réseau, réessayez plus tard.';
    msg.style.color = 'red';
  }
});
</script>


  <footer>
    © GossipChat - Tous droits réservés
  </footer>

</body>
</html>
