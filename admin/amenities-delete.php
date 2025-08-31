<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM amenities WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
header('Location: amenities.php');
exit;
