<?php
	
	//session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name='og:image' content='images/assets/ogg.png'>
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
	<title>Home</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="56x56" href="images/fav-icon/icon.png">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="all">
	<!-- Main style sheet -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css" media="all">
	<!-- responsive style sheet -->
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css" media="all">

</head>

<body>
	<div class="main-page-wrapper">
		<!-- ===================================================
			Loading Transition
		==================================================== -->
		<!-- <div id="preloader">
			<div id="ctn-preloader" class="ctn-preloader">
				<div class="icon"><img src="assets/images/loader.gif" alt="" class="m-auto d-block" width="64"></div>
			</div>
		</div> -->


        <!-- 
		=============================================
			Theme Main Menu
		============================================== 
		-->
		<header class="theme-main-menu menu-overlay menu-style-two sticky-menu">
			<div class="inner-content gap-one">
				<div class="top-header position-relative">
					<div class="d-flex align-items-center">
						<div class="logo order-lg-0">
							<a href="index.php" class="d-flex align-items-center">
								<img src="assets/images/logo/logo.png" alt="" style="width:160px;">
							</a>
						</div>
						<!-- logo -->
						<div class="right-widget ms-auto me-3 me-lg-0 order-lg-3">

						    <?php if (isset($_SESSION) && !empty($_SESSION['user_id'])) { ?>
						    <li class="nav-item dropdown" style="list-style:none;">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Welcome <?php echo $_SESSION['name']; ?></a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                      <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
              	<?php } else { ?>
                <li class="d-flex align-items-center login-btn-one">
                    <i class="fa-regular fa-lock"></i> 
                    <a href="login.php" class="fw-500 tran3s">Login <span class="d-none d-sm-inline-block">/ Sign up</span></a>
                </li>
              	<?php } ?>

						</div>

						<nav class="navbar navbar-expand-lg p0 ms-lg-5 order-lg-2">
							<button class="navbar-toggler d-block d-lg-none" type="button" data-bs-toggle="collapse"
								data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
								aria-label="Toggle navigation">
								<span></span>
							</button>
							<div class="collapse navbar-collapse" id="navbarNav">
								<ul class="navbar-nav align-items-lg-center">
									<li class="d-block d-lg-none"><div class="logo"><a href="index.php" class="d-block"><img src="assets/images/logo/logo_02.svg" alt=""></a></div></li>
									<li class="nav-item">
										<a class="nav-link" href="index.php" role="button" data-bs-auto-close="outside" aria-expanded="false">Home
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="how-works.php" role="button" data-bs-auto-close="outside" aria-expanded="false">How It Works
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="about-us.php" role="button" data-bs-auto-close="outside" aria-expanded="false">About Us
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="faqs.php" role="button" data-bs-auto-close="outside" aria-expanded="false">FAQs
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="contact-us.php" role="button" data-bs-auto-close="outside" aria-expanded="false">Contact Us
										</a>
									</li>

									<li class="d-md-none ps-2 pe-2 mt-20">
										<a href="dashboard/add-property.html" class="btn-two w-100 rounded-0" target="_blank"><span>Add Listing</span> <i class="fa-thin fa-arrow-up-right"></i></a>
									</li>
								</ul>
							</div>
						</nav>
					</div>
				</div> <!--/.top-header-->
			</div> <!-- /.inner-content -->
		</header> 
		<!-- /.theme-main-menu -->