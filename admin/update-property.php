<?php

	session_start();

    //If user is not logged in, redirect to login page
    if (!empty($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        //Ok
    } else {
        header("Location: login.php");
        exit();
    }

    require 'db2.php';

    // $property_id = $_GET['id'] ?? null;
    // if (!$property_id) die("ID missing");



    //echo $id;
    //echo "<pre>";print_r($_POST);



    //Update Property
    if (!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST')
    {

	    // Property ID to update
	    $property_id = intval($_GET['id'] ?? 0);

	    if ($property_id > 0)
	    {

	        // Sanitize and capture input fields
	        $title = htmlspecialchars($_POST['title'] ?? '');
	        $description = htmlspecialchars($_POST['description'] ?? '');
	        $category = htmlspecialchars($_POST['category'] ?? '');
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

	        // Build update query
	        $sql = "UPDATE properties SET title=?, description=?, category=?, price=?, size_in_ft=?, bedrooms=?, bathrooms=?, kitchens=?, garages=?, garage_size=?, year_built=?, floors_no=?, address=?, country=?, city=?, state=?, map_location=?, amenities=? WHERE id=?";

	        $stmt = $conn->prepare($sql);

	        if ($stmt) {
	            $stmt->bind_param(
	                "ssssssssssssssssssi",
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
	                $property_id
	            );
				
				//echo 11111;die;
	            
	            if ($stmt->execute())
	            {

	                // Upload new images if any
	                if (!empty($_FILES['upload_files']['name'][0]))
	                {
	                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
	                    $uploadDir = "uploads/";
	                    $total = count($_FILES['upload_files']['name']);

	                    for ($i = 0; $i < $total; $i++)
	                    {
	                        $tmpFilePath = $_FILES['upload_files']['tmp_name'][$i];
	                        $fileType = mime_content_type($tmpFilePath);
	                        $originalName = basename($_FILES['upload_files']['name'][$i]);

	                        if ($tmpFilePath != "")
	                        {
	                            if (in_array($fileType, $allowedTypes))
	                            {
	                                $newFileName = uniqid() . "_" . $originalName;
	                                $newFilePath = $uploadDir . $newFileName;

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

	                header("Location: list-properties.php?msg=Property updated.");
	            } else {
	                echo "Update failed: " . $stmt->error;
	            }

	            $stmt->close();
	        } else {
	            echo "Prepare failed: " . $conn->error;
	        }

	        $conn->close();
	    } else {
	        echo "Invalid property ID.";
	    }
	} else {
	    echo "No data submitted.";
	}


?>