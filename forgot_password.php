<?php

    include_once('inc/config.php');
    //echo BASE_URL;die;
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		//echo "<pre>";print_r($_POST);die;
	    $email = trim($_POST['email']);

	    $stmt = $conn->prepare("SELECT id, email, name, reset_token, reset_expires from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        //echo "<pre>";print_r($user);die;

        if ( !empty($user) && !empty($user['id']) )
	    {
	    	$token = bin2hex(random_bytes(32));
	        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

	        $stmt1 = $conn->prepare("UPDATE users SET reset_token = ?,reset_expires = ? WHERE id = ?");
			$stmt1->bind_param("ssi", $token, $expires, $user['id']);
			$stmt1->execute();
	        
	        $resetLink = BASE_URL . "reset_password.php?token=" . $token;
	        //echo $resetLink;die;

	        if (mail($email, "Password Reset", "Click here to reset your password: $resetLink"))
	        {
	            header("Location: login.php?success=Reset link sent to your email.");
	        } else {
	            header("Location: login.php?error=Error sending email.");
	        }
	    }
	}
	else
	{
		header("Location: login.php?error=Email not found.");
	}

?>