<?php

	session_start();

	include_once('inc/header.php');



    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //echo "<pre>";print_r($_POST);die;

        // Get form data safely
        $name = strip_tags(trim($_POST["name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Basic validation
        if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message))
        {
            //echo "Please complete the form and provide a valid email.";
            header("Location: contact-us.php?error=Please complete the all field and provide a valid email.");
            exit;
        }

        // Recipient email
        $to = "cs@keysarise.co.uk";
        $to = "sandeep.php3004@gmail.com";

        // Email subject
        $subject = "New Contact Form Message from $name";

        // Email content
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Message: $message\n";

        // Email headers
        $headers = "From: $name <$email>";

        // Send email
        if (mail($to, $subject, $email_content, $headers))
        {
            $success = "Thank you! Your message has been sent.";
        }
        else
        {
            $err = "Oops! Something went wrong, and we couldn't send your message.";
        }
    }

?>

		<!-- 
		=============================================
			Inner Banner
		============================================== 
		-->
		<div class="inner-banner-one inner-banner bg-pink text-center z-1 pt-160 lg-pt-130 pb-160 xl-pb-120 md-pb-80 position-relative">
			<div class="container">
                <h3 class="mb-35 xl-mb-20 pt-15">Contact KeysArise</h3>
                
                
                <!-- <h4 class="py-3 text-danger">MESSAGE</h4> -->
                
                <ul class="theme-breadcrumb style-none d-inline-flex align-items-center justify-content-center position-relative z-1 bottom-line">
                    <li><a href="/">Home</a></li>
                    <li>/</li>
                    <li> Contact us</li>
                </ul>
			</div>
			<img src="assets/images/lazy.svg" data-src="assets/images/assets/ils_07.svg" alt="" class="lazy-img shapes w-100 illustration">
		</div>
		<!-- /.inner-banner-one -->

		


		
		<div class="contact-us border-top pt-80 lg-pt-60">
			<div class="container">
                <div class="row">
                    <div class="col-xxl-9 col-xl-8 col-lg-10 m-auto">
                        <div class="title-one text-center wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <h3>Questions? Feel Free to Reach Out Via Message.</h3>
                        </div>
                        <!-- /.title-one -->
                    </div>
                </div>
			</div>
            <div class="address-banner wow fadeInUp mt-60 lg-mt-40" style="visibility: visible; animation-name: fadeInUp;">
                <div class="container">
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-between">
						<div class="block position-relative z-1 mt-25">
							<div class="d-xl-flex align-items-center">
								<div class="icon rounded-circle d-flex align-items-center justify-content-center"><img src="images/icon/icon_39.svg" alt="" class="lazy-img" style=""></div>
								<div class="text">
									<p class="fs-22">We’r always happy to help.</p>
									<!-- <a href="#" class="tran3s">cs@keysarise.co.uk</a> -->
                                    <a href="mailto:cs@keysarise.co.uk">cs@keysarise.co.uk</a>
								</div>
								<!-- /.text -->
							</div>
						</div>
						
						<!-- /.block -->
						<div class="block position-relative z-1 mt-25">
							<div class="d-xl-flex align-items-center">
								<div class="icon rounded-circle d-flex align-items-center justify-content-center"><img src="images/icon/icon_39.svg" alt="" class="lazy-img" style=""></div>
								<div class="text">
									<p class="fs-22">Live chat</p>
									<a href="https://www.keysarise.co.uk/" target="_BLANK" class="tran3s">www.keysarise.co.uk</a>
								</div>
								<!-- /.text -->
							</div>
						</div>
						<!-- /.block -->
					</div>
                </div>
            </div>
            <!-- /.address-banner -->

            
            <div class="bg-pink mt-150 xl-mt-120 md-mt-80">
                <div class="row">
                    <div class="col-xl-7 col-lg-6">
                        <div class="form-style-one wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <!-- <form action="inc/contact.php" id="contact-form" data-toggle="validator" novalidate="true"> -->
                            <form action="" method="post">
                                <h3>Send Message</h3>
                                <div class="messages"></div>
                                <div class="row controls">
                                    <div class="col-12">
                                        <div class="input-group-meta form-group mb-30">
                                            <label for="">Name*</label>
                                            <input type="text" placeholder="Your Name*" name="name" required="required" data-error="Name is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group-meta form-group mb-40">
                                            <label for="">Email*</label>
                                            <input type="email" placeholder="Email Address*" name="email" required="required" data-error="Valid email is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group-meta form-group mb-35">
                                            <textarea placeholder="Your message*" name="message" required="required" data-error="Please,leave us a message."></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-12"><button type="submit" class="btn-nine text-uppercase rounded-3 fw-normal w-100">Send Message</button></div>
                                   <?php
                                        if ($_GET['error'])
                                        {
                                            echo '<h4 class="py-3 text-danger">' . $_GET['error'] . '</h4>';
                                        }
                    
                                        
                                        if (isset($success))
                                        {
                                            echo '<h4 class="py-3 text-success">' . $success . '</h4>';
                                        }
                                        else if (isset($err))
                                        {
                                            echo '<h4 class="py-3 text-danger">' . $err . '</h4>';
                                        }
                                    ?>
                                </div>
                            </form>
                        </div> <!-- /.form-style-one -->
                    </div>
                    <div class="col-xl-5 col-lg-6 d-flex order-lg-first">
                        <div class="contact-map-banner w-100">
                            <div class="gmap_canvas h-100 w-100">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2482.7126481339988!2d-0.14478882414394745!3d51.51848760989423!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761ad5966688f5%3A0x7f597ce753ed6230!2s85%20Great%20Portland%20St%2C%20London%20W1W%207LT%2C%20UK!5e0!3m2!1sen!2sin!4v1746592461323!5m2!1sen!2sin" width="600" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>

<?php
	include_once('inc/footer.php');
?>