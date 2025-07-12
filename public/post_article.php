<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../include/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Utilisateur non connecté"]);
    exit;
}

$utilisateur_id = $_SESSION['user_id'];
$description = trim($_POST['description'] ?? '');
$media_path = null;
$media_type = null;

if ($description === '' && empty($_FILES['media']['name'])) {
    echo json_encode(["success" => false, "error" => "Aucun contenu fourni"]);
    exit;
}

// Gestion du fichier image ou vidéo
if (!empty($_FILES['media']['name'])) {
    $file = $_FILES['media'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_img = ['jpg', 'jpeg', 'png', 'gif'];
    $allowed_vid = ['mp4', 'webm', 'ogg'];

    if (!in_array($ext, array_merge($allowed_img, $allowed_vid))) {
        echo json_encode(["success" => false, "error" => "Format de fichier non autorisé"]);
        exit;
    }

    $media_type = in_array($ext, $allowed_img) ? 'image' : 'video';
    $filename = uniqid() . '.' . $ext;
    $upload_path = __DIR__ . '/../uploads/' . $filename;
    $media_path = '/gossipchat/uploads/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        echo json_encode(["success" => false, "error" => "Échec de l'upload"]);
        exit;
    }
}

// Insertion en base
$stmt = $pdo->prepare("INSERT INTO articles (utilisateur_id, description, media_path, media_type, date_publication, nombre_likes) 
VALUES (?, ?, ?, ?, NOW(), 0)");
$stmt->execute([$utilisateur_id, $description, $media_path, $media_type]);

$post_id = $pdo->lastInsertId();

$userStmt = $pdo->prepare("SELECT pseudo FROM utilisateurs WHERE id = ?");
$userStmt->execute([$utilisateur_id]);
$pseudo = $userStmt->fetchColumn();

echo json_encode([
    "success" => true,
    "post" => [
        "id" => $post_id,
        "user_id" => $utilisateur_id,
        "username" => $pseudo,
        "description" => htmlspecialchars($description),
        "media_path" => $media_path,
        "media_type" => $media_type,
        "date_publication" => date('Y-m-d H:i:s')
    ]
]);
