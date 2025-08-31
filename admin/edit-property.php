<?php

    session_start();

    unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'Edit Property';

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

    $id = $_GET['id'] ?? null;
    if (!$id) die("ID missing");


    //Get Property data
    if ($id)
    {
        $stmt = $pdo->prepare("SELECT properties.* FROM properties WHERE is_deleted = 1 AND id = :id ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        // Output for testing
        //echo '<pre>';print_r($property);
    } else {
        echo "ID not provided.";die;
    }




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


    <form action="update-property.php?id=<?php echo $property['id']; ?>" method="POST" enctype="multipart/form-data">

        <div class="bg-white card-box border-20">
            <h4 class="dash-title-three">Overview</h4>
            <div class="dash-input-wrapper mb-30">
                <label for="">Property Title*</label>
                <input type="text" placeholder="Your Property Name" name="title" value="<?php echo $property['title']; ?>">
            </div>

            <div class="dash-input-wrapper mb-30">
                <label for="">Description*</label>
                <textarea class="size-lg" placeholder="Write about property..." name="description"><?php echo $property['description']; ?></textarea>
            </div>

            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Category*</label>
                        <select class="nice-select" name="category">
                            <option value="">Select Category</option>
                            <option value="Apartments" <?php if(!empty($property['category']) && $property['category'] == 'Apartments') { echo "selected"; } ?>>Apartments</option>
                            <option value="Condos" <?php if(!empty($property['category']) && $property['category'] == 'Condos') { echo "selected"; } ?>>Condos</option>
                            <option value="Houses" <?php if(!empty($property['category']) && $property['category'] == 'Houses') { echo "selected"; } ?>>Houses</option>
                            <option value="Industrial" <?php if(!empty($property['category']) && $property['category'] == 'Industrial') { echo "selected"; } ?>>Industrial</option>
                            <option value="Villas" <?php if(!empty($property['category']) && $property['category'] == 'Villas') { echo "selected"; } ?>>Villas</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Price*</label>
                        <input type="text" placeholder="Your Price" name="price" value="<?php echo $property['price'] ?>">
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
                        <input type="text" placeholder="Ex: 3,210 sqft" name="size_in_ft" value="<?php echo $property['size_in_ft'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Bedrooms*</label>
                        <select class="nice-select" name="bedrooms">
                            <option value="0" <?php if(!empty($property['bedrooms']) && $property['bedrooms'] == '0') { echo "selected"; } ?>>0</option>
                            <option value="1" <?php if(!empty($property['bedrooms']) && $property['bedrooms'] == '1') { echo "selected"; } ?>>1</option>
                            <option value="2" <?php if(!empty($property['bedrooms']) && $property['bedrooms'] == '2') { echo "selected"; } ?>>2</option>
                            <option value="3" <?php if(!empty($property['bedrooms']) && $property['bedrooms'] == '3') { echo "selected"; } ?>>3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Bathrooms*</label>
                        <select class="nice-select" name="bathrooms">
                            <option value="0" <?php if(!empty($property['bathrooms']) && $property['bathrooms'] == '0') { echo "selected"; } ?>>0</option>
                            <option value="1" <?php if(!empty($property['bathrooms']) && $property['bathrooms'] == '1') { echo "selected"; } ?>>1</option>
                            <option value="2" <?php if(!empty($property['bathrooms']) && $property['bathrooms'] == '2') { echo "selected"; } ?>>2</option>
                            <option value="3" <?php if(!empty($property['bathrooms']) && $property['bathrooms'] == '3') { echo "selected"; } ?>>3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Kitchens*</label>
                        <select class="nice-select" name="kitchens">
                            <option value="0" <?php if(!empty($property['kitchens']) && $property['kitchens'] == '0') { echo "selected"; } ?>>0</option>
                            <option value="1" <?php if(!empty($property['kitchens']) && $property['kitchens'] == '1') { echo "selected"; } ?>>1</option>
                            <option value="2" <?php if(!empty($property['kitchens']) && $property['kitchens'] == '2') { echo "selected"; } ?>>2</option>
                            <option value="3" <?php if(!empty($property['kitchens']) && $property['kitchens'] == '3') { echo "selected"; } ?>>3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Garages</label>
                        <select class="nice-select" name="garages">
                            <option value="0" <?php if(!empty($property['garages']) && $property['garages'] == '0') { echo "selected"; } ?>>0</option>
                            <option value="1" <?php if(!empty($property['garages']) && $property['garages'] == '1') { echo "selected"; } ?>>1</option>
                            <option value="2" <?php if(!empty($property['garages']) && $property['garages'] == '2') { echo "selected"; } ?>>2</option>
                            <option value="3" <?php if(!empty($property['garages']) && $property['garages'] == '3') { echo "selected"; } ?>>3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Garage Size</label>
                        <input type="text" placeholder="Ex: 1,230 sqft" name="garage_size" value="<?php echo $property['garage_size'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Year Built*</label>
                        <input type="text" placeholder="Type Year" name="year_built" value="<?php echo $property['year_built'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-input-wrapper mb-30">
                        <label for="">Floors No*</label>
                        <select class="nice-select" name="floors_no">
                            <option value="0" <?php if(!empty($property['floors_no']) && $property['floors_no'] == '0') { echo "selected"; } ?>>Ground</option>
                            <option value="1" <?php if(!empty($property['floors_no']) && $property['floors_no'] == '1') { echo "selected"; } ?>>1</option>
                            <option value="2" <?php if(!empty($property['floors_no']) && $property['floors_no'] == '2') { echo "selected"; } ?>>2</option>
                            <option value="3" <?php if(!empty($property['floors_no']) && $property['floors_no'] == '3') { echo "selected"; } ?>>3</option>
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


            <div class="row mt-5">
                <?php
                    //Get Property assets data
                    $stmt = $pdo->prepare("SELECT * FROM property_assets WHERE p_id = :id ORDER BY id DESC");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $property_assets = $stmt->fetchAll();

                    // Output for testing
                    //echo '<pre>';print_r($property_assets);
                    if (!empty($property_assets))
                    {
                        foreach ($property_assets as $key => $p_image)
                        {
                ?>
                <div class="col-md-2 position-relative">
                    <a href="javascript:;">
                        <img src="<?php echo $p_image['uploded_files']; ?>" alt="" width="100%">
                    </a>
                    <a href="delete_property_image.php?id=<?php echo $p_image['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this image?')" 
                       style="position:absolute; top:5px; right:5px; color:red; font-size:18px; text-decoration:none;">
                        ✖
                    </a>
                </div>
                <?php } } ?>
            </div>

        </div>
        <!-- /.card-box -->

        <div class="bg-white card-box border-20 mt-40">
            <h4 class="dash-title-three m0 pb-5">Select Amenities</h4>
            <ul class="style-none d-flex flex-wrap filter-input">
                
                <?php
                    if (!empty($amenities))
                    {
                        $selectedAmenities = explode(',', $property['amenities'] ?? '');
                        foreach ($amenities as $key => $amenity)
                        {
                            $isChecked = in_array($amenity['name'], $selectedAmenities) ? 'checked' : '';
                ?>

                <li>
                    <input type="checkbox" name="amenities[]" value="<?php echo $amenity['name']; ?>" <?php echo $isChecked; ?>>
                    <label><?php echo $amenity['name']; ?></label>
                </li>

                <?php } } ?>

            </ul>
        </div>
        <!-- /.card-box -->

        <div class="bg-white card-box border-20 mt-40">
            <h4 class="dash-title-three">Address & Location</h4>
            <div class="row">
                <div class="col-12">
                    <div class="dash-input-wrapper mb-25">
                        <label for="">Address*</label>
                        <input type="text" placeholder="145/A, Ranchview" name="address" value="<?php echo $property['address'] ?>">
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
                                        $selected = (!empty($value['id']) && $value['id'] == $property['country']) ? 'selected' : '';
                                        echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
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
                        <input type="text" placeholder="Enter City" name="city" value="<?php echo $property['city'] ?>">  
                    </div>
                </div>

                <div class="col-12">
                    <div class="dash-input-wrapper mb-25">
                        <label for="">Map Location*</label>
                        <div class="position-relative">
                            <input type="text" placeholder="XC23+6XC, Moiran, N105" name="map_location" value="<?php echo $property['map_location'] ?>">
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