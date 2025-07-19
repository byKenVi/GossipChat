<?php
session_start();
require_once '../include/database.php';

// Vérifie si l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = (int) $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$userId]);

    header("Location: dashboard.php?msg=Utilisateur supprimé");
    exit;
} else {
    echo "ID invalide.";
}
?>
