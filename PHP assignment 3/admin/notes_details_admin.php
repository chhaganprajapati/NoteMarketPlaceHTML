<?php
session_start();
include '../Database/database.php';
include '../functions.php';

$user_id = $_SESSION['admin_id'];

$role_id_nav = IsSuperAdmin($user_id);
// Profile Image In Navigation
$profile_image_nav = ProfileImage($user_id);

$note_id = $_GET['note'];

$query = "SELECT notes.NoteTitle, categorytable.Category, notes.DisplayPictureFile, notes.Description, notes.NoteFile, notes.SellType, notes.NotePrice, notes.SellerID , notes.InstituteName, notes.CourseName, notes.CourseCode, notes.ProfessorName, notes.NotePage, notes.PublishedDate, countrytable.CountryName, notes.PreviewFile FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN countrytable ON notes.CountryID = countrytable.CountryID WHERE NoteID=$note_id";
$notes_details_query = mysqli_query($connection, $query);
if(!$notes_details_query){
    die("Query Failed". mysqli_error($connection));
}


while($row = mysqli_fetch_array($notes_details_query)){
    $title = $row['NoteTitle'];
    $category = $row['Category']; 
    $display_picture = $row['DisplayPictureFile'];
    $description = $row['Description'];
    $note_file = $row['NoteFile'];
    $sell_type = $row['SellType'];
    $note_price = $row['NotePrice'];
    $seller = $row['SellerID'];
    $no_of_pages = $row['NotePage'];
    $country        = $row['CountryName'];
    $institute_name = $row['InstituteName'];
    $course_name    = $row['CourseName'];
    $course_code    = $row['CourseCode'];
    $professor   = $row['ProfessorName'];
    $note_preview = $row['PreviewFile'];
    $approved_date = $row['PublishedDate'];
    $approved_date = date("F d Y",strtotime($approved_date));

    if(!empty($note_preview)){
        $preview_file = "../images/uploads/note_preview/$note_preview#scrollbar=0";
    }
    else{
        $preview_file = "../images/front/sample.pdf#scrollbar=0";
    }
}

// NOtes spam count
$query = "SELECT COUNT(*) AS TotalSpam FROM spamnotes WHERE NoteID = $note_id";
$spam_count_query = mysqli_query($connection, $query);
if(!$spam_count_query){
    die("Query Failed". mysqli_error($connection));
}

$row = mysqli_fetch_array($spam_count_query);
$TotalSpam = $row['TotalSpam'];

// NOtes Rating
$query = "SELECT AVG(Rating) AS AvgRating, COUNT(*) AS TotalReview FROM reviewnotes WHERE NoteID = $note_id AND IsActive = 1";
$review_count_query = mysqli_query($connection, $query);
if(!$review_count_query){
    die("Query Failed". mysqli_error($connection));
}

$row = mysqli_fetch_array($review_count_query);
$AvgRating = $row['AvgRating'];
$TotalReview = $row['TotalReview'];

// Set Display picture of note
$query = "SELECT DefaultDisplayPicture FROM systemtable WHERE SystemID = 1";
$display_query = mysqli_query($connection,$query);
if(!$review_count_query){
    die("Query Failed". mysqli_error($connection));
}

$row = mysqli_fetch_array($display_query);
$default_display_picture = $row['DefaultDisplayPicture'];

if(!empty($display_picture)){
    $display_image = "../images/uploads/display_pictures/$display_picture";
}
else{
    $display_image = "../images/uploads/display_pictures/$default_display_picture";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Notes Details</title>

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
        
        <!-- Notes details -->
        <div id="notes-details" class="box">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2>Notes Details</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12" id="notes-details-left">

                        <div class="row">
                            <!-- display picture of book -->
                            <div class="col-md-5 col-4">
                                <img src=<?php echo $display_image;?> class="img-fluid" alt="display picture">
                            </div>

                            <!-- Book details -->
                            <div class="col-md-7 col-8" style="padding-left: 0;">
                                <h3><?php echo $title;?></h3>
                                <h6><?php echo $category;?></h6>
                                <p><?php echo $description;?></p>
                                <button onclick="DownloadFile()">Download</button> 
                            </div>
                        </div>
                    </div>

                    <!-- Extra wide space -->
                    <div class="col-lg-1"></div>

                    <!-- Book details -->
                    <div class="col-lg-5 col-md-6 col-12" id="notes-details-right">
                        <div class="row">
                            <?php 
                            if(!empty($institute_name)){
                                echo '<div class="col-md-6 col-5 label">Institution:</div>';      
                                echo '<div class="col-md-6 col-7 text-right data">'.$institute_name.'</div>';
                            }

                            if(!empty($country)){
                                echo '<div class="col-md-6 col-6 label">Country:</div>';      
                                echo '<div class="col-md-6 col-6 text-right data">'.$country.'</div>';
                            }
                            
                            if(!empty($course_name)){
                                echo '<div class="col-md-6 col-5 label">Course Name:</div>';      
                                echo '<div class="col-md-6 col-7 text-right data">'.$course_name.'</div>';
                            }

                            if(!empty($course_code)){
                                echo '<div class="col-md-6 col-6 label">Course Code:</div>';
                                echo '<div class="col-md-6 col-6 text-right data">'.$course_code.'</div>';
                            }

                            if(!empty($professor)){
                                echo '<div class="col-md-6 col-5 label">Professor:</div>';
                                echo '<div class="col-md-6 col-7 text-right data">'.$professor.'</div>';
                            }

                            if(!empty($no_of_pages)){
                                echo '<div class="col-md-6 col-6 label">Number of Pages:</div> ';     
                                echo '<div class="col-md-6 col-6 text-right data">'.$no_of_pages.'</div>';
                            }

                            if(!empty($approved_date)){
                                echo '<div class="col-md-6 col-6 label">Approved Date:</div>';      
                                echo '<div class="col-md-6 col-6 text-right data">'.$approved_date.'</div>';
                            }
                            ?>
                            <div class="col-md-5 col-4 label">Rating:</div>      
                            <div class="col-md-7 col-8 text-right data rating-star pl-0">
                                <?php 

                                for($i = 1;$i<=5;$i++){
                                    if($i <= ($AvgRating)){
                                        echo '<img src="../images/front/star.png" alt="star"> ';
                                    }
                                    else{
                                        echo '<img src="../images/front/star-white.png" alt="star"> ';
                                    }
                                }
                                echo ' '.$TotalReview.' Reviews';
                                ?>
                            </div>
                            <?php
                            if(!empty($TotalSpam)){
                                echo '<div class="col-md-12 col-12 spam">
                                    '.$TotalSpam.' Users marked this note as inappropriate
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <!-- Notes details Ends-->
        
        
        <div id="notes-preview" class="box">
            <div class="container-fluid">
                <div class="row">

                    <!-- Notes preview -->
                    <div class="col-md-5">
                        <h2>Notes Preview</h2>
                        <div id="pdf">
                            <iframe src=<?php echo $preview_file;?>></iframe>
                        </div>
                    </div>

                    <?php 
        
                    $query = "SELECT reviewnotes.ReviewID, reviewnotes.Rating, reviewnotes.Comments, user.FirstName, user.LastName, user.ProfilePictureFile FROM reviewnotes JOIN user ON reviewnotes.ReviewerID = user.UserID WHERE reviewnotes.NoteID = $note_id and reviewnotes.IsActive = 1";
                    $review_query = mysqli_query($connection, $query);
                    if(!$review_query){
                        die("Query Failed". mysqli_error($connection));
                    }
                    ?>
                    <div class="col-md-7">
                        <h2>Customer Review</h2>
                        <ul id="customer-reviews">
                                <?php 
                                if(mysqli_num_rows($review_query) > 0){
                                    while($row = mysqli_fetch_array($review_query)){ 
                                        $display_picture = $row['ProfilePictureFile'];
                                        if(!empty($display_picture)){
                                            $display_picture = "../images/uploads/profile_picture/$display_picture";
                                        }
                                        else{
                                            $display_picture = $profile_image_nav;
                                        }                               
                                ?>
                                <li class="col-md-12 customer-review">
                                    <div class="row">
                                        <div class="col-xl-1 col-md-2 col-2">
                                        <img src="<?php echo $display_picture;?>" class="img-fluid" alt="customer image">
                                        </div>
                                        <div class="col-xl-11 col-md-10 col-10 rating-star" style="padding-left:20px;">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h3><?php echo $row['FirstName'].' '.$row['LastName'];?></h3>
                                                </div>
                                                <div class="col-2">
                                                    <a style="cursor:pointer;" class="delete-review" review_id='<?php echo $row['ReviewID']?>'><img src="../images/front/delete.png"></a>
                                                </div>
                                            </div>
                                            

                                            <?php 
                                            for($i = 1;$i<=5;$i++){
                                                if($i <= $row['Rating']){
                                                    echo '<img src="../images/front/star.png" alt="star"> ';
                                                }
                                                else{
                                                    echo '<img src="../images/front/star-white.png" alt="star"> ';
                                                }
                                            }
                                            ?>
                                            <p><?php echo $row['Comments'];?></p>  
                                        </div>
                                        
                                    </div>
                                    <hr>
                                </li>
                                <?php }
                             }
                             else{
                                 echo '<h5>No Reviews Available.</h5>';
                             }?>
                         
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        
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

         <?php
        if(isset($_SESSION['user_id'])){

            $user_id = $_SESSION['user_id'];
            // User Data to show in modal
            $query = "SELECT FirstName FROM user WHERE UserID=$user_id";
            $user_data_query = mysqli_query($connection, $query);
            if(!$user_data_query){
                die("Query Failed". mysqli_error($connection));
            }

            $row = mysqli_fetch_array($user_data_query);
            $buyer_fname = $row['FirstName'];

            // Seller Data to show in modal
            $query = "SELECT FirstName,LastName FROM user WHERE UserID=$seller";
            $seller_data_query = mysqli_query($connection, $query);
            if(!$seller_data_query){
                die("Query Failed". mysqli_error($connection));
            }

            $row = mysqli_fetch_array($seller_data_query);
            $seller_fname = $row['FirstName'];
            $seller_lname = $row['LastName'];
        }
        
        ?>
    
        <!-- Thank you message Modal -->
        <div class="modal fade" id="ThanksModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">      
                    
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <img src="../images/front/close.png" class="img-fluid" alt="close button image">
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="thanks-message">
                                    <div class="text-center">
                                        <img src="../images/front/SUCCESS.png" class="img-fluid" alt="success logo">
                                        <h2>Thank you for purchasing!</h2>
                                    </div>
                                    <h5>Dear <?php echo $buyer_fname?>,</h5>
                                    <p>As this is paid notes - you need to pay to seller <?php echo $seller_fname?> <?php echo $seller_lname?> offline. We will send him an email that you want to download this note. He may contact you furthur for payment process completion.</p>
                                    <p>In case, you have urgency,<br>Please contact us on +9195377345959.</p>
                                    <p>Once he receives the payment and acknowledge us - selected notes you can see over my downloads tab for download.</p>
                                    <p>Have a good day.</p>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
        <!-- Thank you message Modal Ends-->

        <!--JQuery-->
        <script src="../js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="../js/bootstrap/bootstrap.min.js"></script>

        <!--Custom JS-->
        <script src="../js/script.js"></script>

        <script tyep='text/javascript'>    
            /* ===================================
            Download the files
            =================================== */

            function DownloadFile(){
                note_file = '<?php echo $note_file;?>';
                var note = note_file.split('/');
                var i = 0;
                while(note[i]){
                    var a = $("<a />");
                    a.attr("download", note[i]);
                    a.attr("href", '../images/uploads/notes/'+note[i]);
                    $("notes-details-left").append(a);
                    a[0].click();
                    $("notes-details-left").remove(a);
                    i++;
                }
            }

            $(".delete-review").on('click',function(){
                var review_id = $(this).attr('review_id');
                var delete_review = 'delete_review';
                var c = confirm("Are you sure that you want to delete this review?");
                
                if(c == true){
                    $.get('notes_review_action.php',{delete_review : delete_review,review_id : review_id},function(data){
                        location.reload();
                    });    
                }
            });
        </script>
    </body>
</html>