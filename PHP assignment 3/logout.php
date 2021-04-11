<?php
session_start();
if(isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = null;
}
else{
    $_SESSION['admin_id'] = null;
}
header("Location:index.php");
?>