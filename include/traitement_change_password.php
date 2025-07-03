<?php
session_start();
require_once("database.php");

if (!isset($_SESSION['verified_email'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['verified_email'];
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($newPassword !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    if (strlen($newPassword) < 6) {
        echo "Le mot de passe doit contenir au moins 6 caractères.";
        exit;
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);

    // Nettoyer la session
    unset($_SESSION['verified_email']);
    unset($_SESSION['reset_email']);

    echo "Mot de passe changé avec succès. <a href='../connexion.php'>Se connecter</a>";
}
