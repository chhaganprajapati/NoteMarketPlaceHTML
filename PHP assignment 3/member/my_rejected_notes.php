<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location:../index.php");
    }
    include '../Database/database.php';
    include '../functions.php';
    $user_id = $_SESSION['user_id'];

    // Profile Image In Navigation
    $profile_image_nav = ProfileImage($user_id);

    $query = "SELECT notes.NoteID, notes.NoteTitle, categorytable.Category, notes.AdminRemark, notes.NoteFile, notes.ModifiedDate FROM notes JOIN categorytable ON notes.CategoryID = categorytable.CategoryID WHERE notes.SellerID = '$user_id' and notes.NoteStatusID = 5 and notes.IsActive = 1 ORDER BY notes.ModifiedDate desc";
    $my_rejected_query = mysqli_query($connection,$query);
    if(!$my_rejected_query){
        die("QUERY FAILED".mysqli_error($connection));
    }  
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-My Rejected Notes</title>

        <!--Meta tags-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

        <!--Favicon-->
        <link rel="icon" href="../images/favicon.ico">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!--datatable css-->
        <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">

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
                            <li><a href="search_notes.php" class="link">Search Notes</a></li>
                            <li><a href="dashboard.php" class="link">Sell Your Notes</a></li>
                            <li><a href="buyer_requests.php" class="link">Buyer Requests</a></li>
                            <li><a href="FAQ.php" class="link">FAQ</a></li>
                            <li><a href="contact_us.php" class="link">Contact Us</a></li>
                            <li class="dropdown">
                                    <a class="dropbtn">
                                        <img src=<?php echo $profile_image_nav;?> alt="progile image">
                                    </a>
                                    <div class="dropdown-content">
                                        <a href="user_profile.php">My Profile</a>
                                        <a href="my_downloads.php">My Downloads</a>
                                        <a href="my_sold_notes.php">My Sold Notes</a>
                                        <a href="#">My Rejected Notes</a>
                                        <a href="../change_password.php">Change Password</a>
                                        <a href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                    </div>
                            </li>
                            <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
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
                                <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src=<?php echo $profile_image_nav;?> alt="progile image"></a>
                            
                                <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                    <a class="dropdown-item" href="user_profile.php">My Profile</a>
                                    <a class="dropdown-item" href="my_downloads.php">My Downloads</a>
                                    <a class="dropdown-item" href="my_sold_notes.php">My Sold Notes</a>
                                    <a class="dropdown-item" href="#">My Rejected Notes</a>
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

        <!-- My Rejected note table -->
        <div class="profile-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-5 col-12">
                        <h2>My Rejected Notes</h2>
                    </div>
                    <div class="col-md-6 col-sm-7 col-12 text-right">
                        <input type="text" class="search" id="rejected-search" placeholder="Search">
                        <button class="search-button" id="rejected-search-btn">Search</button>
                    </div>
                </div>

                <table id="my-rejected-notes-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Remarks</th>
                            <th>Date Edited</th>
                            <th>Clone</th>
                            <th></th>
                        </tr>
                    </thead>
        
                    <tbody>
                    <?php
                        $count = 0;
                        while($row = mysqli_fetch_array($my_rejected_query)){
    
                            $category = $row['Category'];
                            $note_id = $row['NoteID'];
                            $title = $row['NoteTitle'];
                            $date = $row['ModifiedDate'];
                            $date = date("d M Y, H:i:s",strtotime($date));
                            $note_file = $row['NoteFile'];
                            $remark = $row['AdminRemark'];
                            $count++;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td><a href="notes_details.php?note=<?php echo $note_id;?>"><?php echo $title;?></a></td>
                            <td><?php echo $category;?></td>
                            <td><?php echo $remark;?></td>
                            <td><?php echo $date;?></td>
                            <td><a href="add_notes.php?note_id=<?php echo $note_id;?>&clone=1" class="color-text" style="text-decoration: none;">Clone</a></td>
                            <td>
                                <span class="profile-table-icons">
                                    <span class="dropdown">
                                        <a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a>
                                    
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
                                            <a class="dropdown-item download" notes="<?php echo $note_file;?>">Download Note</a>
                                        </div>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <?php 
                        }?>
                        
                    </tbody>
                </table>
                
            </div>
        </div>
        <!-- My Downloads note table Ends-->
      
        <!-- Footer -->
        <footer class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-8">
                        <p>Copyright &copy; TatvaSOft All rigths reserved.</p>
                    </div>
                    <div class="col-md-6 col-4 text-right">
                        <ul class="social-list">
                            <li><a href=<?php echo GetfacebookURL();?>><img src="../images/home/facebook.png" alt="facebook icon"></a></li>
                            <li><a href=<?php echo GettwitterURL();?>><img src="../images/home/twitter.png" alt="twitter icon"></a></li>
                            <li><a href=<?php echo GetlinkedinURL();?>><img src="../images/home/linkedin.png" alt="linkedin icon"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Ends-->

        <!--JQuery-->
        <script src="../js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>

        <!--Datatable js-->
        <script src="../js/datatable/jquery.dataTables.min.js"></script>

        <!--Custom JS-->
        <script src="../js/script.js"></script>

        <script type="text/javascript">
        
            $(".download").click(function(){
                
                var file = $(this).attr("notes");
                
                var note = file.split('/');
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

        </script>
    </body>
</html>