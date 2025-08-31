<?php
    
    session_start();
    //echo "<pre>";print_r($_SESSION);die;
    if (empty($_SESSION) && $_SESSION['user_id'] == '')
    {
        header("Location: login.php");
        exit;
    }


    error_reporting(E_ALL);
    ini_set('display_errors', '1');


    //Including Header
    include('inc/header.php');



    //Including DB Connection
    include_once('inc/config.php');



    if (empty($_SESSION) && $_SESSION['user_id'] == '')
    {
        header("Location: login.php");
    } else {
        //$current_user_id = $_SESSION['user_id'];
        $current_user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
        $current_user_email = mysqli_real_escape_string($conn, $_SESSION['email']);
        $current_user_name = mysqli_real_escape_string($conn, $_SESSION['name']);
        //echo "<p>CURRENT USER ID: " . $current_user_id .', EMAIL: '.$current_user_email.', Name: '.$current_user_name.'</p>';



        //Getting all data for render on profile page
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

        //echo "<pre>";print_r($user);
    }


?>


<style>
  .step-container {
      position: relative;
      text-align: center;
      transform: translateY(-43%);
  }

  .step-circle {
    
  }

  .step-line {
      position: absolute;
      top: 16px;
      left: 50px;
      width: calc(100% - 100px);
      height: 2px;
      background-color: #007bff;
      z-index: -1;
  }

  #multi-step-form{
      overflow-x: hidden;
  }
</style>

		<div class="inner-banner-one inner-banner bg-pink text-center z-1 pt-160 lg-pt-130 pb-160 xl-pb-120 md-pb-80 position-relative">
  			<div class="container">
            <h3 class="mb-35 xl-mb-20 pt-15">Profile</h3>
            <ul class="theme-breadcrumb style-none d-inline-flex align-items-center justify-content-center position-relative z-1 bottom-line">
                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li>/</li>
                <li>Profile</li>
            </ul>
  			</div>

  			<img src="images/lazy.svg" data-src="assets/images/assets/ils_07.svg" alt="" class="lazy-img shapes w-100 illustration">
		</div>

		
<div class="contact-us custom border-top pt-80 pb-80">
		<div class="container">
        <div class="row">
            <div class="progress px-1" style="height: 3px;">
                <div class="progress-bar" role="progressbar" style="width: 33.3%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <div class="step-container d-flex justify-content-between">
                <div class="step-circle" onclick="displayStep(1)">Basic</div>
                <div class="step-circle" onclick="displayStep(2)">Personal Details</div>
                <div class="step-circle" onclick="displayStep(3)">Documents</div>
            </div>



  <form id="multi-step-form" method="POST" enctype="multipart/form-data" action="process_form.php">
    <div class="step step-1">
      <!-- Step 1 form fields here -->
      <h4>Basic Information</h4>
      
      <div class="row">
          <div class="col-md-3">
              <div class="upload">
                  <img src="uploads/profiles/<?php echo $user['profile_image']; ?>" class="img-fluid mb-1" alt="Profile">
                  <div class="form-group">
                    <label for="profile">Update Profile</label>
                    <input type="file" class="form-control-file" id="profile" name="profile_image">
                  </div>
              </div>
          </div>

          <div class="col-md-9">
              <div class="form-row mb-2">
                <div class="row">
                    <div class="col-md-6">
                      <label>First Name</label>
                      <input type="text" class="form-control" placeholder="First Name" name="first_name" value="<?php echo $user['first_name']; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Last Name</label>
                      <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="<?php echo $user['last_name']; ?>">
                    </div>
                </div>
              </div>
              <div class="form-row mb-2">
                <div class="row">
                    <div class="col-md-6">
                      <label>Gender</label>
                      <select id="inputState" class="form-control" name="gender">
                        <option value="">Choose Gender</option>
                        <option value="Male" <?php if(!empty($user) && $user['gender'] == 'Male') { echo "selected"; } ?>>Male</option>
                        <option value="Female" <?php if(!empty($user) && $user['gender'] == 'Female') { echo "selected"; } ?>>Female</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Date of Birth</label>
                      <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $user['dob']; ?>">
                    </div>
                </div>
              </div>
              <div class="form-row">
                <div class="row">
                    <div class="col-md-6">
                      <label>Select Country</label>
                      <select id="inputState" class="form-control" name="country">
                        <option value="">Choose Country</option>
                        <option value="India" <?php if(!empty($user) && $user['country'] == 'India') { echo "selected"; } ?>>India</option>
                        <option value="US" <?php if(!empty($user) && $user['country'] == 'US') { echo "selected"; } ?>>US</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Phone Number</label>
                      <input type="text" class="form-control" placeholder="Phone Number" name="phone" id="phone" maxlength="10" value="<?php echo $user['phone']; ?>">
                    </div>
                </div>
              </div>
          </div>
      </div>


      <div class="text-right">
        <button type="button" class="btn btn-primary next-step">Next</button>
      </div>

    </div>




    <div class="step step-2">
      <!-- Step 2 form fields here -->
      <h4>Address and Bank</h4>
      
       <div class="row mb-3">
          <div class="col-md-12">
              <h6 class="text-danger">PERMANENT ADDRESS</h6>
              <div class="form-row mb-2">
                <div class="row">
                    <div class="col-md-6">
                      <label>Select Country</label>
                      <select id="inputState" class="form-control" name="addr_country">
                        <option value="">Choose Country</option>
                        <option value="India" <?php if(!empty($user) && $user['addr_country'] == 'India') { echo "selected"; } ?>>India</option>
                        <option value="US" <?php if(!empty($user) && $user['addr_country'] == 'US') { echo "selected"; } ?>>US</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>City</label>
                      <input type="text" class="form-control" placeholder="Enter City" name="addr_city" value="<?php echo $user['addr_city']; ?>">
                    </div>
                </div>
              </div>
              <div class="form-row">
                <div class="row">
                    <div class="col-md-6">
                      <label>House Number</label>
                      <input type="text" class="form-control" placeholder="Enter House Number" name="addr_house_no" value="<?php echo $user['addr_house_no']; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Street</label>
                      <input type="text" class="form-control" placeholder="Enter Street Number" name="addr_street" value="<?php echo $user['addr_street']; ?>">
                    </div>
                </div>
              </div>
              <div class="form-row">
                <div class="row">
                    <div class="col-md-6">
                      <label>Postcode / ZIP</label>
                      <input type="text" class="form-control" placeholder="Enter Zipcode/Pincode" name="addr_zip" id="addr_zip" maxlength="6" value="<?php echo $user['addr_zip']; ?>">
                    </div>
                </div>
              </div>
          </div>
          <div class="col-md-12 mt-3">
              <h6 class="text-danger">BANK ACCOUNT</h6>
              <div class="form-row mb-2">
                <div class="row">
                    <div class="col-md-6">
                      <label>Bank Account Number</label>
                      <input type="text" class="form-control" placeholder="Enter Bank Account Number" name="addr_bank_account_number" id="addr_bank_account_number" maxlength="20" value="<?php echo $user['addr_bank_account_number']; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>IBAN</label>
                      <input type="text" class="form-control" placeholder="Enter IBAN" name="addr_bank_iban" value="<?php echo $user['addr_bank_iban']; ?>">
                    </div>
                </div>
              </div>
              <div class="form-row">
                <div class="row">
                    <div class="col-md-6">
                      <label>Select Country</label>
                      <select id="inputState" class="form-control" name="addr_bank_country">
                        <option value="">Choose Country</option>
                        <option value="India" <?php if(!empty($user) && $user['addr_bank_country'] == 'India') { echo "selected"; } ?>>India</option>
                        <option value="US" <?php if(!empty($user) && $user['addr_bank_country'] == 'US') { echo "selected"; } ?>>US</option>
                      </select>
                    </div>

                    <!-- <div class="col-md-6">
                        <button type="button" class="btn btn-secondary mt-4">Add Another Account</button>
                    </div> -->

                </div>
              </div>
          </div>
      </div>


      <div class="text-right">
          <button type="button" class="btn btn-primary prev-step">Previous</button>
          <button type="button" class="btn btn-primary next-step">Next</button>
      </div>


    </div>

    <div class="step step-3">
      <!-- Step 3 form fields here -->
      <h4>ID Documents</h4>
     
      <div class="row mb-3">
          <div class="col-md-12">
              <h6 class="text-danger">IDENTITY VERIFICATION</h6>
              <p class="bg-warning">You need to have fully filled <strong>Address & Bank</strong> Information first!</p>
              <div class="form-row mb-2">
                  <h6 class="text-danger">Your Personal Document Number 1</h6>
                <div class="row">
                    <div class="col-md-6">
                      <label>Type of Document</label>
                      <select id="inputState" class="form-control" name="docs_doc_type">
                        <option value="">Select a Document Type</option>
                        <option value="Aadhar Card" <?php if(!empty($user) && $user['docs_doc_type'] == 'Aadhar Card') { echo "selected"; } ?>>Aadhar Card</option>
                        <option value="Pancard" <?php if(!empty($user) && $user['docs_doc_type'] == 'Pancard') { echo "selected"; } ?>>Pancard</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Document Number</label>
                      <input type="text" class="form-control" name="docs_doc_number" value="<?php echo $user['docs_doc_number']; ?>">
                    </div>
                </div>
              </div>
              <div class="form-row mb-20">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                          <input type="file" class="form-control" name="docs_front_img">
                          <label class="input-group-text">Upload Front</label>
                          <small>Upload a colour image of the entire document. JPG, PNG, or PDF format only.
                              <?php
                                  if (!empty($user) && !empty($user['docs_front_img']))
                                  {
                              ?>
                                      <span class="btn btn-warning"><a target="_blank" href="uploads/documents/<?php echo $user['docs_front_img']; ?>">View File</a></span>
                              <?php
                                  }
                              ?>
                          </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                          <input type="file" class="form-control" name="docs_back_img">
                          <label class="input-group-text">Upload Back(If Applicable)</label>
                          <small>Upload a colour image of the entire document. JPG, PNG, or PDF format only.
                              <?php
                                  if (!empty($user) && !empty($user['docs_back_img']))
                                  {
                              ?>
                                      <span class="btn btn-warning"><a target="_blank" href="uploads/documents/<?php echo $user['docs_back_img']; ?>">View File</a></span>
                              <?php
                                  }
                              ?>
                          </small>
                        </div>
                    </div>
                </div>
              </div>
              <div class="form-row mb-2">
                  <h6 class="text-danger">Your Personal Document Number 2</h6>
                <div class="row">
                    <div class="col-md-6">
                      <label>Type of Document</label>
                      <select id="inputState" class="form-control" name="docs_doc_type2">
                        <option value="">Select a Document Type</option>
                        <option value="Aadhar Card" <?php if(!empty($user) && $user['docs_doc_type2'] == 'Aadhar Card') { echo "selected"; } ?>>Aadhar Card</option>
                        <option value="Pancard" <?php if(!empty($user) && $user['docs_doc_type2'] == 'Pancard') { echo "selected"; } ?>>Pancard</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Document Number</label>
                      <input type="text" class="form-control" name="docs_doc_number2" value="<?php echo $user['docs_doc_number2']; ?>">
                    </div>
                </div>
              </div>
              <div class="form-row mb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                          <input type="file" class="form-control" name="docs_front_img2">
                          <label class="input-group-text">Upload Front</label>
                          <small>Upload a colour image of the entire document. JPG, PNG, or PDF format only.
                              <?php
                                  if (!empty($user) && !empty($user['docs_front_img2']))
                                  {
                              ?>
                                      <span class="btn btn-warning"><a target="_blank" href="uploads/documents/<?php echo $user['docs_front_img2']; ?>">View File</a></span>
                              <?php
                                  }
                              ?>
                          </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                          <input type="file" class="form-control" name="docs_back_img2">
                          <label class="input-group-text">Upload Back(If Applicable)</label>
                          <small>Upload a colour image of the entire document. JPG, PNG, or PDF format only. 
                              <?php
                                  if (!empty($user) && !empty($user['docs_back_img2']))
                                  {
                              ?>
                                      <span class="btn btn-warning"><a target="_blank" href="uploads/documents/<?php echo $user['docs_back_img2']; ?>">View File</a></span>
                              <?php
                                  }
                              ?>
                          </small>
                        </div>
                    </div>
                </div>
              </div>
          </div>
      </div>
     <div class="text-right">
      <button type="button" class="btn btn-primary prev-step">Previous</button>
      <button type="submit" class="btn btn-success">Submit Verification</button>
      </div>
    </div>
  </form>

  
</div>
</div>
</div>



<?php
	include_once('inc/footer.php');
?>



<script>
var currentStep = 1;
var updateProgressBar;

function displayStep(stepNumber) {
    if (stepNumber >= 1 && stepNumber <= 2) {
      $(".step-" + currentStep).hide();
      $(".step-" + stepNumber).show();
      currentStep = stepNumber;
      updateProgressBar();
    }
}

  $(document).ready(function() {
    $('#multi-step-form').find('.step').slice(1).hide();
  
    $(".next-step").click(function() {
      if (currentStep < 3) {
        $(".step-" + currentStep).addClass("animate__animated animate__fadeOutLeft");
        currentStep++;
        setTimeout(function() {
          $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
          $(".step-" + currentStep).show().addClass("animate__animated animate__fadeInRight");
          updateProgressBar();
        }, 500);
      }
    });

    $(".prev-step").click(function() {
      if (currentStep > 1) {
        $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
        currentStep--;
        setTimeout(function() {
          $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
          $(".step-" + currentStep).show().addClass("animate__animated animate__fadeInLeft");
          updateProgressBar();
        }, 500);
      }
    });

    updateProgressBar = function() {
      var progressPercentage = ((currentStep - 1) / 3) * 100;
      $(".progress-bar").css("width", progressPercentage + "%");
    }
  });



document.getElementById('phone').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

document.getElementById('addr_zip').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

document.getElementById('addr_bank_account_number').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dob').setAttribute('max', today);
});
</script>	