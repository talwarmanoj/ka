<?php

    session_start();

    unset($_SESSION['admin_page_title']);
    $_SESSION['admin_page_title'] = 'List Users';

    //If user is not logged in, redirect to login page
    if (!empty($_SESSION['admin_user_id']) && $_SESSION['is_admin'] == 1)
    {
        //Ok
    } else {
        header("Location: login.php");
        exit();
    }

    include_once('inc/header.php');

    include_once('../inc/config.php');


    //Get all users data
    $sql = "SELECT id, name, email, created_at FROM users ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    //echo "<pre>";print_r($users);
?> 
    
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" media="all">


    <div class="bg-white card-box border-20">

        <table id="myTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    if (!empty($users))
                    {
                        $i = 1;
                        foreach ($users as $key => $user)
                        {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>

                    <td><?php echo $user['name']??''; ?></td>

                    <td><?php echo $user['email']??''; ?></td>

                    <td>
                        <?php
                            if (!empty($user['created_at']))
                            {
                                echo date('d-m-Y', strtotime($user['created_at']));
                            }
                        ?>
                    </td>
                </tr>
                <?php
                    $i++;
                    }
                }
                ?>

            </tbody>
            <!-- <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
            </tfoot> -->
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