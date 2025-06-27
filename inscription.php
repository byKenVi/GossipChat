<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    
    <header>
        <img src="assets/images/logochat.png" alt="le logo de notre site" id="logob">
    </header>
 
<h2>S'inscrire</h2>
  <form id="formInscription">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="prenom" placeholder="Prénom" required>

    <input type="email" id="email" placeholder="E-mail" required>

    <input type="password" id="password" placeholder="Mot de passe" required>
    <input type="password" id="passwordConfirm" placeholder="Confirmer le mot de passe" required>

    <button type="submit">S'inscrire</button>
  </form>
  

  <div id="msgInscription"></div>

  <script>
    const form = document.getElementById("formInscription");

    form.addEventListener("submit", function(e) {
      e.preventDefault(); //  Empêche le rechargement

      const password = document.getElementById("password").value;
      const passwordConfirm = document.getElementById("passwordConfirm").value;
      const message = document.getElementById("msgInscription");

      // Vérification des mots de passe
      if (password !== passwordConfirm) {
        message.innerText = " Les mots de passe ne correspondent pas.";
        message.style.color = "red";
        return;
      }

      // Si tout est bon
      message.innerText = " Inscription réussie";
      message.style.color = "lightgreen";
      form.reset();
    });
  </script>

</body>
</html>

</body>
</html>