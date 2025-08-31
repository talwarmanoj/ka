<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    session_start();
    //echo "<pre>";print_r($_SESSION);die;

    //ob_start();

    //If user is not logged in, redirect to login page
    if (!empty($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        //Ok
        $user_id = $_SESSION['admin_user_id'];
    } else {
        header("Location: login.php");
        exit();
    }




    //Data Saving
    require 'db2.php';
    
    //echo "<pre>";print_r($_FILES);die;

    // First, check if the form was submitted
    if (!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        // Sanitize and capture input fields
        $title = htmlspecialchars($_POST['title'] ?? '');
        $description = htmlspecialchars($_POST['description'] ?? '');
        $category = intval($_POST['category'] ?? 0);
        $price = htmlspecialchars($_POST['price'] ?? '');
        $size_in_ft = htmlspecialchars($_POST['size_in_ft'] ?? '');
        $bedrooms = intval($_POST['bedrooms'] ?? 0);
        $bathrooms = intval($_POST['bathrooms'] ?? 0);
        $kitchens = intval($_POST['kitchens'] ?? 0);
        $garages = intval($_POST['garages'] ?? 0);
        $garage_size = htmlspecialchars($_POST['garage_size'] ?? '');
        $year_built = htmlspecialchars($_POST['year_built'] ?? '');
        $floors_no = intval($_POST['floors_no'] ?? 0);
        $address = htmlspecialchars($_POST['address'] ?? '');
        $country = htmlspecialchars($_POST['country'] ?? '');
        $city = htmlspecialchars($_POST['city'] ?? '');
        $state = htmlspecialchars($_POST['state'] ?? '');
        $map_location = htmlspecialchars($_POST['map_location'] ?? '');

        // Amenities (array)
        $amenities = $_POST['amenities'] ?? [];
        $amenities_str = implode(",", $amenities);

        
        //$sql = "INSERT INTO properties (title, description, category, price, size_in_ft) VALUES (?, ?, ?, ?, ?)";
        $sql = "INSERT INTO properties (title, description, category, price, size_in_ft, bedrooms, bathrooms, kitchens, garages, garage_size, year_built, floors_no, address, country, city, state, map_location, amenities, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt)
        {
            $stmt->bind_param(
                "sssssssssssssssssss",
                $title, 
                $description,
                $category,
                $price,
                $size_in_ft,
                $bedrooms,
                $bathrooms,
                $kitchens,
                $garages,
                $garage_size,
                $year_built,
                $floors_no,
                $address,
                $country,
                $city,
                $state,
                $map_location,
                $amenities_str,
                $user_id
            );

            if ($stmt->execute())
            {
                $property_id = $stmt->insert_id;
                if (!empty($_FILES['upload_files']['name'][0]))
                {
                    $allowedTypes = ['image/jpeg', 'image/png']; // only allow jpg and png
                    $uploadDir = "images/uploads/";
                    $total = count($_FILES['upload_files']['name']);

                    for ($i = 0; $i < $total; $i++)
                    {
                        $tmpFilePath = $_FILES['upload_files']['tmp_name'][$i];
                        $fileType = mime_content_type($tmpFilePath);
                        $originalName = basename($_FILES['upload_files']['name'][$i]);

                        if ($tmpFilePath != "")
                        {
                            // Validate file type
                            if (in_array($fileType, $allowedTypes))
                            {
                                // Create unique file name
                                $newFileName = uniqid() . "_" . $originalName;
                                
                                //$newFilePath = $uploadDir . $newFileName;
                                $newFilePath = $newFileName;

                                if (move_uploaded_file($tmpFilePath, $newFilePath))
                                {

                                    $photoPath = $conn->real_escape_string($newFilePath);
                                    $sql = "INSERT INTO property_assets (p_id, uploded_files) VALUES ('$property_id', '$photoPath')";
                                    $conn->query($sql);
                                    
                                } else {
                                    echo "Failed to upload: " . htmlspecialchars($originalName) . "<br>";
                                }
                            } else {
                                echo "Invalid file type for: " . htmlspecialchars($originalName) . ". Only JPG and PNG allowed.<br>";
                            }
                        }
                    }
                }

                header('Location: list-properties.php?msg=Property added.');
                // echo "<h2>Property saved successfully!</h2>";
                // echo "<a href='list-properties.php'>Add another property</a>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Prepare failed: " . $conn->error;
        }
        $conn->close();
    } else {
        echo "No data submitted.";
    }


?>