<?php

    include_once('inc/config.php');

    $token = $_GET['token'] ?? '';

    if (!$token) {
        echo "Invalid verification link.";
        exit;
    }


    $stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ? AND is_verified = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows > 0)
    {
        $stmt->close();
        $update = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE verification_token = ?");
        $update->bind_param("s", $token);
        $update->execute();
        echo "Email verified successfully!";
        $update->close();


        header("Location: login.php?error=Email verified.");
        exit;
    }
    else
    {
        echo "Invalid or expired token.";
    }

    $conn->close();

?>
