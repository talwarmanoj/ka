<?php
	session_start();

	//echo "<pre>";print_r($_SESSION);
	if (!empty($_SESSION) && $_SESSION['user_id'])
	{
		header("Location: index.php");
	}

	include_once('inc/header.php');
?>

	<div class="inner-banner-one inner-banner bg-pink text-center z-1 pt-160 lg-pt-130 pb-160 xl-pb-120 md-pb-80 position-relative">
		<div class="container">
            <h3 class="mb-35 xl-mb-20 pt-15">Login KeysArise </h3>
            <ul class="theme-breadcrumb style-none d-inline-flex align-items-center justify-content-center position-relative z-1 bottom-line">
                <li><a href="#">Home</a></li>
                <li>/</li>
                <li> Reset Password</li>
            </ul>
		</div>
		<img src="assets/images/lazy.svg" data-src="assets/images/assets/ils_07.svg" alt="" class="lazy-img shapes w-100 illustration">
	</div>
	<!-- /.inner-banner-one -->


	<div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="container">
        	<div class="user-data-form modal-content">
				<div class="form-wrapper m-auto" style="border:1px solid #ccc; padding:25px;">
					<h1>Reset your password</h1>
					<form method="post">
			            <div class="row">
			            	<div class="col-12">
							<div class="input-group-meta position-relative mb-20">
								<label>New Password*</label>
								<input type="password" name="password" placeholder="Enter New Password" class="pass_log_id" required>
								<span class="placeholder_icon"><span class="passVicon"><img src="assets/images/icon/icon_68.svg" alt=""></span></span>
							</div>
						</div>
			            </div>
			            
			            <button type="submit" class="btn btn-success mt-2">Reset Password</button>
			        </form>
			    </div>
			</div>
		</div>
	</div>

<?php
	include_once('inc/footer.php');
?>