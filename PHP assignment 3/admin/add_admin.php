<?php
    date_default_timezone_set('Asia/Kolkata');
    session_start();
    if(!isset($_SESSION['admin_id'])){
        header("Location:../index.php");
    }
    include '../Database/database.php';
    include '../functions.php';
    $user_id = $_SESSION['admin_id'];

    $role_id_nav = IsSuperAdmin($user_id);
    // Profile Image In Navigation
    $profile_image_nav = ProfileImage($user_id);

    if($role_id_nav != 1){
        header("Location:../index.php");
    }
   
    if(isset($_GET['id'])){
        $admin_id = $_GET['id'];
    }

    if(isset($_POST['submit-btn'])){

        $fname = mysqli_real_escape_string($connection,$_POST['fname']);
        $lname = mysqli_real_escape_string($connection,$_POST['lname']);
        $email = mysqli_real_escape_string($connection,$_POST['email']);
        $country_code = mysqli_real_escape_string($connection,$_POST['country_code']);
        $phone = mysqli_real_escape_string($connection,$_POST['phone']);
        $date = date('YmdHis');

        if(!empty($_POST['admin_id'])){
            $admin_id = $_POST['admin_id'];

            $query = "UPDATE user SET FirstName='{$fname}', LastName='{$lname}', EmailID='{$email}',PhoneNo='{$country_code} {$phone}',ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE UserID = $admin_id";
            $update_user_query = mysqli_query($connection, $query);
            confirmQuery($update_user_query);

            header("Location:manage_admin.php");
        }
        else{
            $phone_no = $country_code.' '.$phone;

            $data_password = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz@!';
            $password = substr(str_shuffle($data_password), 0, 8);
            $password_hash = md5($password);

            $query = "INSERT INTO user (RoleID, Firstname, Lastname, EmailID, Password, PhoneNo, IsEmailVerified, CreatedDate, CreatedBy) VALUES(2,'{$fname}','{$lname}','{$email}','{$password_hash}','{$phone_no}',1,'{$date}','{$user_id}')";
            $add_admin_query = mysqli_query($connection,$query);
            confirmQuery($add_admin_query);

            $email_subject = 'Temporary Password has been created for your new admin account';

            $email_body = '<!DOCTYPE html>
            <html lang="en">
                <head>      
                    <!-- Google Fonts -->
                    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
                </head>
                <body>
                    <table style="width: 600px; padding: 30px;">
                        <tr>
                            <td><img src="../images/front/logo.png"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 18px; line-height: 22px; font-weight: 600; color: #333333; font-family: "Open Sans",sans-serif; padding-top: 20px; padding-bottom: 20px;">Hello '.$fname.',</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;">We have generated a password for your new account<br>Password: '.$password.'</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;">Regards,<br>Notes Marketplace</td>
                        </tr>
                    </table>     
                </body>
            </html>';

            SendMail($email,$email_subject,$email_body);
            header("Location:manage_admin.php");
        }
    }
    else if(isset($_GET['id'])){
        $query = "SELECT * FROM user WHERE UserID = $admin_id";
        $admin_data_query = mysqli_query($connection,$query);
        if(!$admin_data_query ) {
            die("QUERY FAILED ." . mysqli_error($connection));   
        }

        $row = mysqli_fetch_array($admin_data_query);
        $fname = $row['FirstName'];
        $lname = $row['LastName'];
        $email = $row['EmailID'];
        $phone = explode(' ',$row['PhoneNo']);
        $country_code = $phone[0];
        $phone = $phone[1];

    }
    else{}
?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Add Administrator';
    include 'includes/header.php';?>

    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <form action="add_admin.php" method="post" id="form" class="box">
        
            <!--Add Administrator form -->
            <div class="form-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-9">  

                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Add Administrator</h2>
                                </div>
                            </div>

                            <input type="hidden" name="admin_id" id="admin_id" value="<?php echo isset($admin_id)?$admin_id:'';?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>First Name *</label>
                                        <input type="text" class="form-control Isnumber" name="fname" id="fname" placeholder="Enter your first name" value="<?php echo isset($fname) ? $fname : '' ?>" required>
                                        <div class="error-message"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Last Name *</label>
                                        <input type="text" class="form-control Isnumber" name="lname" id="lname" placeholder="Enter your last name" value="<?php echo isset($lname) ? $lname : '' ?>" required>
                                        <div class="error-message"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email address" name="email" value="<?php echo isset($email) ? $email : ''; ?>" <?php echo isset($admin_id)?'readonly':'';?> required>
                                        <div class="error-message"></div>
                                        <div class="error-message-success"></div>
                                    </div>
                                </div>
                                
                                <?php
                                $query = "SELECT * FROM countrytable WHERE IsActive=1";
                                $country_code_query = mysqli_query($connection, $query);
                                if(!$country_code_query){
                                    die("Query Failed". mysqli_error($connection));
                                }
                                ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <div class="row">

                                            <div class="col-xl-2 col-md-3 col-3" id="phone-number">
                                                <select class="form-control" name="country_code" required>
                                                <?php
                                                while($row = mysqli_fetch_array($country_code_query)){
                                                    if($country_code == $row['CountryCode']){
                                                        echo "<option selected>{$row['CountryCode']}</option>";
                                                    }
                                                    else{
                                                        echo "<option>{$row['CountryCode']}</option>";
                                                    }    
                                                }
                                                ?>  
                                                </select>
                                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                                            </div>
    
                                            <div class="col-xl-10 col-md-9 col-9">
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone number" value="<?php echo isset($phone) ? $phone : '' ?>" required>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="submit-btn"><?php echo isset($admin_id)?'Update':'Submit'?></button>
            </div> 
        </form>

       
        <?php include 'includes/footer.php';?>

        <script type="text/javascript">
        
        $(document).ready(function(){

            $(".Isnumber").on("keyup",function(){
                var value = $(this).val();

                if(value.match(/[0-9]/)){
                    $(this).siblings(".error-message").text("Numeric entry should not be allowed");
                }
                else{
                    $(this).siblings(".error-message").text("");
                }
            });

            $("#phone").on('keyup',function(){
                IsvalidPhone();
            });

            $("#email").on('keyup',function(){
                IsEmailUnique();
            });


            function IsvalidFname(){
                var fname = $("#fname").val();

                if(fname.match(/[0-9]/)){
                    $("#fname").siblings(".error-message").text("Numeric entry should not be allowed");
                    $("#fname").focus();
                    return false;
                }
                else{
                    $("#fname").siblings(".error-message").text("");
                    return true;
                }
            }

            function IsvalidLname(){
                var lname = $("#lname").val();

                if(lname.match(/[0-9]/)){
                    $("#lname").siblings(".error-message").text("Numeric entry should not be allowed");
                    $("#lname").focus();
                    return false;
                }
                else{
                    $("#lname").siblings(".error-message").text("");
                    return true;
                }
            }

            function IsvalidPhone(){
                var phone = $("#phone").val();

                if(phone.trim() == ''){
                    $("#phone").siblings(".error-message").text("Phone number is required");
                    $("#phone").focus();
                    return false;
                }

                if(!phone.match(/^[0-9]+$/)){
                    $("#phone").siblings(".error-message").text("Only Numeric value is allowed");
                    $("#phone").focus();
                    return false;
                }
                else if(phone.length > 10){
                    $("#phone").siblings(".error-message").text("Maximum 10 length is allowed");
                    $("#phone").focus();
                    return false;
                }
                else{
                    $("#phone").siblings(".error-message").text("");
                    return true;
                }
            }

            function IsEmailUnique(){
                var admin_id = $("#admin_id").val();
                // alert(admin_id);
                var email = $("#email").val();
                var email_unique = 'email_unique';
                if(admin_id == ''){
                    $.post('admin_validation.php',{email_unique:email_unique,email:email},function(data){
                            if(data == 'false'){
                                $("#email").siblings(".error-message-success").text("");
                                $("#email").siblings(".error-message").text("The Email must be unique.");
                                $("#email").focus();
                                return false;
                            }
                            else if(data == 'true'){
                                // alert('chhagn');
                                $("#email").siblings(".error-message").text("");
                                $("#email").siblings(".error-message-success").text("The Email is unique.");
                                // alert('chhagn');
                            }
                            else{
                            }
                    });
                }
                return true;
            }

            $("#form").on("submit",function(e){

                if(!IsvalidFname() || !IsvalidLname() || !IsvalidPhone() || !IsEmailUnique()){
                    e.preventDefault();
                }
                $("body").css('cursor','wait');   
            });
        });
        </script>
    </body>
</html>