<?php
    date_default_timezone_set('Asia/Kolkata');
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location:../index.php");
    }
    include '../Database/database.php';
    include '../functions.php';
    $user_id = $_SESSION['user_id'];
    
    // Profile Image In Navigation
    $profile_image = ProfileImage($user_id);


    if(isset($_POST['profile-btn'])){
        // After click the update button
        $user_id = $_POST['user_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $date_birth = $_POST['DOB'];
        $date_birth = date("Y-m-d",strtotime($date_birth));
        $gender = $_POST['gender'];
        $country_code = $_POST['country_code'];
        $phone = $_POST['phone'];
        $address_1 = $_POST['address_1'];
        $address_2 = $_POST['address_2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zipcode = $_POST['zipcode'];
        $country = $_POST['country'];
        $university = $_POST['university'];
        $college = $_POST['college'];
        $date = date('YmdHis');

        if(!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] == UPLOAD_ERR_NO_FILE){
            $profile_picture      = NULL;
        }
        else{
            $profile_picture      = $user_id.$date.$_FILES['profile_picture']['name'];
            $profile_picture_file = $_FILES['profile_picture']['tmp_name'];
        }

        $query = "UPDATE user SET 	FirstName='{$fname}', LastName='{$lname}', BirthDate='{$date_birth}', Gender='{$gender}', PhoneNo='{$country_code} {$phone}', Address1='{$address_1}', Address2='{$address_2}', City='{$city}', State='{$state}', Zipcode='{$zipcode}', CountryID ='{$country}', University='{$university}', CollegeName='{$college}', ProfilePictureFile='{$profile_picture}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE UserID = $user_id";
        $update_user_query = mysqli_query($connection, $query);
        confirmQuery($update_user_query);

        // Save profile picture
        move_uploaded_file($profile_picture_file, "../images/uploads/profile_picture/$profile_picture");
        header("Location:search_notes.php");
    
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
            $date_birth = $row['BirthDate'];
            $date_birth = date("m/d/Y",strtotime($date_birth));
            $gender = $row['Gender'];
            $phone = $row['PhoneNo'];
            $phone = explode(' ',$phone);
            $profile_picture = $row['ProfilePictureFile'];
            $address_1 = $row['Address1'];
            $address_2 = $row['Address2'];
            $city = $row['City'];
            $state = $row['State'];
            $zipcode = $row['Zipcode'];
            $country = $row['CountryID'];
            $university = $row['University'];
            $college = $row['CollegeName'];
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-User Profile</title>

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
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

        <!--Custom css-->
        <link rel="stylesheet" href="../css/user-style.css">

        <!--Responsive css-->
        <link rel="stylesheet" href="../css/user-responsive.css">
    </head>
    <body>

        <!--Navbar-->
        <nav class="navbar fixed-top navbar-expand-lg box white-nav-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php">
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
                            <li><a href="#" class="link">Search Notes</a></li>
                            <li><a href="#" class="link">Sell Your Notes</a></li>
                            <li><a href="#" class="link">Buyer Requests</a></li>
                            <li><a href="#" class="link">FAQ</a></li>
                            <li><a href="#" class="link">Contact Us</a></li>
                            <li class="dropdown">
                                    <a class="dropbtn">
                                        <img src="../images/front/user-img.png" alt="progile image">
                                    </a>
                                    <div class="dropdown-content">
                                        <a href="#">My Profile</a>
                                        <a href="#">My Downloads</a>
                                        <a href="#">My Sold Notes</a>
                                        <a href="#">My Rejected Notes</a>
                                        <a href="#">Change Password</a>
                                        <a href="#" style="color:#6255a5;">LOGOUT</a>
                                    </div>
                            </li>
                            <li style="padding-right:0;"><a href="#" style="border: none;"><button>Logout</button></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Nav menu bar Ends-->

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li><a href="search_notes.php">Search Notes</a></li>
                        <li><a href="dashboard.php">Sell Your Notes</a></li>
                        <li><a href="buyer_requests.php">Buyer Requests</a></li>
                        <li><a href="FAQ.php">FAQ</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                        <li class="dropdown">
                            <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src=<?php echo $profile_image;?> alt="progile image"></a>
                        
                                <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                    <a class="dropdown-item" href="#">My Profile</a>
                                    <a class="dropdown-item" href="my_downloads.php">My Downloads</a>
                                    <a class="dropdown-item" href="my_sold_notes.php">My Sold Notes</a>
                                    <a class="dropdown-item" href="my_rejected_notes.php">My Rejected Notes</a>
                                    <a class="dropdown-item" href="../change_password.php">Change Password</a>
                                    <a class="dropdown-item" href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                </div>
                        </li>
                        <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                    </ul>
                </div>   
            </div>
        </nav>
        <!--Navbar Ends-->

        <!-- Banner  -->
        <section class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">User Profile</h1>
                    </div>
                </div>
            </div>
        </section>

        <form id="form" action="user_profile.php" method="post" class="box" enctype="multipart/form-data">

            <!-- Basic Profile Details -->
            <div class="form-details" style="margin-top: 60px;">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Basic Profile Details</h2>
                        </div>
                    </div>

                    <div class="row">
                        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name *</label>
                                <input type="text" name="fname" id="fname" class="form-control Isnumber" placeholder="Enter your first name" value="<?php echo isset($fname) ? $fname : '' ?>" required>
                                <div class="error-message"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name *</label>
                                <input type="text" name="lname" id="lname" class="form-control Isnumber" placeholder="Enter your last name" value="<?php echo isset($lname) ? $lname : '' ?>" required>
                                <div class="error-message"></div>
                            </div>
                        </div>     
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="text" name="email" class="form-control" placeholder="Enter your email address" value="<?php echo isset($email) ? $email : '' ?>" readonly required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date Of Birth</label>
                                <input type="text" name="DOB" class="form-control" placeholder="Enter your date of birth" id="datepicker" value="<?php echo isset($date_birth) ? $date_birth : '' ?>">
                                <img src="../images/front/calendar.png" class="arrow-select" style="margin-top: -35px;">
                            </div>
                        </div>    
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option selected disabled hidden>Select your gender</option>
                                    <option value="0" <?php echo ($gender == 0)?'selected':'';?>>Male</option>
                                    <option value="1" <?php echo ($gender == 1)?'selected':'';?>>Female</option> 
                                </select>
                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                            </div>
                        </div>

                        <?php
                        $query = "SELECT * FROM countrytable WHERE IsActive=1";
                        $country_code_query = mysqli_query($connection, $query);
                        if(!$country_code_query){
                            die("Query Failed". mysqli_error($connection));
                        }
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Phone Number</label>
                                <div class="container-fluid">
                                    <div class="row">

                                        <div class="col-xl-2 col-md-3 col-3" id="phone-number">
                                            <select class="form-control" name="country_code" required>
                                            <?php
                                            while($row = mysqli_fetch_array($country_code_query)){
                                                if($phone[0] == $row['CountryCode']){
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
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" value="<?php echo isset($phone[1]) ? $phone[1] : '' ?>" required>
                                            <div class="error-message"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   

                    </div>

                    <div class="row">
                        <div class="col-md-6">
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

            <!-- Address Details -->
            <div class="form-details">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Address Details</h2>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Line 1 *</label>
                                <input type="text" name="address_1" class="form-control" placeholder="Enter your address" value="<?php echo isset($address_1) ? $address_1 : '' ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Line 2</label>
                                <input type="text" name="address_2" class="form-control" placeholder="Enter your addresss" value="<?php echo isset($address_2) ? $address_2 : '' ?>">
                            </div>
                        </div>     
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>City *</label>
                                <input type="text" name="city" class="form-control" placeholder="Enter your city" value="<?php echo isset($city) ? $city : '' ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>State *</label>
                                <input type="text" name="state" class="form-control" placeholder="Enter your state" value="<?php echo isset($state) ? $state : '' ?>" required>
                            </div>
                        </div>    
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Zipcode *</label>
                                <input type="text" name="zipcode" class="form-control" placeholder="Enter your zipcode" value="<?php echo isset($zipcode) ? $zipcode : '' ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Country *</label>
                                <select class="form-control" name="country" required>
                                    <option value="" selected disabled hidden>Select your country</option>
                                    <?php GetCountry($country);?>
                                </select>
                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                            </div>
                        </div>    
                    </div>

                </div>
            </div>

            <!-- Education Details -->
            <div class="form-details">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>University and College Information</h2>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>University</label>
                                <input type="text" name="university" class="form-control" placeholder="Enter your university" value="<?php echo isset($university) ? $university : '' ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>College</label>
                                <input type="text" name="college" class="form-control" placeholder="Enter your college" value="<?php echo isset($college) ? $college : '' ?>">
                            </div>
                        </div>     
                    </div>
                </div>
                
                <button type="submit" name="profile-btn" id="profile-btn">Update</button>
            </div> 
        </form>

        <!-- Footer -->
        <footer class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-8">
                        <p>Copyright &copy; TatvaSOft All rigths reserved.</p>
                    </div>
                    <div class="col-md-6 col-4 text-right">
                        <ul class="social-list">
                            <li><a href="#"><img src="../images/home/facebook.png" alt="facebook icon"></a></li>
                            <li><a href="#"><img src="../images/home/twitter.png" alt="twitter icon"></a></li>
                            <li><a href="#"><img src="../images/home/linkedin.png" alt="linkedin icon"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
         <!-- Footer Ends-->


        <!--JQuery-->
        <script src="../js/jquery.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!--bootstarp js-->
        <script src="../js/bootstrap/bootstrap.min.js"></script>

        <!--Custom JS-->
        <script src="../js/script.js"></script>

        <script type="text/javascript">
        
        $(document).ready(function() {
 
            $("#datepicker").datepicker();

            $('#picture').on( 'change', function() {
                var file = $('#picture')[0].files[0].name;

                var file_type = file.split('.')[1];
                file_type = file_type.toLowerCase();

                var filesize = (($('#picture')[0].files[0].size/1024)/1024).toFixed(4);

                if(file_type != "jpg" && file_type != "jpeg")
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

                    var file_type = file.split('.')[1];
                    file_type = file_type.toLowerCase();

                    var filesize = (($('#picture')[0].files[0].size/1024)/1024).toFixed(4);

                    if(file_type != "jpg" && file_type != "jpeg" && file_type != "")
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