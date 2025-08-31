<?php

    include_once('../env.php');

    //echo ENVIRONMENT;die;
    if (ENVIRONMENT == 'production')
    {
        $host = 'localhost';
        $db = 'u679911516_property';
        $user = 'u679911516_luvsingh3004';
        $pass = 'Luv@3004#$';
        $charset = 'utf8mb4';
    } else {
        $host = 'localhost';
        $db = 'property-manage';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';
    }

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
?>
