<?php

	session_start();

	//echo $_SERVER['REQUEST_URI'];die;
	function isactive($myurl)
    {
        $url = $_SERVER['REQUEST_URI'];
        
        if(strpos($url, $myurl) !== false)
        {
            return "active";
        }
    }


	include 'config.php';
	//echo BASE_URL;die;


	// Set timeout duration (20 minutes = 1200 seconds)
	$timeout_duration = 3600;

	// Check if the user has done anything recently
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration)
	{
	    // Last request was more than 20 minutes ago
	    session_unset();     // Unset $_SESSION variables
	    session_destroy();   // Destroy the session
	    header("Location: login.php"); // Redirect to login page
	    exit();
	}

	// Update last activity time
	$_SESSION['LAST_ACTIVITY'] = time();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name='og:image' content='../assets/images/assets/ogg.png'>
	<!-- For IE -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- For Resposive Device -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- For Window Tab Color -->
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#0D1A1C">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#0D1A1C">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#0D1A1C">
	
	<!-- <title>Dashboard | Home</title> -->
	<title>
		Admin | 
		<?php
			if (isset($_SESSION['admin_page_title']))
			{
				echo $_SESSION['admin_page_title'];
			} else {
				echo "Home";
			}
		?>
	</title>

	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="56x56" href="../assets/images/fav-icon/icon_.png">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css" media="all">
	<!-- Main style sheet -->
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css" media="all">
	<!-- responsive style sheet -->
	<link rel="stylesheet" type="text/css" href="../assets/css/responsive.css" media="all">

</head>

<body>
	<div class="main-page-wrapper">
		<!-- ===================================================
			Loading Transition
		==================================================== -->
		<div id="preloader">
			<div id="ctn-preloader" class="ctn-preloader">
				<div class="icon"><img src="../assets/images/loader.gif" alt="" class="m-auto d-block" width="64"></div>
			</div>
		</div>

		<!-- 
		=============================================
			Dashboard Aside Menu
		============================================== 
		-->
		<aside class="dash-aside-navbar">
			<div class="position-relative">
				<div class="logo d-md-block d-flex align-items-center justify-content-between plr bottom-line pb-30">
					<a href="<?php echo BASE_URL . 'admin/index.php'; ?>">
						<img src="../assets/images/logo/logo.png" alt="" style="width:165px;">
					</a>
					<button class="close-btn d-block d-md-none"><i class="fa-light fa-circle-xmark"></i></button>
				</div>
				<nav class="dasboard-main-nav pt-30 pb-30 bottom-line">
					<ul class="style-none">

						<li class="plr">
							<a href="<?php echo BASE_URL . 'admin/index.php'; ?>" class="d-flex w-100 align-items-center <?php echo isactive('/index.php'); ?>">
								<img src="images/icon/icon_1_active.svg" alt="">
								<span>Dashboard</span>
							</a>
						</li>

						<li class="bottom-line pt-30 lg-pt-20 mb-40 lg-mb-30"></li>

						<li><div class="nav-title">Profile</div></li>

						<li class="plr">
							<a href="profile.html" class="d-flex w-100 align-items-center <?php //echo isactive('/profileslug'); ?>">
								<img src="images/icon/icon_3.svg" alt="">
								<span>Profile</span>
							</a>
						</li>

						<li class="plr">
							<a href="account-settings.html" class="d-flex w-100 align-items-center <?php //echo isactive('/accountSlug'); ?>">
								<img src="images/icon/icon_4.svg" alt="">
								<span>Account Settings</span>
							</a>
						</li>

						<li class="bottom-line pt-30 lg-pt-20 mb-40 lg-mb-30"></li>

						<li><div class="nav-title">Listing</div></li>
						<li class="plr">
							<a href="list-properties.php" class="d-flex w-100 align-items-center <?php echo isactive('/list-properties'); ?>">
								<img src="images/icon/icon_6.svg" alt="">
								<span>My Properties</span>
							</a>
						</li>

						<li class="plr">
							<a href="add-property.php" class="d-flex w-100 align-items-center <?php echo isactive('/add-property'); ?>">
								<img src="images/icon/icon_7.svg" alt="">
								<span>Add New Property</span>
							</a>
						</li>

						<li class="plr">
							<a href="<?php echo BASE_URL . 'admin/users.php'; ?>" class="d-flex w-100 align-items-center <?php echo isactive('/users'); ?>">
								<img src="images/icon/icon_3.svg" alt="">
								<span>Users</span>
							</a>
						</li>

						<li class="plr">
							<a href="amenities.php" class="d-flex w-100 align-items-center <?php echo isactive('/amenities'); ?>">
								<img src="images/icon/icon_6.svg" alt="">
								<span>Amenities</span>
							</a>
						</li>

						<li class="plr">
							<a target="_blank" href="<?php echo BASE_URL; ?>" class="d-flex w-100 align-items-center">
								<img src="images/icon/icon_4.svg" alt="">
								<span>Go to website</span>
							</a>
						</li>

					</ul>
				</nav>

				<div class="plr mt-20">
					<a href="#" class="d-flex w-100 align-items-center logout-btn">
						<div class="icon tran3s d-flex align-items-center justify-content-center rounded-circle"><img src="images/icon/icon_41.svg" alt=""></div>
						<span>Logout</span>
					</a>
				</div>
			</div>
		</aside>
		<!-- /.dash-aside-navbar -->

		<!-- 
		=============================================
			Dashboard Body
		============================================== 
		-->
		<div class="dashboard-body">
			<div class="position-relative">
				<!-- ************************ Header **************************** -->
				<header class="dashboard-header">
					<div class="d-flex align-items-center justify-content-end">
						
						<!-- <h4 class="m0 d-none d-lg-block">Dashboard</h4> -->
						<h4 class="m0 d-none d-lg-block">
							<?php
								if (isset($_SESSION['admin_page_title']))
								{
									echo $_SESSION['admin_page_title'];
								} else {
									echo "Dashboard";
								}
							?>
						</h4>

						<button class="dash-mobile-nav-toggler d-block d-md-none me-auto">
							<span></span>
						</button>
						<form action="#" class="search-form ms-auto">
							<input type="text" placeholder="Search here..">
							<button><img src="../assets/images/lazy.svg" data-src="images/icon/icon_43.svg" alt="" class="lazy-img m-auto"></button>
						</form>
						<div class="d-none d-md-block me-3">
							<a href="add-property.php" class="btn-two"><span>Add Listing</span> <i class="fa-thin fa-arrow-up-right"></i></a>
						</div>
						<div class="user-data position-relative">
							<button class="user-avatar online position-relative rounded-circle dropdown-toggle" type="button" id="profile-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
								<img src="../assets/images/lazy.svg" data-src="images/avatar_01.jpg" alt="" class="lazy-img">
							</button>
							<!-- /.user-avatar -->
							<div class="user-name-data">
								<ul class="dropdown-menu" aria-labelledby="profile-dropdown">
									<li>
										<a class="dropdown-item d-flex align-items-center" href="javascript:;"><img src="../assets/images/lazy.svg" data-src="images/icon/icon_23.svg" alt="" class="lazy-img"><span class="ms-2 ps-1">Welcome <?php echo $_SESSION['name']; ?></span></a>
									</li>
									<!--<li>
										<a class="dropdown-item d-flex align-items-center" href="account-settings.html"><img src="../assets/images/lazy.svg" data-src="images/icon/icon_24.svg" alt="" class="lazy-img"><span class="ms-2 ps-1">Account Settings</span></a>
									</li>-->
									<li>
										<!-- <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal"><img src="../assets/images/lazy.svg" data-src="images/icon/icon_25.svg" alt="" class="lazy-img"><span class="ms-2 ps-1">Delete Account</span></a> -->
										<a class="dropdown-item d-flex align-items-center" href="logout.php"><img src="../assets/images/lazy.svg" data-src="images/icon/icon_24.svg" alt="" class="lazy-img"><span class="ms-2 ps-1">Logout</span></a>
									</li>
								</ul>
							</div>
						</div>
						<!-- /.user-data -->
					</div>
				</header>
				<!-- End Header -->

				<!-- <h2 class="main-title d-block d-lg-none">Dashboard wwwww</h2> -->