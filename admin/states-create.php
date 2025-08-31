<?php

	session_start();

    unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'Add State';

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


    //Getting Country List
    $stmt = $pdo->query("SELECT countries.id, countries.name as name FROM countries ORDER BY countries.name ASC");
    $countries = $stmt->fetchAll();
    //echo "<pre>";print_r($countries);



    //Data Insert
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $country_id = trim($_POST['country_id']);
        $state_name = trim($_POST['state_name']);

        if (!empty($country_id) && !empty($state_name))
        {
            $stmt = $pdo->prepare("INSERT INTO states (country_id, state_name) VALUES (:country_id, :state_name)");
            $stmt->execute([
                'country_id' => $country_id,
                'state_name' => $state_name
            ]);

            header('Location: states.php');
            //header("Location: index.php");
            exit();
        }
        else
        {
            header('Location: states-create.php');
        }
    }
?>


<div class="bg-white card-box border-20">

<div class="row mb-5">
    <div class="col-md-3">
        <a class="btn btn-primary mb-5" href="states.php">Back</a>
    </div>
</div>

<form method="POST">

    <div class="row">
        <div class="col-md-5">
            <div class="dash-input-wrapper mb-30">
                <label for="">Country*</label>
                <select class="nice-select" name="country_id">
                    <option value="">Select Country</option>

                    <?php
                        if (!empty($countries))
                        {
                            foreach ($countries as $key => $value)
                            {
                                echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                            }
                        }
                    ?>

                </select>
            </div>
        </div>
        
        <div class="col-md-7">
            <div class="dash-input-wrapper mb-30">
                <label for="">State Name*</label>
                <input name="state_name" type="text" placeholder="State Name" required>
            </div>
        </div>

    </div>



    <button class="btn btn-primary" type="submit">Add</button>
    
</form>
</div>



<?php
	include_once('inc/footer.php');
?>