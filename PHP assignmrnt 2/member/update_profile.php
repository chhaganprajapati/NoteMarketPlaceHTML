<?php include '../Database/database.php';
date_default_timezone_set('Asia/Kolkata');
?>
<?php

echo $user_id = $_POST['user_id'];
echo $date = date('YmdHis');
if(!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] == UPLOAD_ERR_NO_FILE){
    $display_picture      = NULL;
}
else{
   echo $display_picture      = $user_id.$date.$_FILES['profile_picture']['name'];
    $display_picture_file = $_FILES['profile_picture']['tmp_name'];
}













?>