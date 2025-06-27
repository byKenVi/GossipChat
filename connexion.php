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
    <h2>Se connecter</h2>
    <form id="formConnexion">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="motdepasse" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
  </form>

  <div id="msgConnexion"></div>

  <script>
    document.getElementById("formConnexion").addEventListener("submit", function(e) {
      e.preventDefault(); //  Empêche la page de recharger

      const message = document.getElementById("msgConnexion");
      message.innerText = "Connexion réussie";
      message.style.color = "lightgreen";
      this.reset();
    });
</body>
</html>