<?php

	session_start();

    unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'List Amenities';

    //echo "<pre>";print_r($_SESSION);

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


    $stmt = $pdo->query("SELECT * FROM amenities ORDER BY id DESC");
    $amenities = $stmt->fetchAll();
?>



<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" media="all">

    <div class="bg-white card-box border-20">

    <a class="btn btn-primary" href="amenities-create.php">Add Amenity</a>

        <table id="myTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    if (!empty($amenities))
                    {
                        $i = 1;
                        foreach ($amenities as $key => $amenitie)
                        {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>

                    <td><?php echo htmlspecialchars($amenitie['name'])??''; ?></td>

                    <td><?php echo htmlspecialchars($amenitie['description'])??''; ?></td>

                    <td>
                        <a class="btn btn-primary" href="amenities-edit.php?id=<?= $amenitie['id'] ?>">Edit</a>
                        <a class="btn btn-danger" href="amenities-delete.php?id=<?= $amenitie['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php
                    $i++;
                    }
                }
                ?>

            </tbody>
        </table>

    </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

<script>
    let table = new DataTable('#myTable');
</script>





<?php
	include_once('inc/footer.php');
?>