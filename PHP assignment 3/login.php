<?php 
include 'Database/database.php';
session_start();

if(isset($_COOKIE['member_login']) && isset($_COOKIE['member_pass'])){

    $email = $_COOKIE['member_login'];
    $password = $_COOKIE['member_pass'];

    $query = "SELECT * FROM user WHERE  EmailID = '$email'";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query){
        die("Query Failed". mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)) {
        $db_UserID = $row['UserID'];
        $db_ROleID = $row['RoleID'];
        $modified_date = $row['ModifiedDate'];
        $isactive = $row['IsActive'];
    }

    if($isactive == 1){

        if($db_ROleID == 3){
            $_SESSION['user_id']  =  $db_UserID;
            if(empty($modified_date)){
                header("Location: member/user_profile.php");
            }
            else{
                header("Location: member/search_notes.php");
            }
            
        }
        else {
            $_SESSION['admin_id']  =  $db_UserID;
            if($db_ROleID == 1){
                $query = "SELECT * FROM systemtable WHERE SystemID = 1";
                $get_systemdata_query = mysqli_query($connection,$query);
                if(!$get_systemdata_query){
                    die("Query Failed". mysqli_error($connection));
                }

                if(mysqli_num_rows($get_systemdata_query) > 0){
                    header("Location: admin/dashboard_admin.php");
                }
                else{
                    header("Location: admin/system_configuration.php");
                }
            }
            else{
                header("Location: admin/dashboard_admin.php");
                                           
            }
        }
    }
    else{
        $account_error = "Your account is Deactivated!!";
    }

}

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
        $modified_date = $row['ModifiedDate'];
        $isactive = $row['IsActive'];
    }
    
    $password = md5($password);

    if(mysqli_num_rows($select_user_query) > 0 ){
        if($isactive == 1){
            if($password === $db_Password){
                if($isemailverified == 1){

                    
                    if(isset($_POST['remember'])){
                        setcookie ("member_login",$email,time()+ (10 * 365 * 24 * 60 * 60));
                        setcookie ("member_pass",$password,time()+ (10 * 365 * 24 * 60 * 60));
                    }

            
                    if($db_ROleID == 3){
                        $_SESSION['user_id']  =  $db_UserID;
                        if(empty($modified_date)){
                            header("Location: member/user_profile.php");
                        }
                        else{
                            header("Location: member/search_notes.php");
                        }
                        
                    }
                    else {
                        $_SESSION['admin_id']  =  $db_UserID;
                        if($db_ROleID == 1){
                            $query = "SELECT * FROM systemtable WHERE SystemID = 1";
                            $get_systemdata_query = mysqli_query($connection,$query);
                            if(!$get_systemdata_query){
                                die("Query Failed". mysqli_error($connection));
                            }

                            if(mysqli_num_rows($get_systemdata_query) > 0){
                                header("Location: admin/dashboard_admin.php");
                            }
                            else{
                                header("Location: admin/system_configuration.php");
                            }
                        }
                        else{
                            header("Location: admin/dashboard_admin.php");                                   
                        }
                    }
                }
                else{
                    $email_verify = "&#10008;"."Please verify the email address via clicking on the link we sent you via email.";
                }
            }
            else {
                $pass_error = "The password that you've entered is incorrect. <a href='forgot_password.php' style='color: #ff3636; text-decoration: none;'>Forgot password?</a>";
            }
        }
        else{
            $account_error = "Your account is Deactivated!!";
        }
    }
    else{
        $email_error = "The email address that you've entered is not registred. <a href='signup.php' style='color: #ff3636; text-decoration: none;'>Sign Up</a>";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<?php $title = 'Login';
    include 'includes/header.php';?>
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
                    <p style="margin-bottom: 5px; color: red;"><?php echo isset($email_verify)?$email_verify:'';?><?php echo isset($account_error)?$account_error:'';?></p>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo isset($email) ? $email : '' ?>" required>
                            <div class="error-message"><?php echo isset($email_error)? $email_error:'';?></div>
                        </div>
                    </div>

                    <div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-6" style="padding-left: 0;">
                                    <label for="exampleInputPassword1">Password </label>
                                </div>
                                <div class="col-md-6 text-right col-6" style="padding-right: 0;">
                                    <a href="forgot_password.php"><label id="forgot-pass" style="cursor: pointer;">Forgot Password?</label></a>
                                </div>
                                
                            </div>
                        </div>
                        <diV class="row">
                            <div class="col-md-12">
                                <input type="password" id="password-field" name="password" class="form-control" placeholder="Enter your password" required>
                                <span toggle="#password-field" class="toggle-password eye"><img src="images/front/eye.png"></span>
                                <div class="error-message"><?php echo isset($pass_error)? $pass_error:'';?></div>
                            </div>
                        </diV>
                    </div>

                    <div class="check-box">
                        <input type="checkbox" name="remember" class="ckeck mb-0">
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

        <?php include 'includes/footer_js.php';?>
    </body>
</html>