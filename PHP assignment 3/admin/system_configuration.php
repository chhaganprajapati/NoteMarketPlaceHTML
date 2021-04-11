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

    if(isset($_POST['submit-btn'])){

        $support_email = mysqli_real_escape_string($connection,$_POST['support_email']);
        $support_phone = mysqli_real_escape_string($connection,$_POST['support_phone']);
        $admin_emails = mysqli_real_escape_string($connection,$_POST['admin_emails']);
        $facebook_url = mysqli_real_escape_string($connection,$_POST['facebook_url']);
        $twitter_url = mysqli_real_escape_string($connection,$_POST['twitter_url']);
        $linkedin_url = mysqli_real_escape_string($connection,$_POST['linkedin_url']);
        $date = date('YmdHis');

        if(!isset($_FILES['default_profile']) || $_FILES['default_profile']['error'] == UPLOAD_ERR_NO_FILE){
            $query = "SELECT DefaultProfilePicture FROM systemtable WHERE SystemID = 1";
            $profile_query = mysqli_query($connection,$query);
            confirmQuery($profile_query);

            $row = mysqli_fetch_array($profile_query);
            $profile_picture = $row['DefaultProfilePicture'];
        }
        else{
            $profile_picture      = $user_id.'_'.$date.'_'.$_FILES['default_profile']['name'];
            $profile_picture_file = $_FILES['default_profile']['tmp_name'];
        }

        if(!isset($_FILES['default_image']) || $_FILES['default_image']['error'] == UPLOAD_ERR_NO_FILE){
            $query = "SELECT DefaultDisplayPicture FROM systemtable WHERE SystemID = 1";
            $display_query = mysqli_query($connection,$query);
            confirmQuery($display_query);

            $row = mysqli_fetch_array($display_query);
            $display_picture = $row['DefaultDisplayPicture'];
        }
        else{
            $display_picture      = $user_id.'_'.$date.'_'.$_FILES['default_image']['name'];
            $display_picture_file = $_FILES['default_image']['tmp_name'];       
        }

        if(!empty($_POST['system_id'])){
            // update system configuration
            $system_id = $_POST['system_id'];
            
            $query = "UPDATE systemtable SET SupportEmail='{$support_email}', SupportPhone='{$support_phone}', SubscriberEmails='{$admin_emails}', FacebookURL='{$facebook_url}', TwitterURL='{$twitter_url}', LinkedinURL='{$linkedin_url}', DefaultProfilePicture='{$profile_picture}', DefaultDisplayPicture='{$display_picture}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE SystemID = 1";
            $update_system_config = mysqli_query($connection, $query);
            confirmQuery($update_system_config);

            if(isset($_FILES['default_image'])){
                move_uploaded_file($display_picture_file, "../images/uploads/display_pictures/$display_picture");
            }
            if(isset($_FILES['default_profile'])){
                move_uploaded_file($profile_picture_file, "../images/uploads/profile_picture/$profile_picture");
            }
            header("Location:dashboard_admin.php");
        }
        else{

            // Insert system configuration first time
            $query = "INSERT INTO systemtable (SupportEmail, SupportPhone, SubscriberEmails, FacebookURL, TwitterURL, LinkedinURL, DefaultProfilePicture, DefaultDisplayPicture, CreatedDate, CreatedBy) VALUES ('{$support_email}','{$support_phone}','{$admin_emails}','{$facebook_url}','{$twitter_url}','{$linkedin_url}','{$profile_picture}','{$display_picture}','{$date}','{$user_id}')";
            $insert_system_config = mysqli_query($connection, $query);
            confirmQuery($insert_system_config);

            if(isset($_FILES['default_image'])){
                move_uploaded_file($display_picture_file, "../images/uploads/display_pictures/$display_picture");
            }
            if(isset($_FILES['default_profile'])){
                move_uploaded_file($profile_picture_file, "../images/uploads/profile_picture/$profile_picture");
            }
            header("Location:dashboard_admin.php");
        }   


    }
    else{
        $query = "SELECT * FROM systemtable WHERE SystemID = 1";
        $get_systemdata_query = mysqli_query($connection,$query);
        confirmQuery($get_systemdata_query);

        if(mysqli_num_rows($get_systemdata_query) > 0){
            $row = mysqli_fetch_array($get_systemdata_query);
            $system_id = $row['SystemID'];
            $support_email = $row['SupportEmail'];
            $support_phone = $row['SupportPhone'];
            $admin_emails = $row['SubscriberEmails'];
            $facebook_url = $row['FacebookURL'];
            $twitter_url = $row['TwitterURL'];
            $linkedin_url = $row['LinkedinURL'];
            $profile_picture = explode('_',$row['DefaultProfilePicture'])[2];
            $display_picture = explode('_',$row['DefaultDisplayPicture'])[2];
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Manage System Configuration</title>

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
                                    <a href="#">Manage System Configuration</a>
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
                                <a class="dropdown-item" href="#">Manage System Configuration</a>
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

        <form action="system_configuration.php" method="post" id="form" class="box" enctype="multipart/form-data">
        
            <!--Add Administrator form -->
            <div class="form-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Manage System Configuration</h2>
                        </div>

                        <div class="col-lg-6 col-md-9">  

                        <input type="hidden" name="system_id" value="<?php echo isset($system_id)?$system_id:'';?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Support email address *</label>
                                        <input type="email" class="form-control" name="support_email" placeholder="Enter support email address" value="<?php echo isset($support_email) ? $support_email : '' ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Support phone number *</label>
                                        <input type="text" class="form-control" name="support_phone" placeholder="Enter phone number" value="<?php echo isset($support_phone) ? $support_phone : '' ?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email Address(es) (for various events system will send notifications to these users)*</label>
                                        <input type="text" class="form-control" name="admin_emails" placeholder="Enter email address seperated by comma" value="<?php echo isset($admin_emails) ? $admin_emails : '' ?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Facebook URL</label>
                                        <input type="text" class="form-control" name="facebook_url" placeholder="Enter facebook url" value="<?php echo isset($facebook_url) ? $facebook_url : '' ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Twitter URL</label>
                                        <input type="text" class="form-control" name="twitter_url" placeholder="Enter twitter url" value="<?php echo isset($twitter_url) ? $twitter_url : '' ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Linkedin URL</label>
                                        <input type="text" class="form-control" name="linkedin_url" placeholder="Enter linkedin url" value="<?php echo isset($linkedin_url) ? $linkedin_url : '' ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label>Default image for notes (if seller do not upload)</label>
                                    <div class="form-group text-center">
                                        <div class="upload" id="default-image">
                                            <img src="../images/User-Profile/upload.png">
                                            <figcaption id="imagetext">Upload a picture</figcaption>
                                        </div>
                                        <input type="file" id="default-image-file" name="default_image" style="display:none" accept="image/*" <?php echo (empty($display_picture))?'required':'';?>>
                                    </div>
                                    <div id="display_picture_name" style="color : green;"><?php echo (!empty($display_picture))?$display_picture:'';?></div>
                                    <div class="error-message" id="display_file_error"></div>
                                </div>

                                <div class="col-md-12">
                                    <label>Default profile picture (if seller do not upload)</label>
                                    <div class="form-group text-center">
                                        <div class="upload" id="default-picture">
                                            <img src="../images/User-Profile/upload.png">
                                            <figcaption id="imagetext">Upload a picture</figcaption>
                                        </div>
                                        <input type="file" id="default-picture-file" name="default_profile" style="display:none" accept="image/*" <?php echo (empty($profile_picture))?'required':'';?>>
                                    </div>
                                    <div id="profile_picture_name" style="color : green;"><?php echo (!empty($profile_picture))?$profile_picture:'';?></div>
                                    <div class="error-message" id="profile_file_error"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" id="submit-btn" name="submit-btn">submit</button>
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

            $('#default-picture-file').on( 'change', function() {
                IsvalidProfilePicture();
            });

            $('#default-image-file').on( 'change', function() {
                IsvalidDefaultImage();
            });

            function IsvalidDefaultImage(){
                var input = document.getElementById('default-image-file');
                var file = $("#display_picture_name").text();
                if(input.files.length == 0  && file == '') 
                {
                    $("#display_file_error").text("Please select an image to upload.");
                    $("#default-image-file").trigger('click');
                    return false;
                }

                var file = $('#default-image-file')[0].files[0].name;

                var file_type = file.split('.');
                var file_type_end = file_type[file_type.length-1];
                file_type_end = file_type_end.toLowerCase();

                var filesize = (($('#default-image-file')[0].files[0].size/1024)/1024).toFixed(4);

                if(file_type_end != "jpg" && file_type_end != "jpeg" && file_type_end != "png")
                {
                    $('#display_picture_name').html("");
                    $('#display_file_error').text("Only jpg/jpeg and png format is allowed.");
                    return false;
                }
                else{
                    if(filesize > 10){
                        $('#display_picture_name').html("");
                        $('#display_file_error').text("Max. 10MB size Photo allowed to upload.");
                        return false;
                    }
                    else{
                        $('#display_file_error').text("");
                        $('#display_picture_name').html(file);
                    }
                }

                return true;
            }

            function IsvalidProfilePicture(){
                var input = document.getElementById('default-picture-file');
                var file = $("#profile_picture_name").text();
                if(input.files.length == 0  && file == '') 
                {
                    $("#profile_file_error").text("Please select an image to upload.");
                    $("#default-picture-file").trigger('click');
                    return false;
                }


                var file = $('#default-picture-file')[0].files[0].name;

                var file_type = file.split('.');
                var file_type_end = file_type[file_type.length-1];
                file_type_end = file_type_end.toLowerCase();

                var filesize = (($('#default-picture-file')[0].files[0].size/1024)/1024).toFixed(4);

                if(file_type_end != "jpg" && file_type_end != "jpeg" && file_type_end != "png")
                {
                    $('#profile_picture_name').html("");
                    $('#profile_file_error').text("Only jpg/jpeg and png format is allowed.");
                    return false;
                }
                else{
                    if(filesize > 10){
                        $('#profile_picture_name').html("");
                        $('#profile_file_error').text("Max. 10MB size Photo allowed to upload.");
                        return false;
                    }
                    else{
                        $('#profile_file_error').text("");
                        $('#profile_picture_name').html(file);
                    }
                }

                return true;
            }

            $("#submit-btn").on('click',function(e){
                
                if(!IsvalidProfilePicture()){
                    if(!IsvalidDefaultImage()){
                        e.preventDefault();
                    }
                }
            });
        });
        </script>
    </body>
</html>