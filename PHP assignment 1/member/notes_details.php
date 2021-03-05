<?php
session_start();
include '../Database/database.php';

$note_id = $_GET['note'];

$query = "SELECT notes.NoteTitle, categorytable.Category, notes.DisplayPictureFile, notes.Description, notes.NoteFile, notes.SellType, notes.NotePrice, notes.SellerID FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID WHERE NoteID=$note_id";
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
        <link rel="stylesheet" href="../css/user-style.css">

        <!--Responsive css-->
        <link rel="stylesheet" href="../css/user-responsive.css">
    </head>
    <body>

        <!--Navbar-->
        <nav class="navbar fixed-top navbar-expand-lg box white-nav-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
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
                            <li><a href="#" class="link active">Search Notes</a></li>
                            <li><a href="#" class="link">Sell Your Notes</a></li>
                            <?php if(isset($_SESSION['user_id'])){
                            ?>
                                <li><a href="buyer_requests.php" class="link">Buyer Requests</a></li>
                            <?php }?>
                            <li><a href="#" class="link">FAQ</a></li>
                            <li><a href="#" class="link">Contact Us</a></li>
                            <?php if(isset($_SESSION['user_id'])){
                            ?>
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
                                            <a href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                        </div>
                                </li>
                                <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                            <?php
                            }else{?>
                                <li style="padding-right:0;"><a href="../login.php" style="border: none;"><button>Login</button></a></li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Nav menu bar Ends-->

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ml-auto">
                        <li><a href="#" class="active">Search Notes</a></li>
                        <li><a href="#">Sell Your Notes</a></li>
                        <?php if(isset($_SESSION['user_id'])){
                        ?>
                            <li><a href="buyer_requests.php">Buyer Requests</a></li>
                        <?php }?>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <?php if(isset($_SESSION['user_id'])){
                        ?>
                            <li class="dropdown">
                                <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/user-img.png" alt="progile image"></a>
                            
                                <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                    <a class="dropdown-item" href="#">My Profile</a>
                                    <a class="dropdown-item" href="#">My Downloads</a>
                                    <a class="dropdown-item" href="#">My Sold Notes</a>
                                    <a class="dropdown-item" href="#">My Rejected Notes</a>
                                    <a class="dropdown-item" href="#">Change Password</a>
                                    <a class="dropdown-item" href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                </div>
                            </li>
                            <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                        <?php
                        }else{?>
                            <li style="padding-right:0;"><a href="../login.php" style="border: none;"><button>Login</button></a></li>
                        <?php }?>
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
                                <img src="../images/front/computer-science.png" class="img-fluid" alt="display picture">
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

                            <div class="col-md-6 col-5 label">Institution:</div>      
                            <div class="col-md-6 col-7 text-right data">University of California</div>
                            
                            <div class="col-md-6 col-6 label">Country:</div>      
                            <div class="col-md-6 col-6 text-right data">United State</div>
                            
                            <div class="col-md-6 col-5 label">Course Name:</div>      
                            <div class="col-md-6 col-7 text-right data">Computer Engineering</div>

                            <div class="col-md-6 col-6 label">Course Code:</div>      
                            <div class="col-md-6 col-6 text-right data">248705</div>

                            <div class="col-md-6 col-5 label">Professor:</div>      
                            <div class="col-md-6 col-7 text-right data">Mr. Richard Brown</div>

                            <div class="col-md-6 col-6 label">Number of Pages:</div>      
                            <div class="col-md-6 col-6 text-right data">277</div>

                            <div class="col-md-6 col-6 label">Approved Date:</div>      
                            <div class="col-md-6 col-6 text-right data">November 25 2020</div>

                            <div class="col-md-5 col-4 label">Rating:</div>      
                            <div class="col-md-7 col-8 text-right data rating-star pl-0">
                                <img src="../images/front/star.png" alt="star">
                                <img src="../images/front/star.png" alt="star">
                                <img src="../images/front/star.png" alt="star">
                                <img src="../images/front/star.png" alt="star">
                                <img src="../images/front/star-white.png" alt="star">
                                100 Reviews
                            </div>

                            <div class="col-md-12 col-12 spam">
                                5 Users marked this note as inappropriate
                            </div>
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
                            <iframe src="../images/front/sample.pdf#scrollbar=0"></iframe>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <h2>Customer Review</h2>
                        <div id="customer-reviews">
                                <!-- customer review 1 -->
                                <div class="col-md-12 customer-review">
                                    <div class="row">
                                        <div class="col-xl-1 col-md-2 col-2">
                                        <img src="../images/front/reviewer-1.png" class="img-fluid" alt="customer image">
                                        </div>
                                        <div class="col-xl-11 col-md-10 col-10 rating-star" style="padding-left:20px;">
                                            <h3>Richard Brown</h3>
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel necessitatibus suscipit enim iusto, corporis ipsum rerum voluptates provident.</p>  
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <!-- customer review 2 -->
                                <div class="col-md-12 customer-review">
                                    <div class="row">
                                        <div class="col-xl-1 col-md-2 col-2">
                                        <img src="../images/front/reviewer-2.png" class="img-fluid" alt="customer image">
                                        </div>
                                        <div class="col-xl-11 col-md-10 col-10 rating-star" style="padding-left:20px;">
                                            <h3>Alice Ortiaz</h3>
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel necessitatibus suscipit enim iusto, corporis ipsum rerum voluptates provident ipsum rerum.</p>                                     
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <!-- customer review 3 -->
                                <div class="col-md-12 customer-review">
                                    <div class="row">
                                        <div class="col-xl-1 col-md-2 col-2">
                                        <img src="../images/front/reviewer-3.png" class="img-fluid" alt="customer image">
                                        </div>
                                        <div class="col-xl-11 col-md-10 col-10 rating-star" style="padding-left:20px;">
                                            <h3>Sara passmore</h3>
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel necessitatibus suscipit enim iusto, corporis ipsum rerum voluptates provident ipsum rerum.</p>                                     
                                        </div>
                                    </div>
                                </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
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


        <?php
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
                        note_id = <?php echo $note_id?>;
                        $("#download-btn").attr('disabled','disabled');
                        $.get("download.php",{note_id : note_id},function(){
                            $("#download-btn").removeAttr('disabled','disabled');
                            $("#ThanksModal").modal();
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