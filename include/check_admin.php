<?php

session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderateur'])) {
    header("Location: ../admin/login.php");
    exit;
}
?>