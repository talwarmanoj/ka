<?php
    
    session_start();
    
    include_once('../env.php');

    // Database connection
    include_once('../inc/config.php');

    if (empty($_POST))
    {
        header("Location: login.php");
    }
    else
    {
        //echo "<pre>";print_r($_POST);die;

        // Get input
        $email = $_POST['email'];
        $password = $_POST['password'];

        $is_admin_flag = 1;

        // Sanitize and check credentials
        // $sql = "SELECT * FROM users WHERE email = ?";
        // $stmt = $conn->prepare($sql);
        // $stmt->bind_param("s", $email);
        // $stmt->execute();
        // $result = $stmt->get_result();

        $sql = "SELECT * FROM users WHERE email = ? AND is_admin = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $is_admin_flag);
        $stmt->execute();
        $result = $stmt->get_result();
        //echo "1111<pre>";print_r($result->num_rows);die;

        if ($result->num_rows === 1)
        {
            $user = $result->fetch_assoc();
            //echo "<pre>";print_r($user);die;
            
            // Verify password
            if (password_verify($password, $user['password']))
            {
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['is_admin'] = $user['is_admin'];

                header("Location: index.php");
                
            } else {
                header("Location: login.php?msg=Invalid password");
            }
        } else {
            header("Location: login.php?msg=No user found with this email");
        }
    }


    // If user is logged in, redirect to index page
    if (isset($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        header("Location: index.php");
        exit();
    }

    $conn->close();
?>
