<?php
require_once 'include/database.php';

$CODE_SECRET = "ESGIS2025#";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $code = $_POST['code'];
    $mot_de_passe = $_POST['motdepasse'];

    if ($code === $CODE_SECRET) {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            // Hasher le mot de passe avant insertion
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Insérer avec email, role et mot de passe
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe, role) VALUES (?, ?, 'admin')");
            $stmt->execute([$email, $hash]);

            session_start();
            $_SESSION['success_message'] = "Compte administrateur créé avec succès. Connectez-vous.";
            header("Location: admin/login.php");
            exit;
        }
    } else {
        $erreur = "Code d’autorisation invalide.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Créer un Administrateur</title>
    <link rel="stylesheet" href="assets/style.css" />
</head>
<body>
<h2>Inscription Administrateur</h2>
<form method="POST">
  <input type="email" name="email" required placeholder="Email"><br><br>
  <input type="password" name="mot_de_passe" required placeholder="Mot de passe"><br><br>
  <input type="text" name="code" required placeholder="Code d’autorisation"><br><br>
  <button type="submit">Créer le compte</button>
</form>

<?php if (isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
</body>
</html>
