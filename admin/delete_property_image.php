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

    //echo $id;

    if ($id)
    {
    	//Get url for redirect back
    	$stmt1 = $pdo->prepare("SELECT * FROM property_assets WHERE id = :id ORDER BY id DESC LIMIT 1");
        $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt1->execute();
        $property_url_back = $stmt1->fetch(PDO::FETCH_ASSOC);
        //echo "<pre>";print_r($property_url_back);die;

        $go_back = 'edit-property.php?id='.$property_url_back['p_id'];



	    // Prepare and execute DELETE query
	    $stmt = $pdo->prepare("DELETE FROM property_assets WHERE id = :id");
	    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    
	    if ($stmt->execute())
	    {
	        //echo "Record deleted successfully.";
	        // Optionally redirect
	        header("Location: $go_back");
	        exit;
	    } else {
	        //echo "Error deleting record.";
	        header("Location: $go_back");
	    }
	} else {
	    //echo "Invalid ID.";
	    header("Location: $go_back");
	}


?>