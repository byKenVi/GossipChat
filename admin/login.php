<?php
session_start();
require_once '../include/database.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['motdepasse'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mdp, $user['mot_de_passe']) && in_array($user['role'], ['admin', 'moderateur'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Accès refusé. Email ou mot de passe incorrect, ou rôle non autorisé.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
<h2>Connexion administrateur</h2>
<form method="POST">
  <input type="email" name="email" required placeholder="Email admin"><br><br>
  <input type="password" name="motdepasse" required placeholder="Mot de passe"><br><br>
  <button type="submit">Connexion</button>
</form>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<?php
if (isset($_SESSION['success_message'])) {
    echo "<p style='color:green;'>" . $_SESSION['success_message'] . "</p>";
    unset($_SESSION['success_message']);
}
?>
</body>
</html>
