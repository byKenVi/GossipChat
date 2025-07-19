<?php

$host = 'sql113.infinityfree.com';
$dbname  = 'if0_39505941_gossipchat';
$user = 'if0_39505941';
$pass = 'k1WpcfPxia1l1WT';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit('Erreur connexion BDD : ' . $e->getMessage());
}
