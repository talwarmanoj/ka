<?php

    require 'db2.php';

    if (isset($_POST['country_id']))
    {
        $countryId = intval($_POST['country_id']);

        $stmt = $conn->prepare("SELECT id, state_name FROM states WHERE country_id = ?");
        $stmt->bind_param("i", $countryId);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<option value="">Select State</option>';
        while ($row = $result->fetch_assoc())
        {
            echo '<option value="'.$row['state_name'].'">'.$row['state_name'].'</option>';
        }
    }

?>
