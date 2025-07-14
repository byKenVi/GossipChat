<?php
require_once '../include/check_admin.php';
require_once '../include/database.php';

if (isset($_POST['action']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($_POST['action'] === 'supprimer') {
        $db->prepare("DELETE FROM publications WHERE id = ?")->execute([$id]);
    }
    $db->prepare("DELETE FROM signalements WHERE id = ?")->execute([$id]);
}

$reports = $pdo->query("SELECT s.id, p.titre, s.raison FROM signalements s JOIN publications p ON s.publication_id = p.id")->fetchAll();
?>
<!DOCTYPE html>
<html><head><title>Signalements</title><link rel="stylesheet" href="../assets/style2.css"></head><body>
<h2>Publications signalées</h2>
<?php foreach ($reports as $r): ?>
<div>
  <strong><?= htmlspecialchars($r['titre']) ?></strong><br>
  Raison : <?= htmlspecialchars($r['raison']) ?><br>
  <form method="POST">
    <input type="hidden" name="id" value="<?= $r['id'] ?>">
    <button name="action" value="supprimer">Supprimer</button>
    <button name="action" value="ignorer">Ignorer</button>
  </form>
</div><hr>
<?php endforeach; ?>
<a href="dashboard.php">Retour</a>
</body></html>
