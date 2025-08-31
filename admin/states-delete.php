<?php

require 'db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM states WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
header('Location: states.php');
exit;
