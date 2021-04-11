<?php
    date_default_timezone_set('Asia/Kolkata');  
    session_start();
    $user_id = $_SESSION['admin_id'];
    require '../Database/database.php';
    include '../functions.php';

    if(isset($_POST['email_unique'])){
        $email = $_POST['email'];

        $query = "SELECT EmailID FROM user WHERE EmailID LIKE '".$email."%'";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("QUERY FAILED".mysqli_error($connection));
        }

        if(mysqli_num_rows($result) > 0){
            $output = 'false';
        }
        else{
            $output = 'true';
        }
        echo $output;
    }

    if(isset($_POST['DeActivate_category'])){
        $category_id = $_POST['category_id'];
        $date = date('YmdHis');

        $query = "UPDATE categorytable SET IsActive=0, ModifiedDate='{$date}',ModifiedBy='{$user_id}' WHERE CategoryID = $category_id";
        $remove_category_query = mysqli_query($connection, $query);
        confirmQuery($remove_category_query);

        echo 'success';

    }

    if(isset($_POST['DeActivate_country'])){
        $country_id = $_POST['country_id'];
        $date = date('YmdHis');

        $query = "UPDATE countrytable SET IsActive=0, ModifiedDate='{$date}',ModifiedBy='{$user_id}' WHERE countryID = $country_id";
        $remove_country_query = mysqli_query($connection, $query);
        confirmQuery($remove_country_query);

        echo 'success';

    }

    if(isset($_POST['DeActivate_type'])){
        $type_id = $_POST['type_id'];
        $date = date('YmdHis');

        $query = "UPDATE typetable SET IsActive=0, ModifiedDate='{$date}',ModifiedBy='{$user_id}' WHERE typeID = $type_id";
        $remove_type_query = mysqli_query($connection, $query);
        confirmQuery($remove_type_query);

        echo 'success';

    }
?>