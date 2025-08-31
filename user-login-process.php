<?php
    
    session_start();

    include_once('inc/config.php');

    //echo "<pre>";print_r($_POST);die;
    
    // $hashedPassword = password_hash('123456', PASSWORD_DEFAULT);
    // echo $hashedPassword;die;

    if (empty($_POST))
    {
        header("Location: login.php?error=OOPS.");
    }
    else
    {

        // Get input
        $email = $_POST['email'];
        $password = $_POST['password'];

        $is_admin_flag = 0;
        $is_verified = 1;

        // Sanitize and check credentials
        $sql = "SELECT * FROM users WHERE email = ? AND is_admin = ? AND is_verified = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $is_admin_flag, $is_verified);
        $stmt->execute();
        $result = $stmt->get_result();
        //echo "<pre>";print_r($result->num_rows);die;

        if ($result->num_rows === 1)
        {
            $user = $result->fetch_assoc();
            //echo "<pre>";print_r($user);die;
            
            // Verify password
            if (password_verify($password, $user['password']))
            {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['is_admin'] = $user['is_admin'];

                //echo "<pre>";print_r($user);die;

                header("Location: index.php?success=You have successfully logged in.");
            } else {
                header("Location: login.php?error=Invalid password.");
            }
        } else {
            header("Location: login.php?error=Invalid credentials or unverified user.");
        }

    }

?>