<?php
    
    include_once('env.php');


    if (ENVIRONMENT == 'production')
    {
        define('BASE_URL', 'https://itexporthub.com/property/');
    } else {
        define('BASE_URL', 'http://localhost/property/');
    }
    

    /* Database credentials. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    
    //echo ENVIRONMENT;die;
    if (ENVIRONMENT == 'production')
    {
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'u679911516_luvsingh3004');
        define('DB_PASSWORD', 'Luv@3004#$');
        define('DB_NAME', 'u679911516_property');
    } else {
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'property-manage');
    }
    
    
    /* Attempt to connect to MySQL database */
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if($conn === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

?>