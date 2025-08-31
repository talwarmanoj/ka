<?php

    include_once('../env.php');

    //echo ENVIRONMENT;die;

    if (ENVIRONMENT == 'production')
    {
        $servername = "localhost";
        $username = "u679911516_luvsingh3004";
        $password = "Luv@3004#$";
        $dbname = "u679911516_property";
    } else {
        $servername = 'localhost';
        $dbname = 'property-manage';
        $username = 'root';
        $password = '';
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
?>
