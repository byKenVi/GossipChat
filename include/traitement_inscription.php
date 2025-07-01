<?php
require_once 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $pseudo = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['passwordConfirm'] ?? '';

    if ($mot_de_passe !== $passwordConfirm) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Les mots de passe ne correspondent pas."]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ? OR pseudo = ?");
    $stmt->execute([$email, $pseudo]);
    if ($stmt->fetch()) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Email ou pseudo déjà utilisé."]);
        exit;
    }

    $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, pseudo) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$nom, $prenom, $email, $hash, $pseudo])) {
        echo json_encode(["success" => true, "message" => "Inscription réussie."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erreur serveur, réessayez plus tard."]);
    }
    exit;
}
?>
