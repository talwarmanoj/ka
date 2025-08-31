<?php

	session_start();
	//echo "<pre>";print_r($_SESSION);die;
	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');


	//Include DB Connection
	include_once('inc/config.php');


	//Access if user is logged in
	if (empty($_POST) && empty($_SESSION) && $_SESSION['user_id'] == '')
    {
        header("Location: login.php");
    } else {
        //$current_user_id = $_SESSION['user_id'];
        $current_user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
        $current_user_email = mysqli_real_escape_string($conn, $_SESSION['email']);
        $current_user_name = mysqli_real_escape_string($conn, $_SESSION['name']);
        //echo "<p>CURRENT USER ID: " . $current_user_id .', EMAIL: '.$current_user_email.', Name: '.$current_user_name.'</p>';


        //Getting all profile data for assets and check data exist or not
        $stmt = $conn->prepare("
            SELECT 
                u.id,
                u.name,
                u.first_name,
                u.last_name,
                u.gender,
                u.dob,
                u.country,
                u.phone,
                u.profile_image,
                u.email,

                ua.user_id AS addr_user_id,
                ua.country AS addr_country,
                ua.city AS addr_city,
                ua.house_no AS addr_house_no,
                ua.street AS addr_street,
                ua.zip AS addr_zip,
                ua.bank_account_number AS addr_bank_account_number,
                ua.bank_iban AS addr_bank_iban,
                ua.bank_country AS addr_bank_country,

                docs.user_id AS docs_user_id,
                docs.doc_type AS docs_doc_type,
                docs.doc_number AS docs_doc_number,
                docs.front_img AS docs_front_img,
                docs.back_img AS docs_back_img,
                docs.doc_type2 AS docs_doc_type2,
                docs.doc_number2 AS docs_doc_number2,
                docs.front_img2 AS docs_front_img2,
                docs.back_img2 AS docs_back_img2
            FROM users AS u
            LEFT JOIN user_addresses AS ua ON u.id = ua.user_id
            LEFT JOIN user_documents AS docs ON u.id = docs.user_id
            WHERE u.id = ?
        ");

        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        //echo "<pre>";print_r($user['addr_user_id']);die;
    }

    


	if (!empty($_POST) && !empty($current_user_id))
	{
		//echo "Ok Form Sumitting...";
		// echo "<pre>";print_r($_POST);
		// echo "<pre>";print_r($_FILES);
		// die;

		$userId    = $current_user_id;

		// 1-First form Data
		$first_name = mysqli_real_escape_string($conn, $_POST['first_name']??'');
		$last_name = mysqli_real_escape_string($conn, $_POST['last_name']??'');
		$country = mysqli_real_escape_string($conn, $_POST['country']??'');
		$phone = mysqli_real_escape_string($conn, $_POST['phone']??'');


		// 2-Second form Data
		$addr_country = mysqli_real_escape_string($conn, $_POST['addr_country']??'');
		$addr_city = mysqli_real_escape_string($conn, $_POST['addr_city']??'');
		$addr_house_no = mysqli_real_escape_string($conn, $_POST['addr_house_no']??'');
		$addr_street = mysqli_real_escape_string($conn, $_POST['addr_street']??'');
		$addr_zip = mysqli_real_escape_string($conn, $_POST['addr_zip']??'');
		$addr_bank_account_number = mysqli_real_escape_string($conn, $_POST['addr_bank_account_number']??'');
		$addr_bank_iban = mysqli_real_escape_string($conn, $_POST['addr_bank_iban']??'');
		$addr_bank_country = mysqli_real_escape_string($conn, $_POST['addr_bank_country']??'');
		


		if (!empty($_POST['gender']))
		{
			$gender = mysqli_real_escape_string($conn, $_POST['gender']);
		} else {
			$gender = null;
		}

		if (!empty($_POST['dob']))
		{
			$dob = mysqli_real_escape_string($conn, $_POST['dob']);
		} else {
			$dob = null;
		}

		//Save post image else as it is
		// if (!empty($_FILES['profile_image']['name']))
		// {
		// 	$profile_image = time().'_'.$_FILES['profile_image']['name'];
		// 	move_uploaded_file($_FILES['profile_image']['tmp_name'], "uploads/profiles/" . $profile_image);
		// } else {
		// 	$profile_image = $user['profile_image']??'';
		// }
		if (!empty($_FILES['profile_image']['name']))
		{
		    $allowed_extensions = ['jpg', 'jpeg', 'png'];
		    $file_name = $_FILES['profile_image']['name'];
		    $file_tmp = $_FILES['profile_image']['tmp_name'];
		    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

		    if (in_array($file_ext, $allowed_extensions))
		    {
		        $profile_image = time() . '_' . $file_name;
		        move_uploaded_file($file_tmp, "uploads/profiles/" . $profile_image);
		    } else {
		        header("Location: profile.php?msg=Only JPG and PNG files are allowed.");
		        exit;
		    }
		} else {
		    $profile_image = $user['profile_image'] ?? '';
		}




		// 3-Third form Data
		$docs_doc_type = mysqli_real_escape_string($conn, $_POST['docs_doc_type']??'');
		$docs_doc_number = mysqli_real_escape_string($conn, $_POST['docs_doc_number']??'');
		$docs_doc_type2 = mysqli_real_escape_string($conn, $_POST['docs_doc_type2']??'');
		$docs_doc_number2 = mysqli_real_escape_string($conn, $_POST['docs_doc_number2']??'');


		//Save first documents else as it is
		if (!empty($_FILES['docs_front_img']['name']))
		{
			$docs_front_img = time().'_'.$_FILES['docs_front_img']['name'];
			move_uploaded_file($_FILES['docs_front_img']['tmp_name'], "uploads/documents/" . $docs_front_img);
		} else {
			$docs_front_img = $user['docs_front_img']??'';
		}

		if (!empty($_FILES['docs_back_img']['name']))
		{
			$docs_back_img = time().'_'.$_FILES['docs_back_img']['name'];
			move_uploaded_file($_FILES['docs_back_img']['tmp_name'], "uploads/documents/" . $docs_back_img);
		} else {
			$docs_back_img = $user['docs_back_img']??'';
		}


		//Save second documents else as it is
		if (!empty($_FILES['docs_front_img2']['name']))
		{
			$docs_front_img2 = time().'_'.$_FILES['docs_front_img2']['name'];
			move_uploaded_file($_FILES['docs_front_img2']['tmp_name'], "uploads/documents/" . $docs_front_img2);
		} else {
			$docs_front_img2 = $user['docs_front_img2']??'';
		}

		if (!empty($_FILES['docs_back_img2']['name']))
		{
			$docs_back_img2 = time().'_'.$_FILES['docs_back_img2']['name'];
			move_uploaded_file($_FILES['docs_back_img2']['tmp_name'], "uploads/documents/" . $docs_back_img2);
		} else {
			$docs_back_img2 = $user['docs_back_img2']??'';
		}


		// Prepare the SQL statement
		$stmt = $conn->prepare("UPDATE users SET first_name = ?,last_name = ?,gender = ?,dob = ?,country = ?,phone = ?, profile_image = ? WHERE id = ?");
		$stmt->bind_param("sssssssi", $first_name,$last_name,$gender,$dob,$country,$phone,$profile_image, $userId);

		// Execute and check & Saving First form then save Rest all forms data
		if ($stmt->execute())
		{

			// 2-Saving Second form
			if (!empty($user) && !empty($user['addr_user_id']))
			{
				//echo "Data exist";
				$stmt_addr = $conn->prepare("UPDATE user_addresses SET country = ?,city = ?,house_no = ?,street = ?,zip = ?,bank_account_number = ?,bank_iban = ?,bank_country = ? WHERE user_id = ?");
				$stmt_addr->bind_param("ssssssssi", $addr_country,$addr_city,$addr_house_no,$addr_street,$addr_zip,$addr_bank_account_number,$addr_bank_iban,$addr_bank_country, $userId);
				$stmt_addr->execute();
			} else {
				//echo "No data exist";
				$stmt_addr = $conn->prepare("INSERT INTO user_addresses (country, city, house_no, street, zip, bank_account_number, bank_iban, bank_country, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt_addr->bind_param("ssssssssi", $addr_country, $addr_city, $addr_house_no, $addr_street, $addr_zip, $addr_bank_account_number, $addr_bank_iban, $addr_bank_country, $userId);
				$stmt_addr->execute();
			}
			


			// 3-Saving Third form
			if (!empty($user) && !empty($user['docs_user_id']))
			{
				//echo "Data exist";
				$stmt_addr = $conn->prepare("UPDATE user_documents SET doc_type = ?,doc_number = ?,front_img = ?,back_img = ?,doc_type2 = ?,doc_number2 = ?,front_img2 = ?,back_img2 = ? WHERE user_id = ?");
				$stmt_addr->bind_param("ssssssssi", $docs_doc_type,$docs_doc_number,$docs_front_img,$docs_back_img,$docs_doc_type2,$docs_doc_number2,$docs_front_img2,$docs_back_img2, $userId);
				$stmt_addr->execute();
			} else {
				//echo "No data exist";
				$stmt_addr = $conn->prepare("INSERT INTO user_documents (doc_type, doc_number, front_img, back_img, doc_type2, doc_number2, front_img2, back_img2, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt_addr->bind_param("ssssssssi", $docs_doc_type, $docs_doc_number, $docs_front_img, $docs_back_img, $docs_doc_type2, $docs_doc_number2, $docs_front_img2, $docs_back_img2, $userId);
				$stmt_addr->execute();
			}
			//die;



		    header("Location: profile.php?msg=Profile updated.");
		} else {
		    //echo "Error updating user: " . $stmt->error;
		    header("Location: index.php");
		}

		$stmt->close();
		$conn->close();


	}
	else
	{
		header("Location: login.php");
	}
	

?>