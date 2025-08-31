<?php

    include_once('inc/config.php');

    //echo "<pre>";print_r($_POST);die;

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
    $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, date('Y-m-d H:i:s'));

    if ($stmt->execute())
    {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

?>
