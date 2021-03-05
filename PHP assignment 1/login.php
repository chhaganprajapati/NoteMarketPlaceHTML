<?php 
include 'Database/database.php';
session_start();

if(isset($_POST['submit']))
{
    $email = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);

    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM user WHERE  EmailID = '$email'";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query){
        die("Query Failed". mysqli_error($connection));
    }
    
    while($row = mysqli_fetch_array($select_user_query)) {
        $db_UserID = $row['UserID'];
        $db_ROleID = $row['RoleID'];
        $db_EmailID = $row['EmailID'];
        $db_Password = $row['Password'];
        $isemailverified = $row['IsEmailVerified'];
    }
    
    $password = md5($password);
    if($email === $db_EmailID && $password === $db_Password && $isemailverified == 1){
        $_SESSION['user_id']  =  $db_UserID;
        if($db_ROleID == 3){

            header("Location: member/dashboard.php");
        }
        else {
            header("Location: admin/dashboard_admin.html");
        }
    }
    else {
        $message = "&#10008;"."Please check your email and password!";
    }

    if($isemailverified == 0){
        $message = "&#10008;"."Please verify the email address via clicking on the link we sent you via email.";
    }
    
}
else {
    $message= "";
}

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Login</title>

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

            <!-- login form -->
            <div class="form-container">

                <!-- logo -->
                <div class="content-logo text-center">
                    <img src="images/pre-login/top-logo.png">
                </div>

                <!-- Form content -->
                <form action="login.php" method="post" class="form-content">

                    <h2>Login</h2>
                    <p>Enter your email address and password to login</p>
                    <p style="margin-bottom: 5px; color: red;"><?php echo $message;?></p>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo isset($email) ? $email : '' ?>" required>
                        </div>
                    </div>

                    <div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-6" style="padding-left: 0;">
                                    <label for="exampleInputPassword1">Password </label>
                                </div>
                                <div class="col-md-6 text-right col-6" style="padding-right: 0;">
                                    <a href="forgot_password.php" id="forgot-pass">Forgot Password?</a>
                                </div>
                                
                            </div>
                        </div>
                        <diV class="row">
                            <div class="col-md-12">
                                <input type="password" id="password-field" name="password" class="form-control" placeholder="Enter your password" required>
                                <span toggle="#password-field" class="toggle-password eye"><img src="images/front/eye.png"></span>
                            </div>
                        </diV>
                    </div>

                    <div class="check-box">
                        <input type="checkbox" class="ckeck mb-0">
                        <span>Remember Me</span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" name="submit">LOGIN</button>
                        </div>
                    </div>
                    
                    <h4>Don't have an account?<a href="signup.php" style="color: #6255a5;text-decoration: none;"> Sign Up</a></h4>
                </form>
        </div>

        <!--JQuery-->
        <script src="js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="js/bootstrap/bootstrap.min.js"></script>

        <!--Custom JS-->
        <script src="js/script.js"></script>
    </body>
</html>