<?php
session_start();
if(!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])){
    header("Location:../index.php");
}

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
else{
    $user_id = $_SESSION['admin_id'];
}


if(isset($_POST['change-pass-btn'])){

    include 'Database/database.php';
    $query = "SELECT Password FROM user WHERE UserID = $user_id";
    $password_query = mysqli_query($connection, $query);
    if(!$password_query){
        die("QUERY FAILED".mysqli_error($connection));
    }

    $row = mysqli_fetch_array($password_query);
    $password_db = $row['Password'];

    $password_old = $_POST['old-password'];
    $password_old_hash = md5($password_old);
    $password = $_POST['password'];

    if($password_old_hash === $password_db){
        $password = md5($password);
        $query = "UPDATE user SET Password = '{$password}' WHERE UserID = $user_id;";
        $update_pass_query = mysqli_query($connection, $query);
        if(!$update_pass_query){
            die("QUERY FAILED".mysqli_error($connection));
        }

        $_SESSION['user_id'] = null;
        header("Location:login.php");
    }
    else{
        $message = "Password is Incorrect.";
    }
}
else{
    $message ='';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Change password</title>

        <!--Meta tags-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Favicon-->
        <link rel="icon" href="images/favicon.ico">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!--bootstarp css-->
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

        <!--Custom css-->
        <link rel="stylesheet" href="css/form-style.css">
    </head>
    <body>

            <!-- Change password form -->
            <div class="form-container">

                <!-- logo -->
                <div class="content-logo text-center">
                    <img src="images/pre-login/top-logo.png">
                </div>

                <!-- Form content -->
                <form id="change-pass-form" action="change_password.php" method="post" class="form-content">

                    <h2>Change Password</h2>
                    <p>Enter your new password to change your password</p>

                    <diV class="row">
                        <div class="col-md-12">
                            <label>Old Password</label>
                            <div class="error-message"><?php echo isset($message)?$message:'';?></div>
                            <input type="password" id="password-field1" name="old-password" class="form-control" placeholder="Enter your old password" value="<?php echo isset($password_old) ? $password_old : '' ?>">
                            <span toggle="#password-field1" class="toggle-password eye"><img src="images/front/eye.png"></span>
                            
                        </div>
                    </diV>

                    <diV class="row">
                        <div class="col-md-12">
                            <label>New Password</label>
                            <input type="password" id="password-field2" name="password" class="form-control" placeholder="Enter your new password">
                            <span toggle="#password-field2" class="toggle-password eye"><img src="images/front/eye.png"></span>
                            <ul id="password-requirements">
                                <li>At least 6 characters long (and less than 24 characters)</li>
                                <li>Contains at least 1 number</li>
                                <li>Contains at least 1 lowercase letter</li>
                                <li>Must not contain whitespace</li>
                                <li>Contains a special character (e.g. @ !)</li>
                            </ul>
                        </div>
                    </diV>

                    <diV class="row">
                        <div class="col-md-12">
                            <label>Confirm Password</label>
                            <input type="password" id="password-field3" name="con-password" class="form-control" placeholder="Enter your confirm password">
                            <span toggle="#password-field3" class="toggle-password eye"><img src="images/front/eye.png"></span>
                            <ul id="confirm-password">
                                <li>Password must be same as above and follow the above rules.</li>
                            </ul>
                        </div>
                    </diV>

                    <button type="submit" name="change-pass-btn">SUBMIT</button>
                </form>
        </div>

        <!--JQuery-->
        <script src="js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="js/bootstrap/bootstrap.min.js"></script>

        <!--Custom JS-->
        <script src="js/script.js"></script>

        <!-- Password validation -->
        <script type="text/javascript">
            $(function(){
                $("#password-requirements").hide();
                $("#confirm-password").hide();
            });

            $("#password-field2").on("keyup",function(){
                $("#password-requirements").show();

                var validation = validatePassword();
                if(validation && comparePassword()){
                    $("#submit").removeAttr("disabled","disabled");
                    $("#password-requirements").hide();
                }
                else{
                    $("#submit").attr("disabled","desabled");
                }
            });

            // check password and confirm password is same or not
            $("#password-field3").on("keyup",function(){
                comparePassword();
            });

            function comparePassword(){
                $("#confirm-password").show();
                var password = $("#password-field2").val();
                var con_password = $("#password-field3").val();
                
                if(password === con_password && validatePassword()){
                    $("#confirm-password li").css("color","green");
                    $("#submit").removeAttr("disabled","disabled");
                    $("#confirm-password").hide();
                    $("#password-requirements").hide();
                    return true;
                }
                else{
                    $("#confirm-password li").css("color","red");
                    $("#submit").attr("disabled","disabled");
                    return false;
                }
            }

            function validatePassword(){
                var password = $("#password-field2").val();
                var valid_password=1;
                if(password.length >= 6 && password.length <= 24){
                    $("#password-requirements li:nth-child(1)").css("color","green");
                }
                else{
                    valid_password=0;
                    $("#password-requirements li:nth-child(1)").css("color","red");
                }

                if(password.match(/[0-9]/g)){
                    $("#password-requirements li:nth-child(2)").css("color","green");
                }
                else{
                    valid_password=0;
                    $("#password-requirements li:nth-child(2)").css("color","red");
                }

                if(password.match(/[a-z]/g)){
                    $("#password-requirements li:nth-child(3)").css("color","green");
                }
                else{
                    valid_password=0;
                    $("#password-requirements li:nth-child(3)").css("color","red");
                }

                if(!password.match(/\s/)){
                    $("#password-requirements li:nth-child(4)").css("color","green");
                }
                else{
                    valid_password=0;
                    $("#password-requirements li:nth-child(4)").css("color","red");
                }

                if(password.match(/[\!\@\#\$\%\^\&\*]/g)){
                    $("#password-requirements li:nth-child(5)").css("color","green");
                }
                else{
                    valid_password=0;
                    $("#password-requirements li:nth-child(5)").css("color","red");
                }

                if(valid_password==1){
                    return true;
                }
                else{
                    return false;
                }
            }


            $("#change-pass-form").submit(function(e){

                if(!comparePassword())
                {
                    e.preventDefault();
                }

            });
        </script>
    </body>
</html>