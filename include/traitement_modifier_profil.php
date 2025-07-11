<?php
session_start();
require_once '../include/database.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit;
}

// On suppose que les données viennent d’un formulaire (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'] ?? '';
    $password = $_POST['password'] ?? '';

    $photo_profil = null;
    if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] === UPLOAD_ERR_OK) {
        $nom_fichier = basename($_FILES['photo_profil']['name']);
        $chemin_temp = $_FILES['photo_profil']['tmp_name'];
        $dossier_destination = '../img/';
        $chemin_final = $dossier_destination . $nom_fichier;

        if (move_uploaded_file($chemin_temp, $chemin_final)) {
            $photo_profil = $nom_fichier;
        }
    }

    // Début de la requête
    $sql = "UPDATE utilisateurs SET pseudo = :pseudo";
    $params = [
        'pseudo' => $pseudo,
        'id' => $_SESSION['user_id']
    ];

    // Si nouveau mot de passe → ajout à la requête
    if (!empty($password)) {
        $sql .= ", mot_de_passe = :mot_de_passe";
        $params['mot_de_passe'] = password_hash($password, PASSWORD_DEFAULT);
    }

    // Si nouvelle image → ajout à la requête
    if (!empty($photo_profil)) {
        $sql .= ", photo_profil = :photo_profil";
        $params['photo_profil'] = $photo_profil;
    }

    // Clause WHERE
    $sql .= " WHERE id = :id";

    // Préparation et exécution
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $_SESSION['success_message'] = "Profil mis à jour avec succès !";
header("Location: ../vues/profil.php");
exit;

    // Redirection
    header("Location: ../vues/profil.php");
    exit;
}
?>
