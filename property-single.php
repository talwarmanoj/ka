<?php

    session_start();


    //Include DB Connection
    include_once('inc/config.php');
        

    // Getting all properties
    if (isset($_GET['id']) && !empty($_GET['id']))
    {
        $p_id = $_GET['id'];

        $is_deleted = 1;
        $sql = "SELECT * FROM properties WHERE id = ? AND is_deleted = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $p_id, $is_deleted);
        $stmt->execute();
        $result = $stmt->get_result();
        $property = $result->fetch_assoc();

        //echo "<pre>";print_r($result->num_rows);die;
        //echo "<pre>";print_r($property);die;

        if (empty($property) && empty($property['id']))
        {
            header("Location: index.php?error=Something went wrong.");
            exit;
        }
    }
    else
    {        
        header("Location: index.php?error=Something went wrong.");
        exit;
    }


    include_once('inc/header.php');



?>




<div class="listing-details-one theme-details-one bg-pink pt-180 lg-pt-150 pb-150 xl-pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="property-titlee">
                    <?php
                        if (!empty($property['title']))
                        {
                            echo $property['title'];
                        } else {
                            echo "NA";
                        }
                    ?>
                </h3>
                <div class="d-flex flex-wrap mt-10">
                    <div class="list-type text-uppercase border-20 mt-15 me-3">FOR SELL</div>
                    <div class="address mt-15"><i class="bi bi-geo-alt"></i> 
                        <?php
                            if (!empty($property['address']))
                            {
                                echo $property['address'];
                            }

                            //City
                            if (!empty($property['city']))
                            {
                                echo ', ' . $property['city'];
                            }

                            //State
                            if (!empty($property['state']))
                            {
                                echo ', ' . $property['state'];
                            }

                            //Country
                            if (!empty($property['country']))
                            {
                                //echo ', ' . $property['country'];
                                $country_id = $property['country'];

                                $sql2 = "SELECT * FROM countries WHERE id = ?";
                                $stmt2 = $conn->prepare($sql2);
                                $stmt2->bind_param("s", $country_id);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                $country_details = $result2->fetch_assoc();
                                //echo "<pre>";print_r($country_details);

                                echo ', ' . $country_details['name'];
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-lg-end">
                <div class="d-inline-block md-mt-40">
                    <div class="price color-dark fw-500">
                        <?php
                            if (!empty($property['price']))
                            {
                                echo 'Price: $' . $property['price'];
                            } else {
                                echo "Price: $0";
                            }
                        ?>
                    </div>
                    <div class="est-price fs-20 mt-25 mb-35 md-mb-30">Est. Payment <span class="fw-500 color-dark">$8,343/mo*</span></div>
                    <ul class="style-none d-flex align-items-center action-btns">
                        <li class="me-auto fw-500 color-dark"><i class="fa-sharp fa-regular fa-share-nodes me-2"></i> Share</li>
                        <li><a href="#" class="d-flex align-items-center justify-content-center rounded-circle tran3s"><i class="fa-light fa-heart"></i></a></li>
                        <li><a href="#" class="d-flex align-items-center justify-content-center rounded-circle tran3s"><i class="fa-light fa-bookmark"></i></a></li>
                        <li><a href="#" class="d-flex align-items-center justify-content-center rounded-circle tran3s"><i class="fa-light fa-circle-plus"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="media-gallery bg-white shadow4 p-40 border-20 mt-80 lg-mt-50 mb-60">
            <div id="media_slider" class="carousel slide row style-two">
                <div class="col-12">
                    <div class="position-relative z-1 overflow-hidden border-20">

                        <?php
                            //Getting all images
                            $p_id = $property['id'];
                            $sql_assets = "SELECT * FROM property_assets WHERE p_id = ? ORDER BY id DESC";
                            $stmt_assets = $conn->prepare($sql_assets);
                            $stmt_assets->bind_param("s", $p_id);
                            $stmt_assets->execute();
                            $result_assets = $stmt_assets->get_result();
                            $property_assets = $result_assets->fetch_all(MYSQLI_ASSOC);

                            //echo "Total Images: " . $result_assets->num_rows;
                            //echo "<pre>";print_r($property_assets);die;
                        ?>
                        <div class="img-fancy-btn border-10 fw-500 fs-16 color-dark">
                            <?php
                                if(isset($result_assets) && $result_assets->num_rows > 0)
                                {
                                    echo 'Sell all '.$result_assets->num_rows.' Photos';

                                    foreach ($property_assets as $key => $property_asset)
                                    {
                            ?>
                            
                            <a href="admin/<?php echo $property_asset['uploded_files']; ?>" class="d-block" data-fancybox="mainImg" data-caption="<?php echo $property['title']; ?>"></a>

                            <!--<a href="images/listing/img_large_02.jpg" class="d-block" data-fancybox="mainImg" data-caption="Duplex orkit villa."></a>
                            <a href="images/listing/img_large_03.jpg" class="d-block" data-fancybox="mainImg" data-caption="Duplex orkit villa."></a>-->

                        <?php } } ?>
                        </div>

                        <div class="theme-sidebar-one d-none d-xl-block">
                            <div class="agent-info bg-white border-20 p-30">
                                <img src="assets/images/lazy.svg" data-src="assets/images/agent/img_06.jpg" alt="" class="lazy-img rounded-circle ms-auto me-auto avatar">
                                <div class="text-center mt-25 xl-mt-20">
                                    <h6 class="name">Rashed Kabir</h6>
                                    <p class="fs-16">Property Agent & Broker</p>
                                    <ul class="style-none d-flex align-items-center justify-content-center social-icon">
                                        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                                <div class="divider-line mt-40 xl-mt-30 mb-45 pt-20">
                                    <ul class="style-none">
                                        <li>Location: <span>Spain, Barcelona</span></li>
                                        <li>Email: <span><a href="mailto:akabirr770@gmail.com">akabirr770@gmail.com</a></span></li>
                                        <li>Phone: <span><a href="tel:+12347687565">+12347687565</a></span></li>
                                    </ul>
                                </div>
                                <!-- /.divider-line -->
                                <a href="contact.html" class="btn-nine text-uppercase rounded-3 w-100 mb-10">CONTACT AGENT</a>
                            </div>
                            <!-- /.agent-info -->
                        </div>
                        <!-- /.theme-sidebar-one -->
                        <div class="carousel-inner">
                            <?php
                                if (!empty($property_assets))
                                {
                                    foreach ($property_assets as $key => $property_asset)
                                    {
                            ?>
                                    <div class="carousel-item active">
                                        <img src="admin/<?php echo $property_asset['uploded_files']; ?>" alt="" class="border-20 w-100">
                                    </div>
                            <?php
                                    }
                                }
                            ?>
                            <!--<div class="carousel-item active">
                                <img src="assets/images/listing/img_52.jpg" alt="" class="border-20 w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/listing/img_53.jpg" alt="" class="border-20 w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/listing/img_54.jpg" alt="" class="border-20 w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/listing/img_55.jpg" alt="" class="border-20 w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/listing/img_56.jpg" alt="" class="border-20 w-100">
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="position-relative mt-25 xs-mt-10">
                        <div class="carousel-indicators d-flex justify-content-between justify-content-xl-start position-relative w-100 h-100">

                            <?php
                                if (!empty($property_assets))
                                {
                                    foreach ($property_assets as $key => $property_asset)
                                    {
                            ?>
                            <button type="button" data-bs-target="#media_slider" data-bs-slide-to="<?php echo $key; ?>" class="active" aria-current="true" aria-label="Slide 1">
                                <img src="admin/<?php echo $property_asset['uploded_files']; ?>" alt="" class="border-10 w-100">
                            </button>
                            <?php
                                    }
                                }
                            ?>

                            <!--<button type="button" data-bs-target="#media_slider" data-bs-slide-to="1" aria-label="Slide 2">
                                <img src="assets/images/listing/img_44_s.jpg" alt="" class="border-10 w-100">
                            </button>
                            <button type="button" data-bs-target="#media_slider" data-bs-slide-to="2" aria-label="Slide 3">
                                <img src="assets/images/listing/img_45_s.jpg" alt="" class="border-10 w-100">
                            </button>
                            <button type="button" data-bs-target="#media_slider" data-bs-slide-to="3" aria-label="Slide 4">
                                <img src="assets/images/listing/img_46_s.jpg" alt="" class="border-10 w-100">
                            </button>
                            <button type="button" data-bs-target="#media_slider" data-bs-slide-to="4" aria-label="Slide 5">
                                <img src="assets/images/listing/img_56_s.jpg" alt="" class="border-10 w-100">
                            </button>-->
                        </div>
                        <div class="carousel-arrow d-none d-xl-flex">
                            <button class="carousel-control-prev" type="button" data-bs-target="#media_slider" data-bs-slide="prev">
                                <i class="bi bi-chevron-left"></i>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#media_slider" data-bs-slide="next">
                                <i class="bi bi-chevron-right"></i>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <!-- /.carousel-arrow -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.media-gallery -->
        <div class="row">
            <div class="col-xl-8">
                <div class="bg-white shadow4 border-20">
                    <div class="property-overview p-40">
                        <h4 class="mb-20">Overview</h4>
                        <p class="fs-20 lh-lg">
                            <?php
                                //Description
                                if (!empty($property['description']))
                                {
                                    echo $property['description'];
                                }
                            ?>
                        </p>
                        <div class="property-feature-list mt-40">
                            <ul class="style-none d-flex flex-wrap align-items-center justify-content-between">
                                <li>
                                    <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_47.svg" alt="" class="lazy-img icon">
                                    <span class="fs-20 color-dark">
                                        <?php
                                            //size_in_ft
                                            if (!empty($property) && $property['size_in_ft'] != '')
                                            {
                                                echo "Sqft . " . $property['size_in_ft'];
                                            }
                                        ?>
                                    </span>
                                </li>
                                <li>
                                    <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_48.svg" alt="" class="lazy-img icon">
                                    <span class="fs-20 color-dark">
                                        <?php
                                            //Bed
                                            if (!empty($property) && $property['bedrooms'] != '')
                                            {
                                                echo "Bed . " . $property['bedrooms'];
                                            }
                                        ?>
                                    </span>
                                </li>
                                <li>
                                    <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_49.svg" alt="" class="lazy-img icon">
                                    <span class="fs-20 color-dark">
                                        <?php
                                            //Bath
                                            if (!empty($property) && $property['bathrooms'] != '')
                                            {
                                                echo "Bath . " . $property['bathrooms'];
                                            }
                                        ?>
                                    </span>
                                </li>
                                <li>
                                    <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_50.svg" alt="" class="lazy-img icon">
                                    <span class="fs-20 color-dark">
                                        <?php
                                            //echo $property['kitchens'];
                                            if (!empty($property) && $property['kitchens'] != '')
                                            {
                                                echo "Kitchen . " . $property['kitchens'];
                                            }
                                        ?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <!-- /.property-feature-list -->
                    </div>
                    <!-- /.property-overview -->
                    <div class="property-feature-accordion border-top p-40">
                        <h4 class="mb-20">Property Features</h4>
                        <p class="fs-20 lh-lg">Risk management and compliance, when approached strategically, have the potential to go beyond mitigating threats.</p>
                        <h5 class="pt-30 pb-25">Property Details</h5>
                        <div class="feature-list-two">
                            <ul class="style-none d-flex flex-wrap justify-content-between">
                                <li><span>Bedrooms: </span> <span class="fw-500 color-dark"><?php if(!empty($property['bedrooms'])) { echo $property['bedrooms']; } else { echo "0"; } ?></span></li>

                                <li><span>Furnishing: </span> <span class="fw-500 color-dark">Semi furnished</span></li>

                                <li><span>Bathrooms: </span> <span class="fw-500 color-dark"><?php if(!empty($property['bathrooms'])) { echo $property['bathrooms']; } else { echo "0"; } ?></span></li>

                                <li><span>Year Built: </span> <span class="fw-500 color-dark"><?php if(!empty($property['year_built'])) { echo $property['year_built']; } else { echo "0"; } ?></span></li>

                                <li><span>Floor: </span> <span class="fw-500 color-dark">Ground</span></li>

                                <li><span>Garage: </span> <span class="fw-500 color-dark"><?php if(!empty($property['garages'])) { echo $property['garages']; } else { echo "0"; } ?></span></li>

                                <li><span>Ceiling Height: </span> <span class="fw-500 color-dark">3.2m</span></li>

                                <li><span>Garage Size: </span> <span class="fw-500 color-dark"><?php if(!empty($property['garage_size'])) { echo $property['garage_size']; } else { echo "0"; } ?></span></li>

                                <li><span>Renovation: </span> <span class="fw-500 color-dark">3.2m</span></li>

                                <li><span>Status: </span> <span class="fw-500 color-dark">For Sale</span></li>
                            </ul>
                        </div>
                        <!-- /.feature-list-two -->
                    </div>
                    <!-- /.property-feature-accordion -->

                    <div class="property-amenities border-top p-40">
                        <h4 class="mb-20">Amenities</h4>
                        <p class="fs-20 lh-lg pb-25">Risk management & compliance, when approached strategically, have the potential</p>
                        <ul class="style-none d-flex flex-wrap justify-content-between list-style-two">
                            <?php
                                if (!empty($property['amenities']))
                                {
                                    $amenities = explode(',', $property['amenities']);
                                    //echo "<pre>";print_r($amenities);
                                    foreach ($amenities as $key => $amenity)
                                    {
                                        echo '<li>'.$amenity.'</li>';
                                    }
                                }
                            ?>
                        </ul>
                        <!-- /.list-style-two -->
                    </div>
                    <!-- /.property-amenities -->

                    <div class="property-video-tour border-top p-40">
                        <h4 class="mb-30">Video Tour</h4>
                        <div class="position-relative border-15 image-bg overflow-hidden z-1">
                            <img src="assets/images/lazy.svg" data-src="assets/images/listing/img_47.jpg" alt="" class="lazy-img w-100">
                            <a class="video-icon tran3s rounded-circle d-flex align-items-center justify-content-center" data-fancybox href="https://www.youtube.com/embed/aXFSJTjVjw0">
                                <i class="fa-thin fa-play"></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.property-video-tour -->

                    <div class="property-floor-plan border-top p-40">
                        <h4 class="mb-40">Floor Plans</h4>
                        <div class="mt-45">
                            <div class="accordion" id="accordionTwo">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                            <div class="d-flex justify-content-between w-100">
                                                <span class="fw-500 color-dark">1st Floor</span>
                                                <ul class="style-none d-flex flex-wrap align-items-center justify-content-between">
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_56.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">1370</span> sqft</span>
                                                    </li>
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_48.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">03</span> bed</span>
                                                    </li>
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_57.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">02</span> bath</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>
                                      </h2>
                                    <div id="collapseOneA" class="accordion-collapse collapse show" data-bs-parent="#accordionTwo">
                                        <div class="accordion-body">
                                            <img src="assets/images/listing/floor_3.jpg" alt="" class="w-100 border-10">
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                            <div class="d-flex justify-content-between w-100">
                                                <span class="fw-500 color-dark">2nd Floor</span>
                                                <ul class="style-none d-flex flex-wrap align-items-center justify-content-between">
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_56.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">1145</span> sqft</span>
                                                    </li>
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_48.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">02</span> bed</span>
                                                    </li>
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_57.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">02</span> bath</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionTwo">
                                        <div class="accordion-body">
                                            <img src="assets/images/listing/floor_3.jpg" alt="" class="w-100 border-10">
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                            <div class="d-flex justify-content-between w-100">
                                                <span class="fw-500 color-dark">3rd Floor</span>
                                                <ul class="style-none d-flex flex-wrap align-items-center justify-content-between">
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_56.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">1245</span> sqft</span>
                                                    </li>
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_48.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">02</span> bed</span>
                                                    </li>
                                                    <li>
                                                        <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_57.svg" alt="" class="lazy-img icon">
                                                        <span><span class="fw-500">01</span> bath</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionTwo">
                                        <div class="accordion-body">
                                            <img src="assets/images/listing/floor_3.jpg" alt="" class="w-100 border-10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.property-floor-plan -->

                    <div class="property-nearby border-top p-40">
                        <h4 class="mb-20">What’s Nearby</h4>
                        <p class="fs-20 lh-lg pb-30">Risk management and compliance, when approached strategically, have th potential to go beyond mitigating threats.</p>
                        <ul class="style-none d-flex flex-wrap justify-content-between nearby-list-item">
                            <li>School & Collage: <span class="fw-500 color-dark">0.9km</span></li>
                            <li>Grocery Center: <span class="fw-500 color-dark">0.2km</span></li>
                            <li>Metro Station:  <span class="fw-500 color-dark">0.7km</span></li>
                            <li>Gym: <span class="fw-500 color-dark">2.3km</span></li>
                            <li>University: <span class="fw-500 color-dark">2.7km</span></li>
                            <li>Hospital: <span class="fw-500 color-dark">1.7km</span></li>
                            <li>Shopping Mall: <span class="fw-500 color-dark">1.1m</span></li>
                            <li>Police Station: <span class="fw-500 color-dark">1.2m</span></li>
                            <li>Bus Station:  <span class="fw-500 color-dark"> 1.1m</span></li>
                            <li>River: <span class="fw-500 color-dark">3.1km</span></li>
                            <li>Market: <span class="fw-500 color-dark">3.4m</span></li>
                        </ul>
                        <!-- /.nearby-list-item -->
                    </div>
                    <!-- /.property-nearby -->

                    <div class="similar-property border-top p-40">
                        <h4 class="mb-40">Similar Homes You May Like</h4>
                        <div class="similar-listing-slider-two">
                            <div class="item">
                                <div class="listing-card-one style-three border border-30 sm-mb-40">
                                    <div class="img-gallery p-15">
                                        <div class="position-relative border-20 overflow-hidden">
                                            <div class="tag bg-white text-dark fw-500 border-20">FOR RENT</div>
                                            <img src="assets/images/listing/img_13.jpg" class="w-100 border-20" alt="...">
                                            <a href="listing_details_04.html" class="btn-four inverse rounded-circle position-absolute"><i class="bi bi-arrow-up-right"></i></a>
                                            <div class="img-slider-btn">
                                                03 <i class="fa-regular fa-image"></i>
                                                <a href="images/listing/img_large_01.jpg" class="d-block" data-fancybox="img1" data-caption="Blueberry villa"></a>
                                                <a href="images/listing/img_large_02.jpg" class="d-block" data-fancybox="img1" data-caption="Blueberry villa"></a>
                                                <a href="images/listing/img_large_03.jpg" class="d-block" data-fancybox="img1" data-caption="Blueberry villa"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.img-gallery -->
                                    <div class="property-info pe-4 ps-4">
                                        <a href="listing_details_04.html" class="title tran3s">Blueberry villa.</a>
                                        <div class="address m0 pb-5">Mirpur 10, Stadium dhaka</div>
                                        <div class="pl-footer m0 d-flex align-items-center justify-content-between">
                                            <strong class="price fw-500 color-dark">$34,900</strong>
                                            <ul class="style-none d-flex action-icons">
                                                <li><a href="#"><i class="fa-light fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-bookmark"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-circle-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.property-info -->
                                </div>
                                <!-- /.listing-card-one -->
                            </div>
                            <div class="item">
                                <div class="listing-card-one style-three border border-30 sm-mb-40">
                                    <div class="img-gallery p-15">
                                        <div class="position-relative border-20 overflow-hidden">
                                            <div class="tag bg-white text-dark fw-500 border-20">FOR SELL</div>
                                            <img src="assets/images/listing/img_14.jpg" class="w-100 border-20" alt="...">
                                            <a href="listing_details_04.html" class="btn-four inverse rounded-circle position-absolute"><i class="bi bi-arrow-up-right"></i></a>
                                            <div class="img-slider-btn">
                                                03 <i class="fa-regular fa-image"></i>
                                                <a href="images/listing/img_large_04.jpg" class="d-block" data-fancybox="img2" data-caption="White House villa"></a>
                                                <a href="images/listing/img_large_05.jpg" class="d-block" data-fancybox="img2" data-caption="White House villa"></a>
                                                <a href="images/listing/img_large_06.jpg" class="d-block" data-fancybox="img2" data-caption="White House villa"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.img-gallery -->
                                    <div class="property-info pe-4 ps-4">
                                        <a href="listing_details_04.html" class="title tran3s">Blueberry villa.</a>
                                        <div class="address m0 pb-5">California link road, ca, usa</div>
                                        <div class="pl-footer m0 d-flex align-items-center justify-content-between">
                                            <strong class="price fw-500 color-dark">$28,100</strong>
                                            <ul class="style-none d-flex action-icons">
                                                <li><a href="#"><i class="fa-light fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-bookmark"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-circle-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.property-info -->
                                </div>
                                <!-- /.listing-card-one -->
                            </div>
                            <div class="item">
                                <div class="listing-card-one style-three border border-30 sm-mb-40">
                                    <div class="img-gallery p-15">
                                        <div class="position-relative border-20 overflow-hidden">
                                            <div class="tag bg-white text-dark fw-500 border-20">FOR SELL</div>
                                            <img src="assets/images/listing/img_15.jpg" class="w-100 border-20" alt="...">
                                            <a href="listing_details_04.html" class="btn-four inverse rounded-circle position-absolute"><i class="bi bi-arrow-up-right"></i></a>
                                            <div class="img-slider-btn">
                                                04 <i class="fa-regular fa-image"></i>
                                                <a href="images/listing/img_large_01.jpg" class="d-block" data-fancybox="img3" data-caption="Luxury villa in Dal lake."></a>
                                                <a href="images/listing/img_large_05.jpg" class="d-block" data-fancybox="img3" data-caption="Luxury villa in Dal lake."></a>
                                                <a href="images/listing/img_large_03.jpg" class="d-block" data-fancybox="img3" data-caption="Luxury villa in Dal lake."></a>
                                                <a href="images/listing/img_large_02.jpg" class="d-block" data-fancybox="img3" data-caption="Luxury villa in Dal lake."></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.img-gallery -->
                                    <div class="property-info pe-4 ps-4">
                                        <a href="listing_details_04.html" class="title tran3s">Blueberry villa.</a>
                                        <div class="address m0 pb-5">Mirpur 10, Stadium</div>
                                        <div class="pl-footer m0 d-flex align-items-center justify-content-between">
                                            <strong class="price fw-500 color-dark">$42,500</strong>
                                            <ul class="style-none d-flex action-icons">
                                                <li><a href="#"><i class="fa-light fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-bookmark"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-circle-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.property-info -->
                                </div>
                                <!-- /.listing-card-one -->
                            </div>
                            <div class="item">
                                <div class="listing-card-one style-three border border-30 sm-mb-40">
                                    <div class="img-gallery p-15">
                                        <div class="position-relative border-20 overflow-hidden">
                                            <div class="tag bg-white text-dark fw-500 border-20">FOR SELL</div>
                                            <img src="assets/images/listing/img_16.jpg" class="w-100 border-20" alt="...">
                                            <a href="listing_details_04.html" class="btn-four inverse rounded-circle position-absolute"><i class="bi bi-arrow-up-right"></i></a>
                                            <div class="img-slider-btn">
                                                04 <i class="fa-regular fa-image"></i>
                                                <a href="images/listing/img_large_04.jpg" class="d-block" data-fancybox="img4" data-caption="South Sun House"></a>
                                                <a href="images/listing/img_large_06.jpg" class="d-block" data-fancybox="img4" data-caption="South Sun House"></a>
                                                <a href="images/listing/img_large_03.jpg" class="d-block" data-fancybox="img4" data-caption="South Sun House"></a>
                                                <a href="images/listing/img_large_02.jpg" class="d-block" data-fancybox="img4" data-caption="South Sun House"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.img-gallery -->
                                    <div class="property-info pe-4 ps-4">
                                        <a href="listing_details_04.html" class="title tran3s">South Sun House</a>
                                        <div class="address m0 pb-5">Mirpur 10, Stadium</div>
                                        <div class="pl-footer m0 d-flex align-items-center justify-content-between">
                                            <strong class="price fw-500 color-dark">$55,500</strong>
                                            <ul class="style-none d-flex action-icons">
                                                <li><a href="#"><i class="fa-light fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-bookmark"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-circle-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.property-info -->
                                </div>
                                <!-- /.listing-card-one -->
                            </div>
                            <div class="item">
                                <div class="listing-card-one style-three border border-30 sm-mb-40">
                                    <div class="img-gallery p-15">
                                        <div class="position-relative border-20 overflow-hidden">
                                            <div class="tag bg-white text-dark fw-500 border-20">FOR SELL</div>
                                            <img src="assets/images/listing/img_14.jpg" class="w-100 border-20" alt="...">
                                            <a href="listing_details_04.html" class="btn-four inverse rounded-circle position-absolute"><i class="bi bi-arrow-up-right"></i></a>
                                            <div class="img-slider-btn">
                                                03 <i class="fa-regular fa-image"></i>
                                                <a href="images/listing/img_large_04.jpg" class="d-block" data-fancybox="img5" data-caption="White House villa"></a>
                                                <a href="images/listing/img_large_05.jpg" class="d-block" data-fancybox="img5" data-caption="White House villa"></a>
                                                <a href="images/listing/img_large_06.jpg" class="d-block" data-fancybox="img5" data-caption="White House villa"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.img-gallery -->
                                    <div class="property-info pe-4 ps-4">
                                        <a href="listing_details_04.html" class="title tran3s">White House villa</a>
                                        <div class="address m0 pb-5">California link road, ca, usa</div>
                                        <div class="pl-footer m0 d-flex align-items-center justify-content-between">
                                            <strong class="price fw-500 color-dark">$28,100</strong>
                                            <ul class="style-none d-flex action-icons">
                                                <li><a href="#"><i class="fa-light fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-bookmark"></i></a></li>
                                                <li><a href="#"><i class="fa-light fa-circle-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.property-info -->
                                </div>
                                <!-- /.listing-card-one -->
                            </div>
                        </div>
                    </div>
                    <!-- /.similar-property -->

                    <div class="property-score border-top p-40">
                        <h4 class="mb-20">Walk Score</h4>
                        <p class="fs-20 lh-lg pb-30">Risk management and compliance, when approached strategically, have the potential</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="block d-flex align-items-center mb-50 sm-mb-30">
                                    <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_52.svg" alt="" class="lazy-img icon">
                                    <div class="text">
                                        <h6>Transit Score</h6>
                                        <p class="fs-16 m0"><span class="color-dark">63</span>/100 (Moderate Distance Walkable)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="block d-flex align-items-center mb-50 sm-mb-30">
                                    <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_53.svg" alt="" class="lazy-img icon">
                                    <div class="text">
                                        <h6>School Score</h6>
                                        <p class="fs-16 m0"><span class="color-dark">70</span>/100 (Short Distance Walkable)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="block d-flex align-items-center mb-20 sm-mb-30">
                                    <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_54.svg" alt="" class="lazy-img icon">
                                    <div class="text">
                                        <h6>Medical Score</h6>
                                        <p class="fs-16 m0"><span class="color-dark">77</span>/100 (Short Distance Walkable)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="block d-flex align-items-center mb-20">
                                    <img src="assets/images/lazy.svg" data-src="assets/images/icon/icon_55.svg" alt="" class="lazy-img icon">
                                    <div class="text">
                                        <h6>Shopping Mall Score</h6>
                                        <p class="fs-16 m0"><span class="color-dark">42</span>/100 (Long Distance Walkable)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.property-score -->

                    <div class="property-location border-top p-40">
                        <h4 class="mb-40">Location</h4>
                        <div class="map-banner overflow-hidden border-15">
                            <div class="gmap_canvas h-100 w-100">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d83088.3595592641!2d-105.54557276330914!3d39.29302101722867!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x874014749b1856b7%3A0xc75483314990a7ff!2sColorado%2C%20USA!5e0!3m2!1sen!2sbd!4v1699764452737!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-100 h-100"></iframe>
                            </div>
                        </div>
                    </div>
                    <!-- /.property-location -->

                    <div class="review-panel-one border-top p-40">
                        <div class="position-relative z-1">
                            <div class="d-sm-flex justify-content-between align-items-center mb-10">
                                <h4 class="m0 xs-pb-30">Reviews</h4>
                                <select class="nice-select">
                                    <option value="0">Newest</option>
                                    <option value="1">Best Seller</option>
                                    <option value="2">Best Match</option>
                                </select>
                            </div>
                            <div class="review-wrapper mb-35">
                                <div class="review">
                                    <img src="assets/images/media/img_01.jpg" alt="" class="rounded-circle avatar">
                                    <div class="text">
                                        <div class="d-sm-flex justify-content-between">
                                            <div>
                                                <h6 class="name">Zubayer Al Hasan</h6>
                                                <div class="time fs-16">17 Aug, 23</div>
                                            </div>
                                            <ul class="rating style-none d-flex xs-mt-10">
                                                <li><span class="fst-italic me-2">(4.7 Rating)</span> </li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                            </ul>
                                        </div>
                                        <p class="fs-20 mt-20 mb-30">Lorem ipsum dolor sit amet consectetur. Pellentesque sed nulla facili diam posuere aliquam suscipit quam.</p>
                                        <div class="d-flex review-help-btn">
                                            <a href="#" class="me-5"><i class="fa-sharp fa-regular fa-thumbs-up"></i> <span>Helpful</span></a>
                                            <a href="#"><i class="fa-sharp fa-regular fa-flag-swallowtail"></i> <span>Flag</span></a>
                                        </div>
                                    </div>
                                    <!-- /.text -->
                                </div>
                                <!-- /.review -->

                                <div class="review">
                                    <img src="assets/images/media/img_03.jpg" alt="" class="rounded-circle avatar">
                                    <div class="text">
                                        <div class="d-sm-flex justify-content-between">
                                            <div>
                                                <h6 class="name">Rashed Kabir</h6>
                                                <div class="time fs-16">13 Jun, 23</div>
                                            </div>
                                            <ul class="rating style-none d-flex xs-mt-10">
                                                <li><span class="fst-italic me-2">(4.9 Rating)</span> </li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                            </ul>
                                        </div>
                                        <p class="fs-20 mt-20 mb-30">Lorem ipsum dolor sit amet consectetur. Pellentesque sed nulla facili diam posuere aliquam suscipit quam.</p>
                                        <ul class="style-none d-flex flex-wrap review-gallery pb-30">
                                            <li><a href="images/listing/img_large_01.jpg" class="d-block" data-fancybox="revImg" data-caption="Duplex orkit villa"><img src="assets/images/listing/img_48.jpg" alt=""></a></li>
                                            <li><a href="images/listing/img_large_02.jpg" class="d-block" data-fancybox="revImg" data-caption="Duplex orkit villa"><img src="assets/images/listing/img_49.jpg" alt=""></a></li>
                                            <li><a href="images/listing/img_large_03.jpg" class="d-block" data-fancybox="revImg" data-caption="Duplex orkit villa"><img src="assets/images/listing/img_50.jpg" alt=""></a></li>
                                            <li>
                                                <div class="position-relative more-img">
                                                    <img src="assets/images/listing/img_50.jpg" alt="">
                                                    <span>13+</span>
                                                    <a href="images/listing/img_large_04.jpg" class="d-block" data-fancybox="revImg" data-caption="Duplex orkit villa."></a>
                                                    <a href="images/listing/img_large_05.jpg" class="d-block" data-fancybox="revImg" data-caption="Duplex orkit villa."></a>
                                                    <a href="images/listing/img_large_06.jpg" class="d-block" data-fancybox="revImg" data-caption="Duplex orkit villa."></a>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="d-flex review-help-btn">
                                            <a href="#" class="me-5"><i class="fa-sharp fa-regular fa-thumbs-up"></i> <span>Helpful</span></a>
                                            <a href="#"><i class="fa-sharp fa-regular fa-flag-swallowtail"></i> <span>Flag</span></a>
                                        </div>
                                        
                                    </div>
                                    <!-- /.text -->
                                </div>
                                <!-- /.review -->

                                <div class="review hide">
                                    <img src="assets/images/media/img_02.jpg" alt="" class="rounded-circle avatar">
                                    <div class="text">
                                        <div class="d-sm-flex justify-content-between">
                                            <div>
                                                <h6 class="name">Perty Jinta</h6>
                                                <div class="time fs-16">17 Aug, 23</div>
                                            </div>
                                            <ul class="rating style-none d-flex xs-mt-10">
                                                <li><span class="fst-italic me-2">(4.7 Rating)</span> </li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                            </ul>
                                        </div>
                                        <p class="fs-20 mt-20 mb-30">Lorem ipsum dolor sit amet consectetur. Pellentesque sed nulla facili diam posuere aliquam suscipit quam.</p>
                                        <div class="d-flex review-help-btn">
                                            <a href="#" class="me-5"><i class="fa-sharp fa-regular fa-thumbs-up"></i> <span>Helpful</span></a>
                                            <a href="#"><i class="fa-sharp fa-regular fa-flag-swallowtail"></i> <span>Flag</span></a>
                                        </div>
                                    </div>
                                    <!-- /.text -->
                                </div>
                                <!-- /.review -->
                            </div>
                            <!-- /.review-wrapper -->
                            <div class="load-more-review text-uppercase w-100 border-15 tran3s">VIEW ALL 120 REVIEWS <i class="bi bi-arrow-up-right"></i></div>
                        </div>                      
                    </div>
                    <!-- /.review-panel-one -->

                    <div class="review-form border-top p-40">
                        <h4 class="mb-20">Leave A Reply</h4>
                        <p class="fs-20 lh-lg pb-15"><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="color-dark fw-500 text-decoration-underline">Sign in</a> to post your comment or signup if you don't have any account.</p>
                        
                        <form action="#">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-box-two mb-30">
                                        <div class="label">Title*</div>
                                        <input type="text" placeholder="Rashed Kabir" class="type-input">
                                    </div>
                                    <!-- /.input-box-two -->
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-box-two mb-30">
                                        <div class="label">Email*</div>
                                        <input type="email" placeholder="rshdkabir@gmail.com" class="type-input">
                                    </div>
                                    <!-- /.input-box-two -->
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-box-two mb-30">
                                        <div class="label">Ratings*</div>
                                        <select class="nice-select">
                                            <option value="0">Ratings</option>
                                            <option value="1">Five Star</option>
                                            <option value="1">Four Star</option>
                                            <option value="1">Three Star</option>
                                            <option value="1">Two Star</option>
                                            <option value="1">One Star</option>
                                        </select>
                                    </div>
                                    <!-- /.input-box-two -->
                                </div>
                                <div class="col-12">
                                    <div class="input-box-two mb-30">
                                        <textarea placeholder="Write your review here..."></textarea>
                                    </div>
                                    <!-- /.input-box-two -->
                                </div>
                            </div>
                            <button class="btn-five text-uppercase sm">Post Review</button>
                        </form>
                    </div>
                    <!-- /.review-form -->
                </div>
            </div>
            <div class="col-xl-4 col-lg-8 me-auto ms-auto">
                <div class="theme-sidebar-one ms-xl-5 lg-mt-80">
                    <div class="agent-info bg-white border-20 p-30 mb-40 d-xl-none">
                        <img src="assets/images/lazy.svg" data-src="assets/images/agent/img_06.jpg" alt="" class="lazy-img rounded-circle ms-auto me-auto mt-3 avatar">
                        <div class="text-center mt-25">
                            <h6 class="name">Rashed Kabir</h6>
                            <p class="fs-16">Property Agent & Broker</p>
                            <ul class="style-none d-flex align-items-center justify-content-center social-icon">
                                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <div class="divider-line mt-40 mb-45 pt-20">
                            <ul class="style-none">
                                <li>Location: <span>Spain, Barcelona</span></li>
                                <li>Email: <span><a href="mailto:akabirr770@gmail.com">akabirr770@gmail.com</a></span></li>
                                <li>Phone: <span><a href="tel:+12347687565">+12347687565</a></span></li>
                            </ul>
                        </div>
                        <!-- /.divider-line -->
                        <a href="contact.html" class="btn-nine text-uppercase rounded-3 w-100 mb-10">CONTACT AGENT</a>
                    </div>
                    <!-- /.agent-info -->
                    <div class="tour-schedule bg-white border-20 p-30 mb-40">
                        <h5 class="mb-40">Schedule Tour</h5>
                        <form action="#">
                            <div class="input-box-three mb-25">
                                <div class="label">Your Name*</div>
                                <input type="text" placeholder="Your full name" class="type-input">
                            </div>
                            <!-- /.input-box-three -->
                            <div class="input-box-three mb-25">
                                <div class="label">Your Email*</div>
                                <input type="email" placeholder="Enter mail address" class="type-input">
                            </div>
                            <!-- /.input-box-three -->
                            <div class="input-box-three mb-25">
                                <div class="label">Your Phone*</div>
                                <input type="tel" placeholder="Your phone number" class="type-input">
                            </div>
                            <!-- /.input-box-three -->
                            <div class="input-box-three mb-15">
                                <div class="label">Message*</div>
                                <textarea placeholder="Hello, I am interested in [Califronia Apartments]"></textarea>
                            </div>
                            <!-- /.input-box-three -->
                            <button class="btn-nine text-uppercase rounded-3 w-100 mb-10">INQUIry</button>
                        </form>
                    </div>
                    <!-- /.tour-schedule -->

                    <div class="mortgage-calculator bg-white border-20 p-30 mb-40">
                        <h5 class="mb-40">Mortgage Calculator</h5>
                        <form action="#">
                            <div class="input-box-three mb-25">
                                <div class="label">Home Price*</div>
                                <input type="tel" placeholder="1,32,789" class="type-input">
                            </div>
                            <!-- /.input-box-three -->
                            <div class="input-box-three mb-25">
                                <div class="label">Down Payment*</div>
                                <input type="tel" placeholder="$" class="type-input">
                            </div>
                            <!-- /.input-box-three -->
                            <div class="input-box-three mb-25">
                                <div class="label">Interest Rate*</div>
                                <input type="tel" placeholder="3.5%" class="type-input">
                            </div>
                            <!-- /.input-box-three -->
                            <div class="input-box-three mb-25">
                                <div class="label">Loan Terms (Years)</div>
                                <input type="tel" placeholder="24" class="type-input">
                            </div>
                            <!-- /.input-box-three -->
                            <button class="btn-five text-uppercase sm rounded-3 w-100 mb-10">CALCULATE</button>
                        </form>
                    </div>
                    <!-- /.mortgage-calculator -->

                    <div class="feature-listing bg-white border-20 p-30">
                        <h5 class="mb-40">Featured Listing</h5>
                        <div id="F-listing" class="carousel slide">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#F-listing" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#F-listing" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#F-listing" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="listing-card-one style-three border-10">
                                        <div class="img-gallery">
                                            <div class="position-relative border-10 overflow-hidden">
                                                <div class="tag bg-white text-dark fw-500 border-20">FOR RENT</div>
                                                <a href="#" class="fav-btn tran3s"><i class="fa-light fa-heart"></i></a>
                                                <img src="assets/images/listing/img_13.jpg" class="w-100 border-10" alt="...">
                                                <div class="img-slider-btn">
                                                    03 <i class="fa-regular fa-image"></i>
                                                    <a href="images/listing/img_large_01.jpg" class="d-block" data-fancybox="imgA" data-caption="Blueberry villa"></a>
                                                    <a href="images/listing/img_large_02.jpg" class="d-block" data-fancybox="imgA" data-caption="Blueberry villa"></a>
                                                    <a href="images/listing/img_large_03.jpg" class="d-block" data-fancybox="imgA" data-caption="Blueberry villa"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.img-gallery -->
                                        <div class="property-info mt-15">
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div>
                                                    <strong class="price fw-500 color-dark">$1,23,710</strong>
                                                    <div class="address m0 pt-5">120 Elgin St. Celina, Delaware </div>
                                                </div>
                                                <a href="listing_details_04.html" class="btn-four rounded-circle"><i class="bi bi-arrow-up-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- /.property-info -->
                                    </div>
                                    <!-- /.listing-card-one -->
                                </div>
                                <div class="carousel-item">
                                    <div class="listing-card-one style-three border-10">
                                        <div class="img-gallery">
                                            <div class="position-relative border-10 overflow-hidden">
                                                <div class="tag bg-white text-dark fw-500 border-20">FOR RENT</div>
                                                <a href="#" class="fav-btn tran3s"><i class="fa-light fa-heart"></i></a>
                                                <img src="assets/images/listing/img_14.jpg" class="w-100 border-10" alt="...">
                                                <div class="img-slider-btn">
                                                    03 <i class="fa-regular fa-image"></i>
                                                    <a href="images/listing/img_large_04.jpg" class="d-block" data-fancybox="imgB" data-caption="Blueberry villa"></a>
                                                    <a href="images/listing/img_large_05.jpg" class="d-block" data-fancybox="imgB" data-caption="Blueberry villa"></a>
                                                    <a href="images/listing/img_large_06.jpg" class="d-block" data-fancybox="imgB" data-caption="Blueberry villa"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.img-gallery -->
                                        <div class="property-info mt-15">
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div>
                                                    <strong class="price fw-500 color-dark">$2,11,536</strong>
                                                    <div class="address m0 pt-5">120 Elgin St. Celina, Delaware </div>
                                                </div>
                                                <a href="listing_details_04.html" class="btn-four rounded-circle"><i class="bi bi-arrow-up-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- /.property-info -->
                                    </div>
                                    <!-- /.listing-card-one -->
                                </div>
                                <div class="carousel-item">
                                    <div class="listing-card-one style-three border-10">
                                        <div class="img-gallery">
                                            <div class="position-relative border-10 overflow-hidden">
                                                <div class="tag bg-white text-dark fw-500 border-20">FOR RENT</div>
                                                <a href="#" class="fav-btn tran3s"><i class="fa-light fa-heart"></i></a>
                                                <img src="assets/images/listing/img_15.jpg" class="w-100 border-10" alt="...">
                                                <div class="img-slider-btn">
                                                    03 <i class="fa-regular fa-image"></i>
                                                    <a href="images/listing/img_large_04.jpg" class="d-block" data-fancybox="imgC" data-caption="Blueberry villa"></a>
                                                    <a href="images/listing/img_large_05.jpg" class="d-block" data-fancybox="imgC" data-caption="Blueberry villa"></a>
                                                    <a href="images/listing/img_large_06.jpg" class="d-block" data-fancybox="imgC" data-caption="Blueberry villa"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.img-gallery -->
                                        <div class="property-info mt-15">
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div>
                                                    <strong class="price fw-500 color-dark">$3,05,958</strong>
                                                    <div class="address m0 pt-5">120 Elgin St. Celina, Delaware </div>
                                                </div>
                                                <a href="listing_details_04.html" class="btn-four rounded-circle"><i class="bi bi-arrow-up-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- /.property-info -->
                                    </div>
                                    <!-- /.listing-card-one -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.feature-listing -->
                </div>
                <!-- /.theme-sidebar-one -->
            </div>
        </div>
    </div>
</div>






<?php
    include_once('inc/footer.php');
?>