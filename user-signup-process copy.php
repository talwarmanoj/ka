<?php
    
    include_once('inc/config.php');

    if (isset($_POST['user_signup_process']))
    {
        echo "<pre>";print_r($_POST);

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($name) && empty($email) && empty($password))
        {
            header("Location: login.php?error=All fields are required.");
        } else {

            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (`name`, `email`, `password`, `created_at`) VALUES ('".$name."', '".$email."', '".$hashed_pass."', '".date('Y-m-d H:i:s')."')";

            if ($conn->query($sql) === TRUE)
            {
                header("Location: login.php?success=You have successfully registered.");
            } else {
                //echo "Error: " . $sql . "<br>" . $conn->error;
                header("Location: login.php?error=Something went wrong.");
            }
            $conn->close();

        }

    } else {
        header("Location: index.php");
        exit();
    }
    
?>