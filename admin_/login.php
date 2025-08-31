<?php
	session_start();

	// If user is logged in, redirect to index page
	if (isset($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        header("Location: index.php");
        exit();
    }

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
	<title>Dashboard | Login</title>
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
		<aside class="dash-aside-navbar text-center" style="background:#f1f1f1; width:350px;">
			<div class="position-relative">
				<div class="logo d-md-block d-flex align-items-center justify-content-between plr bottom-line pb-30">
					<a href="javascript:;">
						<img src="../assets/images/logo/logo.png" alt="" style="width:165px;">
					</a>
					<button class="close-btn d-block d-md-none"><i class="fa-light fa-circle-xmark"></i></button>
				</div>
				
			</div>
		</aside>
		<!-- /.dash-aside-navbar -->

		<!-- 
		=============================================
			Dashboard Body
		============================================== 
		-->
		
				
            
                <div class="container">
				<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-8">
                    <div class="user-data-form modal-content">
						<div class="form-wrapper">
							<div class="tab-content mt-30">
								<div class="tab-pane show active" role="tabpanel" id="fc1">
									<div class="text-center mb-20">
										<h2>Welcome Back</h2>

			<?php
				if (isset($_GET['success']))
				{
			?>
					<p class="text-success text-center mb-0"><?php echo htmlspecialchars($_GET['success']); ?></p>
			<?php
				}
				else if (isset($_GET['msg']))
				{
			?>
					<p class="text-danger text-center mb-0"><?php echo htmlspecialchars($_GET['msg']); ?></p>
			<?php
				}
			?>

									</div>
									<form action="login_process.php" style="border:1px solid #ccc; padding:50px; border-radius:15px;" method="POST">
										<div class="row">
											<div class="col-12">
												<div class="input-group-meta position-relative mb-25">
													<label>Email*</label>
													<input type="text" name="email" placeholder="Youremail@gmail.com">
												</div>
											</div>
											<div class="col-12">
												<div class="input-group-meta position-relative mb-20">
													<label>Password*</label>
													<input type="password" name="password" placeholder="Enter Password" class="pass_log_id">
													<span class="placeholder_icon"><span class="passVicon"><img src="images/icon/icon_68.svg" alt=""></span></span>
												</div>
											</div>
											
											<div class="col-12">
												<button class="btn-two w-100 text-uppercase d-block mt-20">Login</button>
											</div>
										</div>
									</form>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" role="tabpanel" id="fc2">
									<div class="text-center mb-20">
										<h2>Register</h2>
										<!-- <p class="fs-20 color-dark">Already have an account? <a href="#">Login</a></p> -->
									</div>
									<form action="#">
										<div class="row">
											<div class="col-12">
												<div class="input-group-meta position-relative mb-25">
													<label>Name*</label>
													<input type="text" placeholder="Zubayer Hasan">
												</div>
											</div>
											<div class="col-12">
												<div class="input-group-meta position-relative mb-25">
													<label>Email*</label>
													<input type="email" placeholder="zubayerhasan@gmail.com">
												</div>
											</div>
											<div class="col-12">
												<div class="input-group-meta position-relative mb-20">
													<label>Password*</label>
													<input type="password" placeholder="Enter Password" class="pass_log_id">
													<span class="placeholder_icon"><span class="passVicon"><img src="images/icon/icon_68.svg" alt=""></span></span>
												</div>
											</div>
											<div class="col-12">
												<div class="agreement-checkbox d-flex justify-content-between align-items-center">
													<div>
														<input type="checkbox" id="remember2">
														<label for="remember2">By hitting the "Register" button, you agree to the <a href="#">Terms conditions</a> &amp; <a href="#">Privacy Policy</a></label>
													</div>
												</div> <!-- /.agreement-checkbox -->
											</div>
											<div class="col-12">
												<button class="btn-two w-100 text-uppercase d-block mt-20">Sign Up</button>
											</div>
										</div>
									</form>
								</div>
								<!-- /.tab-pane -->
							</div>
							
							
							
						</div>
						<!-- /.form-wrapper -->
                    </div>
                    <!-- /.user-data-form -->
					</div>
					</div>
                </div>
		


		<button class="scroll-top">
			<i class="bi bi-arrow-up-short"></i>
		</button>



		<!-- Optional JavaScript _____________________________  -->

		<!-- jQuery first, then Bootstrap JS -->
		<!-- jQuery -->
		<script src="../assets/vendor/jquery.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- WOW js -->
		<script src="../assets/vendor/wow/wow.min.js"></script>
		<!-- Slick Slider -->
		<script src="../assets/vendor/slick/slick.min.js"></script>
		<!-- Fancybox -->
		<script src="../assets/vendor/fancybox/fancybox.umd.js"></script>
		<!-- Lazy -->
		<script src="../assets/vendor/jquery.lazy.min.js"></script>
		<!-- js Counter -->
		<script src="../assets/vendor/jquery.counterup.min.js"></script>
		<script src="../assets/vendor/jquery.waypoints.min.js"></script>
		<!-- Nice Select -->
		<script src="../assets/vendor/nice-select/jquery.nice-select.min.js"></script>
		<!-- validator js -->
		<script src="../assets/vendor/validator.js"></script>
		<!-- Chart js -->
		<script src="../assets/vendor/chart.js"></script>

		<!-- Theme js -->
		<script src="../assets/js/theme.js"></script>
	</div> <!-- /.main-page-wrapper -->
</body>

</html>