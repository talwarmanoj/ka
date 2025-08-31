<?php
	session_start();
	
	unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'Dashboard';

	//echo "<pre>";print_r($_SESSION);die;

	// If user is not logged in, redirect to login page
	if (!empty($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        //Ok
    } else {
        header("Location: login.php");
        exit();
    }
	// if (!isset($_SESSION['admin_user_id'])) 
	// {
	// 	header("Location: login.php");
	// 	exit();
	// }

	include_once('inc/header.php');

	//echo BASE_URL;
?>


				<div class="bg-white border-20">
					<div class="row">
						<div class="col-lg-3 col-6">
							<div class="dash-card-one bg-white border-30 position-relative mb-15 skew-none">
								<div class="d-sm-flex align-items-center justify-content-between">
									<div class="icon rounded-circle d-flex align-items-center justify-content-center order-sm-1"><img src="../assets/images/lazy.svg" data-src="images/icon/icon_12.svg" alt="" class="lazy-img"></div>
									<div class="order-sm-0">
										<span>123 All Properties</span>
										<div class="value fw-500">1.7k+</div>
									</div>
								</div>
							</div>
							<!-- /.dash-card-one -->
						</div>
						<div class="col-lg-3 col-6">
							<div class="dash-card-one bg-white border-30 position-relative mb-15">
								<div class="d-sm-flex align-items-center justify-content-between">
									<div class="icon rounded-circle d-flex align-items-center justify-content-center order-sm-1"><img src="../assets/images/lazy.svg" data-src="images/icon/icon_13.svg" alt="" class="lazy-img"></div>
									<div class="order-sm-0">
										<span>Total Pending</span>
										<div class="value fw-500">03</div>
									</div>
								</div>
							</div>
							<!-- /.dash-card-one -->
						</div>
						<div class="col-lg-3 col-6">
							<div class="dash-card-one bg-white border-30 position-relative mb-15">
								<div class="d-sm-flex align-items-center justify-content-between">
									<div class="icon rounded-circle d-flex align-items-center justify-content-center order-sm-1"><img src="../assets/images/lazy.svg" data-src="images/icon/icon_14.svg" alt="" class="lazy-img"></div>
									<div class="order-sm-0">
										<span>Total Views</span>
										<div class="value fw-500">4.8k</div>
									</div>
								</div>
							</div>
							<!-- /.dash-card-one -->
						</div>
						<div class="col-lg-3 col-6">
							<div class="dash-card-one bg-white border-30 position-relative mb-15">
								<div class="d-sm-flex align-items-center justify-content-between">
									<div class="icon rounded-circle d-flex align-items-center justify-content-center order-sm-1"><img src="../assets/images/lazy.svg" data-src="images/icon/icon_15.svg" alt="" class="lazy-img"></div>
									<div class="order-sm-0">
										<span>Total Favourites</span>
										<div class="value fw-500">07</div>
									</div>
								</div>
							</div>
							<!-- /.dash-card-one -->
						</div>
					</div>
				</div>

				<div class="row gx-xxl-5 d-flex pt-15 lg-pt-10">
					<div class="col-xl-12 col-lg-12 d-flex flex-column">
						<div class="user-activity-chart bg-white border-20 mt-30 h-100">
							<div class="d-flex align-items-center justify-content-between plr">
								<h5 class="dash-title-two">Property View</h5>
								<div class="short-filter d-flex align-items-center">
									<div class="fs-16 me-2">Short by:</div>
									<select class="nice-select fw-normal">
										<option value="0">Weekly</option>
										<option value="1">Daily</option>
										<option value="2">Monthly</option>
									</select>
								</div>
							</div>
							<div class="plr mt-50">
								<div class="chart-wrapper">
									<canvas id="property-chart"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.dashboard-body -->



<?php
	include_once('inc/footer.php');
?>