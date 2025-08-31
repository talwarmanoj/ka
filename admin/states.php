<?php

	session_start();

    unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'List States';

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


    $stmt = $pdo->query("SELECT countries.name as c_name, states.id as id, states.state_name as state_name FROM states INNER JOIN countries ON countries.id=states.country_id ORDER BY country_id ASC, state_name ASC");
    $result = $stmt->fetchAll();
    //echo "<pre>";print_r($result);
?>



<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" media="all">

    <div class="bg-white card-box border-20">

    <a class="btn btn-primary" href="states-create.php">Add State</a>

        <table id="myTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Country</th>
                    <th>State Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    if (!empty($result))
                    {
                        $i = 1;
                        foreach ($result as $key => $row)
                        {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>

                    <td><?php echo htmlspecialchars($row['c_name'])??''; ?></td>

                    <td><?php echo htmlspecialchars($row['state_name'])??''; ?></td>

                    <td>
                        <a class="btn btn-primary" href="states-edit.php?id=<?= $row['id'] ?>">Edit</a>
                        <a class="btn btn-danger" href="states-delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
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