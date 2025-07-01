<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['motdepasse'] ?? '';

    if (empty($email) || empty($mot_de_passe)) {
        header('Location: ../connexion.php?error=Veuillez remplir tous les champs');
        exit;
    }

    // Recherche utilisateur par email
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($mot_de_passe, $user['mot_de_passe'])) {
        header('Location: ../connexion.php?error=Email ou mot de passe incorrect');
        exit;
    }

    // Authentification réussie : création de session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_pseudo'] = $user['pseudo'];

    // Redirection vers la page d’accueil ou tableau de bord
    header('Location: ../vues/social_media.php');
    exit;
} else {
    header('Location: ../connexion.php');
    exit;
}
