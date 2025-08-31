<?php

	session_start();

    unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'Add Amenity';

    ob_start();
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);


    require 'db.php';

    //If user is not logged in, redirect to login page
    if (!empty($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        //Ok
    } else {
        header("Location: login.php");
        exit();
    }

    include_once('inc/header.php');


    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);

        if (!empty($name))
        {
            $stmt = $pdo->prepare("INSERT INTO amenities (name, description) VALUES (:name, :description)");
            $stmt->execute([
                'name' => $name,
                'description' => $description
            ]);

            header('Location: amenities.php');
            //header("Location: index.php");
            exit();
        }
        else
        {
            header('Location: amenities-create.php');
        }
    }
?>


<div class="bg-white card-box border-20">

<div class="row mb-5">
    <div class="col-md-3">
        <a class="btn btn-primary mb-5" href="amenities.php">Back</a>
    </div>
</div>

<form method="POST">
    
    <div class="dash-input-wrapper mb-30">
        <label for="">Title*</label>
        <input name="name" type="text" placeholder="Amenity Name" required>
    </div>

    <div class="dash-input-wrapper mb-30">
        <label for="">Description</label>
        <textarea class="size-lg" name="description" placeholder="Write about..."></textarea>
    </div>

    <button class="btn btn-primary" type="submit">Add</button>
    
</form>
</div>



<?php
	include_once('inc/footer.php');
?>