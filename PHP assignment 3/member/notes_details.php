<?php
session_start();
include '../Database/database.php';
include '../functions.php';   
if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];
    // Profile Image In Navigation
    $profile_image_nav = ProfileImage($user_id);
}

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
        $preview_file = "";
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
    <?php $title = 'Notes Details';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
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
                                <img src="<?php echo $display_image;?>" class="img-fluid" alt="display picture">
                            </div>

                            <!-- Book details -->
                            <div class="col-md-7 col-8" style="padding-left: 0;">
                                <h3><?php echo $title;?></h3>
                                <h6><?php echo $category;?></h6>
                                <p><?php echo $description;?></p>

                                <?php 
                                if(isset($_SESSION['user_id'])){
                                    if($seller == $_SESSION['user_id']){
                                ?>
                                        <button onclick="DownloadFile()">Download</button>
                                    <?php
                                    }
                                    else if($sell_type == 0){?>
                                        <button onclick="Download(0)">Download</button>
                                    <?php   }
                                    else{
                                    ?>
                                        <button id="download-btn" onclick="Download(1)">Download / $<?php echo $note_price;?></button>
                                    <?php        
                                    }
                                }
                                else{
                                ?>
                                    <a href="../signup.php"><button>Download</button></a>
                                <?php 
                                }
                                ?>
                                
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
                        <?php if(!empty($preview_file)){?>
                            <iframe src=<?php echo $preview_file;?>></iframe>
                        <?php }
                        else{
                            echo '<h5>Preview file is not available</h5>';
                        }?>
                        </div>
                    </div>

                    <?php 
        
                    $query = "SELECT reviewnotes.Rating, reviewnotes.Comments, user.FirstName, user.LastName, user.ProfilePictureFile FROM reviewnotes JOIN user ON reviewnotes.ReviewerID = user.UserID WHERE reviewnotes.NoteID = $note_id and reviewnotes.IsActive = 1";
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
                                            <h3><?php echo $row['FirstName'].' '.$row['LastName'];?></h3>

                                            <?php 
                                            for($i = 1;$i<=5;$i++){
                                                if($i <= $row['Rating']){
                                                    echo '<img src="../images/front/star.png" alt="star"> ';
                                                }
                                                else{
                                                    echo '<img src="../images/front/star-white.png" alt="star"> ';
                                                }
                                            }
                                            echo ' '.$TotalReview.' Reviews';
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

        <!-- footer include -->
        <?php include 'includes/footer.php'; ?>

        <script tyep='text/javascript'>    
            /* ===================================
            Download the files
            =================================== */
            function Download(type) {

                if(type == 0)
                {
                    note_id = <?php echo $note_id?>;
                    note_file = '<?php echo $note_file;?>';
                    $.get("download.php",{note_id : note_id},function(){

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
                            
                    });

                }
                else{
                    var r = confirm("Are you sure you want to download this paid note.\nPlease confirm.");
                    if (r == true) {
                        $('body').css('cursor','wait');
                        note_id = <?php echo $note_id?>;
                        $("#download-btn").attr('disabled','disabled');
                        $.get("download.php",{note_id : note_id},function(){
                            $("#download-btn").removeAttr('disabled','disabled');
                            $("#ThanksModal").modal();
                            $('body').css('cursor','default');
                        });
                    } 
                }
            }

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
        </script>
    </body>
</html>