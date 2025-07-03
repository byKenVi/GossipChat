<?php
session_start();
require_once 'database.php'; // Assure-toi que ce fichier définit bien $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['motdepasse'] ?? '';

    if (empty($email) || empty($mot_de_passe)) {
        header('Location: ../connexion.php?error=Veuillez remplir tous les champs');
        exit;
    }

    // Utiliser la bonne variable de connexion : $pdo
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($mot_de_passe, $user['mot_de_passe'])) {
        header('Location: ../connexion.php?error=Email ou mot de passe incorrect');
        exit;
    }

    // Authentification réussie
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_pseudo'] = $user['pseudo'];

    // Redirection après connexion
    header('Location: ../vues/social_media.php');
    exit;
} else {
    header('Location: ../connexion.php');
    exit;
}
// Si la requête n'est pas POST, rediriger vers la page de connexion
header('Location: ../connexion.php?error=Requête invalide');