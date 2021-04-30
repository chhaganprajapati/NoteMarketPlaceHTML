<?php
session_start();

setcookie("member_login","");
setcookie ("member_pass","");
if(isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = null;
}
else{
    $_SESSION['admin_id'] = null;
}
echo $_COOKIE['member_login'];
header("Location:index.php");
?>