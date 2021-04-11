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
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Add Administrator</title>

        <!--Meta tags-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

        <!--Favicon-->
        <link rel="icon" href="../images/favicon.ico">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!--bootstarp css-->
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">

        <!--Custom css-->
        <link rel="stylesheet" href="../css/admin-style.css">

         <!--Responsive css-->
         <link rel="stylesheet" href="../css/admin-responsive.css">
    </head>
    <body>

        <!--Navbar-->
        <nav class="navbar fixed-top navbar-expand-lg box">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard_admin.php">
                    <img src="../images/home/logo.png" alt="NotesMarketPlace logo">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-nav" aria-controls="mobile-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-icon">&#9776;</span>
                </button>

                <!-- Mobile Nav menu bar -->
                <div id="mobile-nav" class="collapse navbar-collapse">

                    <span id="mobile-nav-logo"><img src="../images/home/logo.png" alt="NotesMarketPlace logo"></span>
                    <!--Close button-->
                    <span id="mobile-nav-close-btn">&times;</span>

                    <div id="mobile-nav-content">
                        <ul class="navbar-nav">
                            <li><a href="dashboard_admin.php" class="link">Dashboard</a></li>
                            <li class="dropdown">
                                <a class="dropbtn">
                                    Notes
                                </a>
                                <div class="dropdown-content">
                                    <a href="notes_under_review.php">Notes Under Review</a>
                                    <a href="published_notes.php">Published Notes</a>
                                    <a href="downloaded_notes.php">Downloaded Notes</a>
                                    <a href="rejected_notes.php">Rejected Notes</a>
                                </div>
                            </li>
                            <li><a href="members.php" class="link">Members</a></li>
                            <li class="dropdown">
                                <a class="dropbtn">
                                    Reports
                                </a>
                                <div class="dropdown-content">
                                    <a href="spam_report.php">Spam Reports</a>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="dropbtn">
                                    Settings
                                </a>
                                <div class="dropdown-content">
                                    <?php if($role_id_nav == 1){?>
                                    <a href="system_configuration.php">Manage System Configuration</a>
                                    <a href="manage_admin.php">Manage Administrator</a>
                                    <?php }?>
                                    <a href="manage_category.php">Manage Category</a>
                                    <a href="manage_type.php">Manage Type</a>
                                    <a href="manage_country.php">Manage Countries</a>
                                </div>
                            </li>
                            <li class="dropdown">
                                    <a class="dropbtn">
                                        <img src=<?php echo $profile_image_nav;?> alt="progile image">
                                    </a>
                                    <div class="dropdown-content">
                                        <a href="profile.php">Update Profile</a>
                                        <a href="../change_password.php">Change Password</a>
                                        <a href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                    </div>
                            </li>
                            <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Nav menu bar Ends-->

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ml-auto">
                        <li><a href="dashboard_admin.php">Dashboard</a></li>
                        <li class="dropdown">
                            <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
                        
                            <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                <a class="dropdown-item" href="notes_under_review.php">Notes Under Review</a>
                                <a class="dropdown-item" href="published_notes.php">Published Notes</a>
                                <a class="dropdown-item" href="downloaded_notes.php">Downloaded Notes</a>
                                <a class="dropdown-item" href="rejected_notes.php">Rejected Notes</a>
                            </div>
                        </li>
                        <li><a href="members.php">Members</a></li>
                        <li class="dropdown">
                            <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
                        
                            <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                <a class="dropdown-item" href="spam_report.php">Spam Reports</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
                        
                            <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                            <?php if($role_id_nav == 1){?>
                                <a class="dropdown-item" href="system_configuration.php">Manage System Configuration</a>
                                <a class="dropdown-item" href="manage_admin.php">Manage Administrator</a>
                            <?php }?>    
                                <a class="dropdown-item" href="manage_category.php">Manage Category</a>
                                <a class="dropdown-item" href="manage_type.php">Manage Type</a>
                                <a class="dropdown-item" href="manage_country.php">Manage Countries</a>
                            </div>
                        </li>
                        <li class="dropdown">
                                <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src=<?php echo $profile_image_nav;?> alt="progile image"></a>
                            
                                <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                    <a class="dropdown-item" href="profile.php">Update Profile</a>
                                    <a class="dropdown-item" href="../change_password.php">Change Password</a>
                                    <a class="dropdown-item" href="../logout.php" style="color:#6255a5; font-weight: 600;">LOGOUT</a>
                                </div>
                        </li>
                        <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                    </ul>
                </div>   
            </div>
        </nav>
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

       
        <!-- Footer -->
        <footer class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-4 pr-0">
                        <p>Version : 1.1.24</p>
                    </div>
                    <div class="col-md-6 col-8 text-right pl-0">
                        <p>Copyright &copy; TatvaSoft All rigths reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
         <!-- Footer Ends-->

        <!--JQuery-->
        <script src="../js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="../js/bootstrap/bootstrap.min.js"></script>

        <!--Custom JS-->
        <script src="../js/admin_script.js"></script>

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