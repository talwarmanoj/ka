<?php

    include_once('inc/config.php');

    include_once('base-url.php');//Include for base url
    //echo ENVIRONMENT;die;

    //echo "<pre>";print_r($_POST);die;

    $verificationToken = bin2hex(random_bytes(16)); // Generates a secure token
    //echo $verificationToken;die;

    $name = trim($_POST['name']) ?? '';
    $email = trim($_POST['email']) ?? '';
    $password = trim($_POST['password']) ?? '';
    $confirmPassword = trim($_POST['confirmPassword']) ?? '';

    if (!$name || !$email || !$password || !$confirmPassword)
    {
        echo "All fields are required.";
        exit;
    }

    if ($password != $confirmPassword)
    {
        echo "Passwords do not match.";
        exit;
    }


    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    

    if ($check->num_rows > 0)
    {
        echo "Email is already registered.";
        $check->close();
        exit;
    }
    $check->close();


    // Securely hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user
    $sql = "INSERT INTO users (name, email, password, created_at, verification_token) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $hashedPassword, date('Y-m-d H:i:s'), $verificationToken);


    if ($stmt->execute())
    {
        echo "<p>Registration successful!</p>";


        // Send a confirmation email
        $verifyLink = BASE_URL . "verify.php?token=" . $verificationToken;

        $to = $email;

        $subject = "Verify Your Email";
        
        //$message = "Hi $name,\n\n\n Please click the link below to verify your email: \n\n\n <a href='$verifyLink'><b>Click to verify</b></a> \n\n\n Thanks, \n KeysArise Team";

        $message = <<<EOD
        <h3>Hi $name,<br><br>
        Please click the link below to verify your email:<br><br>
        <a href="$verifyLink"><b>Click to verify</b></a><br><br>
        Thanks,<br>
        KeysArise Team</h3>
        EOD;

        //echo $message;die;

        /*$headers = "From: abhinitkumar99@gmail.com\r\n" .
                   "Reply-To: abhinitkumar99@gmail.com\r\n" .
                   "X-Mailer: PHP/" . phpversion();*/


        // To send HTML mail, the Content-type header must be set
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers
        $headers .= "From: KeysArise <no-reply@keysarise.com>" . "\r\n";


        if (mail($to, $subject, $message, $headers))
        {
            echo " <p>A confirmation email has been sent, Please verify.</p>";
        } else {
            echo " <p>Registration successful, but failed to send confirmation email.</p>";
        }


    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

?>
