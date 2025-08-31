<?php

	session_start();


    ob_start();
    

    //If user is not logged in, redirect to login page
    if (!empty($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        //Ok
    } else {
        header("Location: login.php");
        exit();
    }


	require 'db.php';


    $id = $_GET['id'] ?? null;
    if (!$id) die("ID missing");



    $is_deleted = 0;
    $stmt = $pdo->prepare("UPDATE properties SET is_deleted = :is_deleted WHERE id = :id");
    $stmt->execute([
        'is_deleted' => $is_deleted,
        'id' => $id
    ]);
    header('Location: list-properties.php?msg=Property deleted.');
    exit;

?>