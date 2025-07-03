<?php

$host = 'localhost';
$dbname  = 'gossipchat';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $db = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit('Erreur connexion BDD : ' . $e->getMessage());
}
// Fonction pour vérifier si un utilisateur existe déjà
function userExists($pdo, $email) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}