<?php
	session_start();

	//echo "<pre>";print_r($_SESSION);
	if (!empty($_SESSION) && $_SESSION['user_id'])
	{
		header("Location: index.php");
	}

	include_once('inc/header.php');
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


		<!-- 
		=============================================
			Inner Banner
		============================================== 
		-->
		<div class="inner-banner-one inner-banner bg-pink text-center z-1 pt-160 lg-pt-130 pb-160 xl-pb-120 md-pb-80 position-relative">
			<div class="container">
                <h3 class="mb-35 xl-mb-20 pt-15">Login KeysArise <?php //echo date('Y-m-d H:i:s'); ?></h3>
                <ul class="theme-breadcrumb style-none d-inline-flex align-items-center justify-content-center position-relative z-1 bottom-line">
                    <li><a href="index.php">Home</a></li>
                    <li>/</li>
                    <li> Login</li>
                </ul>


			</div>
			<img src="assets/images/lazy.svg" data-src="assets/images/assets/ils_07.svg" alt="" class="lazy-img shapes w-100 illustration">
		</div>
		<!-- /.inner-banner-one -->

		<!-- ################### Login Modal ####################### -->
        <!-- Modal -->
        <div id="loginModal" class="pt-20 pb-20">

			<?php
				if (isset($_GET['success']))
				{
			?>
					<p class="text-success text-center mb-0"><?php echo htmlspecialchars($_GET['success']); ?></p>
			<?php
				}
				else if (isset($_GET['error']))
				{
			?>
					<p class="text-danger text-center mb-0"><?php echo htmlspecialchars($_GET['error']); ?></p>
			<?php
				}
			?>

			<!-- <div class="text-center" id="message"></div> -->


            <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                <div class="container">
                    <div class="user-data-form modal-content">
						<div class="form-wrapper m-auto" style="border:1px solid #ccc; padding:25px;">
							<ul class="nav nav-tabs w-100" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#fc1" role="tab">Login</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" data-bs-toggle="tab" data-bs-target="#fc2" role="tab">Signup</button>
								</li>
							</ul>
							<div class="tab-content mt-30">
								<div class="tab-pane show active" role="tabpanel" id="fc1">
									<!--<div class="text-center mb-20">
										<h2>Welcome Back!</h2>
										<p class="fs-20 color-dark">Still don't have an account? <a href="#">Sign up</a></p>
									</div>-->

									<form action="user-login-process.php" method="POST">

										<div class="row">
											<div class="col-12">
												<div class="input-group-meta position-relative mb-25">
													<label>Email*</label>
													<input type="email" name="email" placeholder="Youremail@gmail.com" required>
												</div>
											</div>
											<div class="col-12">
												<div class="input-group-meta position-relative mb-20">
													<label>Password*</label>
													<input type="password" name="password" placeholder="Enter Password" class="pass_log_id" required>
													<span class="placeholder_icon"><span class="passVicon"><img src="assets/images/icon/icon_68.svg" alt=""></span></span>
												</div>
											</div>
											<div class="col-12">
												<div class="agreement-checkbox d-flex justify-content-between align-items-center">
													<!--<div>
														<input type="checkbox" id="remember_me" name="remember_me" value="1">
														<label for="remember_me">Keep me logged in</label>
													</div>-->
													<a href="javascript:;" data-toggle="modal" data-target="#myModal">Forget Password?</a>
												</div> <!-- /.agreement-checkbox -->
											</div>
											<div class="col-12">
												<!-- <button class="btn-two w-100 text-uppercase d-block mt-20">Login</button> -->
												<input class="btn-two w-100 text-uppercase d-block mt-20" type="submit" name="user_login_process" value="Login">
											</div>
										</div>
									</form>
								</div>
								
								<!-- /.tab-pane -->

								<div class="tab-pane" role="tabpanel" id="fc2">
									<!--<div class="text-center mb-20">
										<h2>Register</h2>
										<p class="fs-20 color-dark">Already have an account? <a href="#">Login</a></p>
									</div>-->
									<form method="POST" id="registrationForm">


										<div class="text-center" id="message"></div>

										
										<div class="row">
											<div class="col-12">
												<div class="input-group-meta position-relative mb-25">
													<label>Name*</label>
													<input type="text" name="name" id="name" placeholder="Enter Name" required>
												</div>
											</div>
											<div class="col-12">
												<div class="input-group-meta position-relative mb-25">
													<label>Email*</label>
													<input type="text" name="email" id="email" placeholder="Enter Email" required>
												</div>
											</div>

											<div class="col-12">
												<div class="input-group-meta position-relative mb-20">
													<label>Password*</label>
													<input type="password" name="password" id="password" placeholder="Enter Password" class="pass_log_id" >
													<span class="placeholder_icon"><span class="passVicon"><img src="assets/images/icon/icon_68.svg" alt=""></span></span>
												</div>
											</div>

											<div class="col-12">
												<div class="input-group-meta position-relative mb-20">
													<label>Confirm Password*</label>
													<input type="password" name="c_password" id="c_password" placeholder="Enter Confirm Password" class="pass_log_id" >
													<span class="placeholder_icon"><span class="passVicon"><img src="assets/images/icon/icon_68.svg" alt=""></span></span>
												</div>
											</div>

											<!--<div class="col-12">
												<div class="agreement-checkbox d-flex justify-content-between align-items-center">
													<div>
														<input type="checkbox" id="remember2">
														<label for="remember2">By hitting the "Register" button, you agree to the <a href="#">Terms conditions</a> & <a href="#">Privacy Policy</a></label>
													</div>
												</div>
											</div>-->

											<div class="col-12">
												<!-- <button class="btn-two w-100 text-uppercase d-block mt-20">Sign Up</button> -->
												<input class="btn-two w-100 text-uppercase d-block mt-20" type="submit" name="user_signup_process" value="Sign Up">
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



<!-- Forget Modal Popup -->
	<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Forget Password</h4>
	      <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
	    </div>
	    <div class="modal-body">
	      	
	    	<form method="post" action="forgot_password.php">
	          <div class="form-group">
	            <label for="email">Enter your email address:</label>
	            <input type="email" name="email" class="form-control" required>
	          </div>
	          <button type="submit" class="btn btn-primary">Send Reset Link</button>
	        </form>

	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
	  </div>
	</div>
	</div>




<script src="assets/js/form.js"></script>



<?php
	include_once('inc/footer.php');
?>