<?php

	session_start();

	
	//Include DB Connection
	include_once('inc/config.php');


	//echo "<pre>";print_r($_SESSION);
	// if (!empty($_SESSION) && $_SESSION['user_id'])
	// {
	// 	header("Location: index.php");
	// }

	include_once('inc/header.php');



	

	// Getting all properties
	$is_deleted = 1;
	$sql = "SELECT * FROM properties WHERE is_deleted = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $is_deleted);
    $stmt->execute();
    $result = $stmt->get_result();
    $properties = $result->fetch_all(MYSQLI_ASSOC);

    //echo "<pre>";print_r($result->num_rows);die;
    //echo "<pre>";print_r($properties);die;

?>




		<!-- 
		=============================================
			Inner Banner
		============================================== 
		-->
		<div class="inner-banner-one inner-banner bg-pink z-1 pt-160 lg-pt-140 pb-140 xl-pb-100 md-pb-80 position-relative">
			<div class="container">
                <div class="title-one text-center mb-55 xl-mb-30 lg-mb-20 wow fadeInUp">
                    <h3>Find Your <span>Home <img src="images/lazy.svg" data-src="images/shape/title_shape_02.svg" alt="" class="lazy-img"></span></h3>
                    <p class="fs-24 mt-xs">We’ve more than 745,000 apartments, place & plot.</p>
                </div>
                <!-- /.title-one -->
                <div class="row">
                    <div class="col-xxl-10 m-auto">
                        <div class="search-wrapper-one layout-one bg position-relative">
                            <div class="bg-wrapper border-0">
                                <form action="#">
                                    <div class="row gx-0 align-items-center">
                                        <div class="col-lg-4">
                                            <div class="input-box-one border-left">
                                                <div class="label">I’m looking to...</div>
                                                <select class="nice-select">
                                                    <option value="1">Buy Apartments</option>
                                                    <option value="2">Rent Condos</option>
                                                    <option value="3">Sell Houses</option>
                                                    <option value="4">Rent Industrial</option>
                                                    <option value="6">Sell Villas</option>
                                                </select>
                                            </div>
                                            <!-- /.input-box-one -->
                                        </div>
                                        <div class="col-xl-5 col-lg-4">
                                            <div class="input-box-one border-left">
                                                <div class="label">Location</div>
                                                <select class="nice-select location">
                                                    <option value="1">Dhanmondi, Dhaka</option>
                                                    <option value="2">Acapulco, Mexico</option>
                                                    <option value="3">Berlin, Germany</option>
                                                    <option value="4">Cannes, France</option>
                                                    <option value="5">Delhi, India</option>
                                                    <option value="6">Giza, Egypt </option>
                                                    <option value="7">Havana, Cuba</option>
                                                </select>
                                            </div>
                                            <!-- /.input-box-one -->
                                        </div>
                                        <div class="col-xl-3 col-lg-4">
                                            <div class="input-box-one md-mt-10">
                                                <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#advanceFilterModal" class="search-modal-btn sm rounded-circle tran3s text-uppercase fw-500 d-inline-flex align-items-center justify-content-center me-3">
                                                        <i class="fa-light fa-sliders-up"></i>
                                                    </a>
                                                    <button class="fw-500 text-uppercase tran3s search-btn w-auto m0">Search</button>
                                                </div>
                                            </div>
                                            <!-- /.input-box-one -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.search-wrapper-one -->
                    </div>
                </div>
			</div>
			<img src="images/lazy.svg" data-src="images/assets/ils_07.svg" alt="" class="lazy-img shapes w-100 illustration">
		</div>
		<!-- /.inner-banner-one -->


		


		<!--
		=====================================================
			Property Listing Six
		=====================================================
		-->
		<div class="property-listing-six pt-150 xl-pt-100 pb-170 xl-pb-120">
			<div class="container">
				<div class="listing-header-filter d-sm-flex justify-content-between align-items-center mb-40 lg-mb-30">
                    <div>Showing <span class="color-dark fw-500">1–9</span> of <span class="color-dark fw-500">170</span> results</div>
                    <div class="d-flex align-items-center xs-mt-20">
                        <div class="short-filter d-flex align-items-center">
                            <div class="fs-16 me-2">Short by:</div>
                            <select class="nice-select">
                                <option value="0">Newest</option>
                                <option value="1">Best Seller</option>
                                <option value="2">Best Match</option>
                                <option value="3">Price Low</option>
                                <option value="4">Price High</option>
                            </select>
                        </div>
                        <a href="listing_12.html" class="tran3s layout-change rounded-circle ms-auto ms-sm-3" data-bs-toggle="tooltip" title="Switch To List View"><i class="fa-regular fa-bars"></i></a>
                    </div>
                </div>
                <!-- /.listing-header-filter -->




                <div class="row gx-xxl-5">

                	<?php
						if (!empty($properties)) {
						    foreach ($properties as $key => $property) {
						        $p_id = $property['id'];
						        $sql1 = "SELECT * FROM property_assets WHERE p_id = ?";
						        $stmt1 = $conn->prepare($sql1);
						        $stmt1->bind_param("s", $p_id);
						        $stmt1->execute();
						        $result1 = $stmt1->get_result();
						        $property_assets = $result1->fetch_all(MYSQLI_ASSOC);

						        // Generate a unique carousel ID
						        $carouselId = "carousel" . $key;
					?>
						<div class="col-lg-4 col-md-6 d-flex mb-50 wow fadeInUp">
						    <div class="listing-card-one border-layout border-25 h-100 w-100">
						        <div class="img-gallery p-15">
						            <div class="position-relative border-25 overflow-hidden">
						                <div class="tag border-25">FOR RENT</div>
						                <a href="#" class="fav-btn tran3s"><i class="fa-light fa-heart"></i></a>
						                <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
						                    <div class="carousel-indicators">
						                        <?php foreach ($property_assets as $a_key => $asset): ?>
						                            <button type="button"
						                                data-bs-target="#<?php echo $carouselId; ?>"
						                                data-bs-slide-to="<?php echo $a_key; ?>"
						                                class="<?php echo $a_key == 0 ? 'active' : ''; ?>"
						                                aria-current="<?php echo $a_key == 0 ? 'true' : 'false'; ?>"
						                                aria-label="Slide <?php echo $a_key + 1; ?>"></button>
						                        <?php endforeach; ?>
						                    </div>
						                    <div class="carousel-inner">
						                        <?php foreach ($property_assets as $a_key => $property_asset): ?>
						                            <div class="carousel-item <?php echo $a_key == 0 ? 'active' : ''; ?>" data-bs-interval="1000000">
						                                <a href="#" class="d-block">
						                                    <img src="./admin/<?php echo $property_asset['uploded_files']; ?>" class="w-100" alt="<?php echo $property['title']; ?>">
						                                </a>
						                            </div>
						                        <?php endforeach; ?>
						                    </div>
						                </div>
						            </div>
						        </div>
						        <div class="property-info p-25">
						            <a target="_blank" href="property-single.php?id=<?php echo $property['id']; ?>" class="title tran3s"><?php echo $property['title']; ?></a>
						            <div class="address">
						            	<?php
						            		//Address
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
						            <ul class="style-none feature d-flex flex-wrap align-items-center justify-content-between">
						                <li class="d-flex align-items-center">
						                    <img src="images/lazy.svg" data-src="images/icon/icon_04.svg" alt="" class="lazy-img icon me-2">
						                    <span class="fs-16">
						                    	<?php
						                    		if (!empty($property['size_in_ft']))
						                    		{
						                    			echo $property['size_in_ft'] . ' sqft';
						                    		} else {
						                    			echo "0 sqft";
						                    		}
						                    	?>
						                	</span>
						                </li>
						                <li class="d-flex align-items-center">
						                    <img src="images/lazy.svg" data-src="images/icon/icon_05.svg" alt="" class="lazy-img icon me-2">
						                    <span class="fs-16">
						                    	<?php
						                    		if (!empty($property['bedrooms']))
						                    		{
						                    			echo $property['bedrooms'] . ' bed';
						                    		} else {
						                    			echo "0 bed";
						                    		}
						                    	?>
						                    </span>
						                </li>
						                <li class="d-flex align-items-center">
						                    <img src="images/lazy.svg" data-src="images/icon/icon_06.svg" alt="" class="lazy-img icon me-2">
						                    <span class="fs-16">
						                    	<?php
						                    		if (!empty($property['bathrooms']))
						                    		{
						                    			echo $property['bathrooms'] . ' bath';
						                    		} else {
						                    			echo "0 bath";
						                    		}
						                    	?>
						                    </span>
						                </li>
						            </ul>
						            <div class="pl-footer top-border d-flex align-items-center justify-content-between">
						                <strong class="price fw-500 color-dark">
						                	<?php
					                    		if (!empty($property['price']))
					                    		{
					                    			echo '$' . $property['price'] . '/<sub>m</sub>';
					                    		} else {
					                    			echo "$0 /<sub>m</sub>";
					                    		}
					                    	?>
						                </strong>
						                <a target="_blank" href="property-single.php?id=<?php echo $property['id']; ?>" class="btn-four rounded-circle"><i class="bi bi-arrow-up-right"></i></a>
						            </div>
						        </div>
						    </div>
						</div>
					<?php
						    }
						}
					?>

                </div>



                <!-- <div class="pt-50 md-pt-20 text-center">
                    <ul class="pagination-two d-inline-flex align-items-center justify-content-center style-none">
                        <li><a href="#"><i class="fa-regular fa-chevron-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><span>...</span></li>
                        <li><a href="#">13</a></li>
                        <li><a href="#"><i class="fa-regular fa-chevron-right"></i></a></li>
                    </ul>
                </div> -->
			</div>
		</div>
		<!-- /.property-listing-six -->


		


<?php
	include_once('inc/footer.php');
?>