<?php

    session_start();

    unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'Add Property';

    //echo "<pre>";print_r($_SESSION);die;

    //If user is not logged in, redirect to login page
    if (!empty($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        //Ok
    } else {
        header("Location: login.php");
        exit();
    }

    include_once('inc/header.php');


    require 'db.php';


    //Getting Amenity List
    $stmt = $pdo->query("SELECT id, name FROM amenities ORDER BY name ASC");
    $amenities = $stmt->fetchAll();
    //echo "<pre>";print_r($amenities);die;


    //Getting Country List
    $stmt = $pdo->query("SELECT * FROM countries ORDER BY countries.name ASC");
    $countries = $stmt->fetchAll();
    //echo "<pre>";print_r($countries);

?>



    <h2 class="main-title d-block d-lg-none">
        <?php
            if (isset($_SESSION['admin_page_title']))
            {
                echo $_SESSION['admin_page_title'];
            } else {
                echo "Dashboard";
            }
        ?>
    </h2>


    <form action="save-property.php" method="POST" enctype="multipart/form-data">

        <div class="bg-white card-box border-20">
            <h4 class="dash-title-three">Overview</h4>
            <div class="dash-input-wrapper mb-30">
                <label for="">Property Title*</label>
                <input type="text" placeholder="Your Property Name" name="title">
            </div>

            <div class="dash-input-wrapper mb-30">
                <label for="">Description*</label>
                <textarea class="size-lg" placeholder="Write about property..." name="description"></textarea>
            </div>

            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Category*</label>
                        <select class="nice-select" name="category">
                            <option value="">Select Category</option>
                            <option value="Apartments">Apartments</option>
                            <option value="Condos">Condos</option>
                            <option value="Houses">Houses</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Villas">Villas</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Price*</label>
                        <input type="text" placeholder="Your Price" name="price">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white card-box border-20 mt-40">
            <h4 class="dash-title-three">Listing Details</h4>
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Size in ft*</label>
                        <input type="text" placeholder="Ex: 3,210 sqft" name="size_in_ft">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Bedrooms*</label>
                        <select class="nice-select" name="bedrooms">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Bathrooms*</label>
                        <select class="nice-select" name="bathrooms">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Kitchens*</label>
                        <select class="nice-select" name="kitchens">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Garages</label>
                        <select class="nice-select" name="garages">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Garage Size</label>
                        <input type="text" placeholder="Ex: 1,230 sqft" name="garage_size">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Year Built*</label>
                        <input type="text" placeholder="Type Year" name="year_built">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Floors No*</label>
                        <select class="nice-select" name="floors_no">
                            <option value="0">Ground</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <!--<div class="col-12">
                    <div class="dash-input-wrapper">
                        <label for="">Description*</label>
                        <textarea class="size-lg" placeholder="Write about property..."></textarea>
                    </div>
                </div>-->
            </div>
        </div>


        <div class="bg-white card-box border-20 mt-40">
            <h4 class="dash-title-three">Photo & Video Attachment</h4>
            <div class="dash-input-wrapper mb-20">
                <label for="">File Attachment*</label>
            </div>

            <div class="dash-btn-one d-inline-block position-relative me-3">
                <i class="bi bi-plus"></i>
                Upload File
                <input type="file" id="upload_files" name="upload_files[]" multiple>
            </div>
            <small>Upload file .jpg,  .png</small>
        </div>
        <!-- /.card-box -->

        <div class="bg-white card-box border-20 mt-40">
            <h4 class="dash-title-three m0 pb-5">Select Amenities</h4>
            <ul class="style-none d-flex flex-wrap filter-input">
                
                <?php
                    if (!empty($amenities))
                    {
                        foreach ($amenities as $key => $amenity)
                        {
                ?>

                <li>
                    <input type="checkbox" name="amenities[]" value="<?php echo $amenity['name']; ?>">
                    <label><?php echo $amenity['name']; ?></label>
                </li>

                <?php } } ?>


                <!--
                <li>
                    <input type="checkbox" name="amenities[]" value="01">
                    <label>A/C & Heating</label>
                </li>

                <li>
                    <input type="checkbox" name="amenities[]" value="02" placeholder="">
                    <label>Garages</label>
                </li>

                <li>
                    <input type="checkbox" name="Amenities" value="01">
                    <label>A/C & Heating</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="02" placeholder="">
                    <label>Garages</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="03">
                    <label>Swimming Pool</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="04">
                    <label>Parking</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="05">
                    <label>Lake View</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="06">
                    <label>Garden</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="07">
                    <label>Disabled Access</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="08">
                    <label>Pet Friendly</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="09">
                    <label>Ceiling Height</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="10">
                    <label>Outdoor Shower</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="11">
                    <label>Refrigerator</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="12">
                    <label>Fireplace</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="13">
                    <label>Wifi</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="14">
                    <label>TV Cable</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="15">
                    <label>Barbeque</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="16">
                    <label>Laundry</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="17">
                    <label>Dryer</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="18">
                    <label>Lawn</label>
                </li>
                <li>
                    <input type="checkbox" name="Amenities" value="19">
                    <label>Elevator</label>
                </li>-->
            </ul>
        </div>
        <!-- /.card-box -->

        <div class="bg-white card-box border-20 mt-40">
            <h4 class="dash-title-three">Address & Location</h4>
            <div class="row">
                <div class="col-12">
                    <div class="dash-input-wrapper mb-25">
                        <label for="">Address*</label>
                        <input type="text" placeholder="145/A, Ranchview" name="address">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="dash-input-wrapper mb-25">
                        <label for="">Country*</label>
                        <select class="nice-select" name="country" id="country_data">
                            <option value="">Select Country</option>

                            <?php
                                if (!empty($countries))
                                {
                                    foreach ($countries as $key => $value)
                                    {
                                        //$selected = (!empty($value['id']) && $value['id'] == $state['country_id']) ? 'selected' : '';
                                        echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="dash-input-wrapper mb-25">
                        <label for="">State*</label>
                        <select class="nice-select" name="state" id="state_data">
                            <option value="">Select State</option>

                            <option value="abc">ABC</option>

                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="dash-input-wrapper mb-25">
                        <label for="">City*</label>
                        <input type="text" placeholder="Enter City" name="city">  
                    </div>
                </div>

                <div class="col-12">
                    <div class="dash-input-wrapper mb-25">
                        <label for="">Map Location*</label>
                        <div class="position-relative">
                            <input type="text" placeholder="XC23+6XC, Moiran, N105" name="map_location">
                            <!--<button class="location-pin tran3s"><img src="../images/lazy.svg" data-src="images/icon/icon_16.svg" alt="" class="lazy-img m-auto"></button>-->
                        </div>
                        <div class="map-frame mt-30">
                            <div class="gmap_canvas h-100 w-100">
                                <iframe class="gmap_iframe h-100 w-100" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=dhaka collage&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-box -->
        <div class="button-group d-inline-flex align-items-center mt-30">
            <button type="submit" class="dash-btn-two tran3s me-3">Submit Property</button>
            <button type="reset" class="dash-btn-two tran3s me-3">Cancel</button>
        </div>				
    </div>
</div>

</form>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$('#country_data').on('change', function () {
    var countryId = $(this).val();
    $.ajax({
      url: 'get_states.php',
      type: 'POST',
      data: { country_id: countryId },
      success: function (response) {
        //alert(response);
        $('#state_data').html(response);
      }
    });
});
</script>



<?php
	include_once('inc/footer.php');
?>