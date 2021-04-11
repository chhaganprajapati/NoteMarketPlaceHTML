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

    // Profile Image In Navigation
    $profile_image_nav = ProfileImage($user_id);

    if(isset($_POST['profile-btn'])){

        $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
        $fname = mysqli_real_escape_string($connection,$_POST['fname']);
        $lname = mysqli_real_escape_string($connection,$_POST['lname']);
        $email = $_POST['email'];
        $secondary_email = mysqli_real_escape_string($connection,$_POST['secondary-email']);
        $country_code = mysqli_real_escape_string($connection,$_POST['country_code']);
        $phone = mysqli_real_escape_string($connection,$_POST['phone']);
        $date = date('YmdHis');


        if(!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] == UPLOAD_ERR_NO_FILE){
            $query = "SELECT ProfilePictureFile FROM user WHERE UserID = $user_id";
            $profile_query = mysqli_query($connection,$query);
            confirmQuery($profile_query);

            $row = mysqli_fetch_array($profile_query);
            $profile_picture = $row['ProfilePictureFile'];
        }
        else{
            $profile_picture      = $user_id.'_'.$date.'_'.$_FILES['profile_picture']['name'];
            $profile_picture_file = $_FILES['profile_picture']['tmp_name'];
            move_uploaded_file($profile_picture_file, "../images/uploads/profile_picture/$profile_picture");
        }

        $query = "UPDATE user SET FirstName='{$fname}', LastName='{$lname}', PhoneNo='{$country_code} {$phone}', SecondaryEmailID='{$secondary_email}' ,ProfilePictureFile='{$profile_picture}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE UserID = $user_id";
        $update_user_query = mysqli_query($connection, $query);
        confirmQuery($update_user_query);

        header("Location:profile.php");
    }
    else{
         // on load of user profile page
         $query = "SELECT * FROM user WHERE UserID = $user_id";
         $user_data_query = mysqli_query($connection, $query);
         confirmQuery($user_data_query);
 
         while($row = mysqli_fetch_array($user_data_query)){
             $fname = $row['FirstName'];
             $lname = $row['LastName'];
             $email = $row['EmailID'];
             $phone = $row['PhoneNo'];            
             $secondary_email = $row['SecondaryEmailID'];
             $profile_picture = $row['ProfilePictureFile'];
         }
    }

    if(!empty($phone)){
        $phone = explode(' ',$phone);
        $country_code = $phone[0];
        $phone = $phone[1];
    }

    if(!empty($profile_picture)){
        $profile_picture = explode('_',$profile_picture);
        $profile_picture = $profile_picture[2];
    }
     
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Profile</title>

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
                                        <a href="#">Update Profile</a>
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
                                    <a class="dropdown-item" href="#">Update Profile</a>
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

        <form action="profile.php" id="form" method="post" class="box" enctype="multipart/form-data">
        
            <!-- Selling Information -->
            <div class="form-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-9">  

                            <div class="row">
                                <div class="col-md-12">
                                    <h2>My Profile</h2>
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
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
                                        <input type="text" class="form-control" name="email" value="<?php echo isset($email) ? $email : ''; ?>" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Secondary Email</label>
                                        <input type="email" name="secondary-email" class="form-control" placeholder="Enter your email address" value="<?php echo isset($secondary_email) ? $secondary_email : '' ?>">
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
                                                <select class="form-control" name="country_code">
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
                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone number" value="<?php echo isset($phone) ? $phone : '' ?>">
                                                <div class="error-message"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label>Profile Picture</label>
                                    <div class="form-group text-center">
                                        <div class="upload" id="upload-picture">
                                            <img src="../images/User-Profile/upload.png">
                                            <figcaption id="imagetext">Upload a picture</figcaption>
                                        </div>
                                        <input type="file" id="picture" name="profile_picture" style="display:none" accept="image/*">
                                    </div>
                                    <div id="profile_picture_name" style="color : green;"><?php echo $profile_picture;?></div>
                                    <div class="error-message" id="profile_file_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button name="profile-btn" id="profile-btn">Update</button>
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

            $('#picture').on( 'change', function() {
                var file = $('#picture')[0].files[0].name;

                var file_type = file.split('.');
                var file_type_end = file_type[file_type.length-1];
                file_type_end = file_type_end.toLowerCase();

                var filesize = (($('#picture')[0].files[0].size/1024)/1024).toFixed(4);

                if(file_type_end != "jpg" && file_type_end != "jpeg")
                {
                    $('#profile_picture_name').html("");
                    $('#profile_file_error').text("Only jpg/jpeg format is allowed.");
                }
                else{
                    if(filesize > 10){
                        $('#profile_picture_name').html("");
                        $('#profile_file_error').text("Max. 10MB size Photo allowed to upload.");
                    }
                    else{
                        $('#profile_file_error').text("");
                        $('#profile_picture_name').html(file);
                    }
                }
            });

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
                var phone = $("#phone").val();

                if(!phone.match(/^[0-9]+$/)){
                    $("#phone").siblings(".error-message").text("Only Numeric value is allowed");
                    $("#phone").focus();
                }
                else if(phone.length > 10){
                    $("#phone").siblings(".error-message").text("Maximum 10 length is allowed");
                    $("#phone").focus();
                }
                else{
                    $("#phone").siblings(".error-message").text("");
                }
            });

            function IsValid(){

                if($('#picture')[0].files.length != 0){
                    var file = $('#picture')[0].files[0].name;

                    var file_type = file.split('.');
                    var file_type_end = file_type[file_type.length-1];
                    file_type_end = file_type_end.toLowerCase();

                    var filesize = (($('#picture')[0].files[0].size/1024)/1024).toFixed(4);

                    if(file_type_end != "jpg" && file_type_end != "jpeg" && file_type_end != "")
                    {
                        $('#profile_picture_name').html("");
                        $('#profile_file_error').text("Only jpg/jpeg format is allowed.");
                        $('#picture').trigger('click');
                        return false;
                    }
                    else{
                        if(filesize > 10){
                            $('#profile_picture_name').html("");
                            $('#profile_file_error').text("Max. 10MB size Photo allowed to upload.");
                            $('#picture').trigger('click');
                            return false;
                        }
                        else{
                            $('#profile_file_error').text("");
                            $('#profile_picture_name').html(file);
                        }
                    }
                }


                var fname = $("#fname").val();
                var lname = $("#lname").val();

                if(fname.match(/[0-9]/)){
                    $("#fname").siblings(".error-message").text("Numeric entry should not be allowed");
                    $("#fname").focus();
                    return false;
                }
                else{
                    $("#fname").siblings(".error-message").text("");
                }

                if(lname.match(/[0-9]/)){
                    $("#lname").siblings(".error-message").text("Numeric entry should not be allowed");
                    $("#lname").focus();
                    return false;
                }
                else{
                    $("#lname").siblings(".error-message").text("");
                }

                var phone = $("#phone").val();

                if(phone.trim() == ''){
                    return true;
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
                }

                return true;
                }


                $("#form").on("submit",function(e){

                    if(!IsValid()){
                        e.preventDefault();
                    }   

                });
        });
        
        </script>
    </body>
</html>