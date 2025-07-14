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

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($mot_de_passe, $user['mot_de_passe'])) {
        header('Location: ../connexion.php?error=Email ou mot de passe incorrect');
        exit;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_pseudo'] = $user['pseudo'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'admin' || $user['role'] === 'moderateur') {
        header('Location: ../admin/dashboard.php');
    } else {
        header('Location: ../vues/social_media.php');
    }
    exit;
} else {
    header('Location: ../connexion.php?error=Requête invalide');
    exit;
}