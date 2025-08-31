<?php

    include_once('inc/config.php');

    if (isset($_GET['token']))
    {
        $token = $_GET['token'];
        $current_time = date('Y-m-d H:i:s');
        //echo $current_time;

        // Check if token is valid and not expired
        $stmt = $conn->prepare("SELECT id, email from users WHERE reset_token = ? AND reset_expires > ?");
        $stmt->bind_param("ss", $token, $current_time);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        //echo "<pre>";print_r($user);//die;

        if ($user)
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $newPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // Update password and clear token
                $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
                $stmt->execute([$newPass, $user['id']]);

                //echo "Password has been reset.";
                header("Location: login.php?success=Password has been reset.");
                exit;
            }


            //include reset_password_html
            include_once("reset_password_html.php");
            ?>


            <!-- Show password reset form -->
            <!-- <form method="post">
                <label>New Password:</label>
                <input type="password" name="password" required class="form-control">
                <button type="submit" class="btn btn-success mt-2">Reset Password</button>
            </form> -->



            <?php
        } else {
            //echo "Invalid or expired token.";
            header("Location: login.php?error=Invalid or expired token.");
        }
    } else {
        //echo "No token provided.";
        header("Location: login.php?error=No token provided.");
    }

?>
