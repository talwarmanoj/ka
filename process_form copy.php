<?php

	session_start();

	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');


	// Database connection
	$conn = new mysqli("localhost", "root", "", "property-manage");
	if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

	//Include DB Connection
	//include_once('inc/config.php');



	if (!empty($_POST))
	{
		//echo "<pre>";print_r($_POST);
		// echo "<pre>";print_r($_FILES);
		//die;

		

		// STEP 1: Insert into `users` table
		$firstName = $_POST['first_name'] ?? '';
		$lastName = $_POST['last_name'] ?? '';
		$gender = $_POST['gender'] ?? '';
		$dob = $_POST['dob'] ?? '';
		$country = $_POST['country'] ?? '';
		$phone = $_POST['phone'] ?? '';
		$name = 'NAME'; // Fixed this

		$sql = "INSERT INTO users (`name`, `first_name`, `last_name`, `gender`, `dob`, `country`, `phone`) 
		        VALUES (?, ?, ?, ?, ?, ?, ?)";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssssss", $name, $firstName, $lastName, $gender, $dob, $country, $phone);
		$stmt->execute();
		//$user_id = $stmt->insert_id;
		$stmt->close();


		echo 2222;die;
		//echo "UserID: " . $user_id;die;


		// STEP 2: Insert into `user_addresses`
		$addr_country = $_POST['addr_country'];
		$city = $_POST['city'];
		$house_no = $_POST['house_no'];
		$street = $_POST['street'];
		$zip = $_POST['zip'];

		$sql = "INSERT INTO user_addresses (user_id, country, city, house_no, street, zip) 
		        VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ssssss", $user_id, $addr_country, $city, $house_no, $street, $zip);
		$stmt->execute();
		$stmt->close();



		// STEP 3: Insert into `user_documents`
		$doc_type1 = $_POST['doc_type_1'];
		$doc_number1 = $_POST['doc_number_1'];
		$front1 = $_FILES['doc_front_1']['name'];
		$back1 = $_FILES['doc_back_1']['name'];

		// Upload files
		move_uploaded_file($_FILES['doc_front_1']['tmp_name'], "uploads/" . $front1);
		move_uploaded_file($_FILES['doc_back_1']['tmp_name'], "uploads/" . $back1);

		// insert document 1
		$sql = "INSERT INTO user_documents (user_id, doc_type, doc_number, front_img, back_img) 
		        VALUES (?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssss", $user_id, $doc_type1, $doc_number1, $front1, $back1);
		$stmt->execute();
		$stmt->close();

		// Repeat document 2 if needed...

		echo "Data submitted successfully!";
		$conn->close();

	} else {
		header("Location: profile.php");
	}

?>
