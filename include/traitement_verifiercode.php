
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inscription - GossipChat</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>

  <header>
    <a href="index.php">
      <img src="../assets/images/logochat.png" alt="logo GossipChat" class="logo-pulse" style="width:56px; height:56px; margin:1rem;" />
    </a>
  </header>

  <?php
session_start();
require_once("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $code = $_POST['code'] ?? '';

    $stmt = $db->prepare("SELECT * FROM password_resets WHERE email = ? AND reset_code = ? AND expiration > NOW()");
    $stmt->execute([$email, $code]);
    $reset = $stmt->fetch();

    if ($reset) {
        // Code valide => autoriser à réinitialiser
        $_SESSION['verified_email'] = $email;
        header("Location: ../change_password.php"); 
        exit;
    } else {
        echo "Code invalide ou expiré.";
    }
}
?>

  <footer>
    © GossipChat - Tous droits réservés
  </footer>

</body>
</html>

