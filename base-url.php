<?php

    include_once('env.php');

    //echo ENVIRONMENT;//die;

    if (ENVIRONMENT == 'production')
    {
        define('BASE_URL', 'https://itexporthub.com/property/');
    } else {
        define('BASE_URL', 'http://localhost/property/');
    }

    //echo BASE_URL;die;
?>