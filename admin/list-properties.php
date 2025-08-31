<?php

    session_start();

    unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'List Properties';

    //echo "<pre>";print_r($_SESSION);die;

    require 'db.php';

    //If user is not logged in, redirect to login page
    if (!empty($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        //Ok
    } else {
        header("Location: login.php");
        exit();
    }

    include_once('inc/header.php');



    //Get Property data
    $stmt = $pdo->query("SELECT properties.id, properties.title, properties.description, properties.category, properties.price, properties.address, properties.country, properties.state, properties.city, properties.created_at FROM properties where is_deleted = 1 ORDER BY id DESC");
    $properties = $stmt->fetchAll();

    //$stmt = $pdo->query("SELECT properties.id, properties.title, properties.description, properties.category, properties.price, properties.address, properties.country, properties.state, properties.city, properties.created_at, property_assets.uploded_files FROM properties LEFT JOIN property_assets ON properties.id = property_assets.p_id ORDER BY properties.id DESC");
    //$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //echo "<pre>";print_r($properties);

?>




    <div class="bg-white card-box p0 border-20">
        <div class="table-responsive pt-25 pb-25 pe-4 ps-4">


            <?php                
                if (isset($_GET['msg']))
                {
            ?>
                    <h5 class="text-info mb-5"><?php echo htmlspecialchars($_GET['msg']); ?></h5>
            <?php
                }
            ?>


            <table class="table property-list-table">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Date</th>
                        <th scope="col">Total View</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="border-0">

                <?php
                    if (!empty($properties))
                    {
                        foreach ($properties as $key => $property)
                        {
                ?>
                    <tr>
                        <td>
                            <div class="d-lg-flex align-items-center position-relative">
                                <img src="images/img_01.jpg" alt="" class="p-img">
                                <div class="ps-lg-4 md-pt-10">
                                    <a href="show-properties.php?id=<?= $property['id']; ?>" class="property-name tran3s color-dark fw-500 fs-20 stretched-link">
                                        <?php echo $property['title']; ?>
                                    </a>
                                    <div class="address"><?php echo $property['address'] . ' ' . $property['city'] . ' ' . $property['state'] . ' ' . $property['country']; ?></div>
                                    <strong class="price color-dark"><?php echo !empty($property['price']) ? '$' . $property['price'] : ''; ?></strong>
                                </div>
                            </div>
                        </td>
                        <td><?php echo date('d M, Y', strtotime($property['created_at'])); ?></td>
                        
                        <td><?php echo !empty($property['total_views']) ? $property['total_views'] : '0'; ?></td>

                        <td><div class="property-status">Active</div></td>
                        <td>
                            <div class="action-dots float-end">
                                <button class="action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="edit-property.php?id=<?php echo $property['id']; ?>">
                                            <img src="../images/lazy.svg" data-src="images/icon/icon_20.svg" alt="" class="lazy-img"> Edit</a>
                                    </li>
                                  
                                    <li>
                                        <a class="dropdown-item" href="delete-property.php?id=<?= $property['id']; ?>"><img src="../images/lazy.svg" data-src="images/icon/icon_21.svg" alt="" class="lazy-img"> Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } } else { ?>

                    <tr><td>No records found</td></tr>

                <?php } ?>

                </tbody>
            </table>
            <!-- /.table property-list-table -->
        </div>                    
    </div>
    <!-- /.card-box -->


    <!-- pagination div -->
    <?php /* ?>
    <ul class="pagination-one d-flex align-items-center justify-content-center style-none pt-40">
        <li><a href="#">1</a></li>
        <li class="active"><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li>....</li>
        <li class="ms-2">
            <a href="#" class="d-flex align-items-center">Last <img src="../images/icon/icon_46.svg" alt="" class="ms-2"></a>
        </li>
    </ul>
    <?php */ ?>
    





<?php
    include_once('inc/footer.php');
?>