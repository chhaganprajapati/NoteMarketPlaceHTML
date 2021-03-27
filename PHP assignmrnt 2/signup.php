<?php 
require 'Database/database.php';

if(isset($_POST['submit']))
{
    $email        = trim($_POST['email']);
    $password     = trim($_POST['password']);
    $con_password = trim($_POST['con_password']);
    $fname        = trim($_POST['fname']);
    $lname        = trim($_POST['lname']);

    $email = strtolower($email);
    // User exists varification
    $query = "SELECT EmailID FROM user WHERE EmailID = '$email'";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("QUERY FAILED".mysqli_error($connection));
    }

    if(mysqli_num_rows($result) > 0) {
        $message = "&#10008;"."User already exists."."<a href='login.php' style='color: #6255a5;'>Please Login</a>";
    }

    if(is_numeric($fname) || is_numeric($lname))
    {
        $message = "&#10008;"."Numeric Value is not allowed in First and Last name";
    }

    if(empty($fname) || empty($lname))
    {
        $message = "&#10008;"."Empty(Whitespace) Fields are not allowed";
    }

    if(empty($message)) {
        $email        = mysqli_real_escape_string($connection, $email);
        $password     = mysqli_real_escape_string($connection, $password);
        $con_password = mysqli_real_escape_string($connection, $con_password);
        $fname        = mysqli_real_escape_string($connection, $fname);
        $lname        = mysqli_real_escape_string($connection, $lname);

        if($password === $con_password){
            $password = md5($password);

            $query = "INSERT INTO user (RoleID, Firstname, Lastname, EmailID, Password) VALUES(3,'{$fname}','{$lname}','{$email}','{$password}')";
            $signup_query = mysqli_query($connection, $query);
            if(!$signup_query){
                die("QUERY FAILED".mysqli_error($connection));
            }
            header("Location:email_verification.php?id=$email");
        }
        else{
            $message = "&#10008;"."Password and Confirm password must be same";
        }
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
        <title>NotesMarketPlace-Sign Up</title>

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

        <!-- Signup form -->
        <div class="form-container">

                <!-- logo -->
                <div class="content-logo text-center">
                    <img src="images/pre-login/top-logo.png">
                </div>

                <!-- Form content -->
                <form action="signup.php" method="post" id="registration" class="form-content">

                    <h2>Create an Account</h2>
                    <p>Enter your details to signup</p>
                    <p style="margin-bottom: 5px; color: red;"><?php echo $message;?></p>
                    <div>
                        <label>First Name *</label>
                        <input type="text" name="fname" class="form-control" placeholder="Enter your first name" value="<?php echo isset($fname) ? $fname : '' ?>" required> 
                    </div>

                    <div>
                        <label>Last Name *</label>
                        <input type="text" name="lname" class="form-control" placeholder="Enter your last name" value="<?php echo isset($lname) ? $lname : '' ?>" required>
                    </div>

                    <div>
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email address" value="<?php echo isset($email) ? $email : '' ?>" required>
                    </div>


                    <diV>
                        <label>Password</label>
                        <input type="password" name="password" id="password-field1" class="form-control" placeholder="Enter your password" required>
                        <span toggle="#password-field1" class="toggle-password eye"><img src="images/front/eye.png"></span>
                        <ul id="password-requirements">
                            <li>At least 6 characters long (and less than 24 characters)</li>
                            <li>Contains at least 1 number</li>
                            <li>Contains at least 1 lowercase letter</li>
                            <li>Must not contain whitespace</li>
                            <li>Contains a special character (e.g. @ !)</li>
                        </ul>
                    </diV>

                    <diV>
                        <label>Confirm Password</label>
                        <input type="password" name="con_password" id="password-field2" class="form-control" placeholder="Re-enter your password" required>
                        <span toggle="#password-field2" class="toggle-password eye"><img src="images/front/eye.png"></span>
                        <ul id="confirm-password">
                            <li>Password must be same as above and follow the above rules.</li>
                        </ul>
                    </diV>

                    <button type="submit" id="submit" name="submit">SIGN UP</button>
                    <h4>Already have an account?<a href="login.php" style="color: #6255a5;"> Login</a></h4>
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

            $("#password-field1").on("keyup",function(){
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
            $("#password-field2").on("keyup",function(){
                comparePassword();
            });

            function comparePassword(){
                $("#confirm-password").show();
                var password = $("#password-field1").val();
                var con_password = $("#password-field2").val();
                
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
                var password = $("#password-field1").val();
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
        </script>
    </body>
</html>