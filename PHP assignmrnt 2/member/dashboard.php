<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:../index.php");
}
include '../Database/database.php';
$user_id = $_SESSION['user_id'];

    // Dashboard Stats

    // NUmber of downloads and Money earned
    $query = "SELECT COUNT(DownloadID) AS NumberOfDownloads, SUM(NotePrice) AS TotalEarned FROM downloads WHERE SellerID = $user_id and RequestStatus = 1 and IsActive = 1;";
    $notes_sold_query = mysqli_query($connection, $query);
    if(!$notes_sold_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    while($row = mysqli_fetch_array($notes_sold_query)){
        $notes_sold_number = $row['NumberOfDownloads'];
        $total_earned = $row['TotalEarned'];
    }

    // My Downloads
    $query = "SELECT COUNT(DownloadID) AS MyDownloads FROM downloads WHERE BuyerID = $user_id and RequestStatus = 1 and IsActive = 1;";
    $no_download_query = mysqli_query($connection, $query);
    if(!$no_download_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $row = mysqli_fetch_array($no_download_query);
    $my_downloads = $row['MyDownloads'];

    // Rejected NOtes
    $query = "SELECT COUNT(NoteID) AS MyRejectedNotes FROM notes WHERE SellerID = $user_id and NoteStatusID = 5 and IsActive = 1;";
    $no_rejected_query = mysqli_query($connection, $query);
    if(!$no_rejected_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $row = mysqli_fetch_array($no_rejected_query);
    $my_rejected_notes = $row['MyRejectedNotes'];

    // Buyer Request
    $query = "SELECT COUNT(DownloadID) AS MyBuyerRequest FROM downloads WHERE SellerID = $user_id and RequestStatus = 0 and IsActive = 1;";
    $no_buyer_query = mysqli_query($connection, $query);
    if(!$no_buyer_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $row = mysqli_fetch_array($no_buyer_query);
    $my_buyer_request = $row['MyBuyerRequest'];
       
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Dashboard</title>

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
                            <li><a href="search_notes.php" class="link">Search Notes</a></li>
                            <li><a href="#" class="link">Sell Your Notes</a></li>
                            <li><a href="#" class="link">Buyer Requests</a></li>
                            <li><a href="#" class="link">FAQ</a></li>
                            <li><a href="contact_us.php" class="link">Contact Us</a></li>
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
                            <li style="padding-right:0;"><a href="#" style="border: none;"><button>Logout</button></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Nav menu bar Ends-->


                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li><a href="search_notes.php">Search Notes</a></li>
                        <li><a href="#">Sell Your Notes</a></li>
                        <li><a href="buyer_requests.php">Buyer Requests</a></li>
                        <li><a href="FAQ.php">FAQ</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                        <li class="dropdown">
                                <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/user-img.png" alt="progile image"></a>
                            
                                <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                    <a class="dropdown-item" href="user_profile.php">My Profile</a>
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

        <!-- Stats -->
        <div id="dashboard-stats" class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-6">
                        <h2>Dashboard</h2>
                    </div>
                    <div class="col-md-6 col-6 text-right">
                        <a href="add_notes.php"><button>Add Note</button></a>
                    </div>
                </div>

                <div class="row" id="stats">
                    <div class="col-lg-6 col-md-12">
                        <div id="stats-left">
                            <div class="row">
                                <div class="col-md-4 state-head stats-text">
                                    <div>
                                        <img src="../images/dashboard/earning-icon.svg" alt="icon">
                                        <h4>My Earning</h4>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center stats-text">
                                    <div>
                                        <h4><a href="my_sold_notes.php"><?php echo $notes_sold_number;?></a></h4>
                                        <h6>Number of Notes Sold</h6>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center stats-text">
                                    <div>
                                        <h4><a href="my_sold_notes.php">$<?php echo $total_earned;?></a></h4>
                                        <h6>Money Earned</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 text-center">
                        <div class="stat-item stats-text">
                            <div>
                                <h4><a href="my_downloads.php"><?php echo $my_downloads;?></a></h4>
                                <h6>My Downloads</h6>
                            </div>
                        </div>  
                    </div>

                    <div class="col-lg-2 col-md-4 text-center">
                        <div class="stat-item stats-text">
                            <div>
                                <h4><a href="my_rejected_notes.php"><?php echo $my_rejected_notes;?></a></h4>
                                <h6>My Rejected Notes</h6>
                            </div>
                        </div>  
                    </div>

                    <div class="col-lg-2 col-md-4 text-center">
                        <div class="stat-item stats-text">
                            <div>
                                <h4><a href="buyer_requests.php"><?php echo $my_buyer_request;?></a></h4>
                                <h6>Buyer Requests</h6>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <!-- Stats Ends-->

        <!-- In Progress table -->
        <div class="notes-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-5 col-12">
                        <h2>In Progress Notes</h2>
                    </div>
                    <div class="col-md-6 col-sm-7 col-12 text-right">
                        <input type="text" class="search" id="progress-search" placeholder="Search">
                        <button class="search-button" id="progress-search-btn">Search</button>
                    </div>
                </div>

                <?php
                
                $query = "SELECT notes.NoteID,notes.NoteTitle,categorytable.Category,notestatus.Status,notes.CreatedDate FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN notestatus ON notes.NoteStatusID = notestatus.NoteStatusID WHERE SellerID = '$user_id' and ( notes.NoteStatusID = 1 or notes.NoteStatusID = 2 or notes.NoteStatusID = 3)";
                $progress_notes_query = mysqli_query($connection, $query);
                if(!$progress_notes_query){
                    die("QUERY FAILED".mysqli_error($connection));
                }
                ?>
                

                <table id="in-progress-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Added Date</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    while($row = mysqli_fetch_array($progress_notes_query)){
                        // print_r($row);
                        $note_id = $row['NoteID'];
                        $added_date = $row['CreatedDate'];
                        $title = $row['NoteTitle'];
                        $category = $row['Category'];
                        $note_status = $row['Status'];
                        $added_date = strtotime($added_date);
                        ?>

                        <tr>
                            <td><?php echo date('d-m-Y',$added_date);?></td>
                            <td><?php echo $title;?></td>
                            <td><?php echo $category;?></td>
                            <td><?php echo $note_status;?></td>
                            <td>
                                <span class="action-icons">
                                <?php  if($note_status == 'Draft'){?>
                                    <a href="add_notes.php?note_id=<?php echo $note_id;?>"><img src="../images/Dashboard/edit.png" alt="edit" class="edit-icon"></a>
                                    <a href="#"><img src="../images/front/delete.png" alt="delete" class="delete-icon"></a>
                                <?php }
                                else{?>
                                     <a href="add_notes.php?note_id=<?php echo $note_id;?>&view=1"><img src="../images/Dashboard/eye.png" alt="view" class="view-icon"></a>
                                <?php }?>
                                    
                                </span>
                            </td>
                        </tr>
                        <?php
                    }                    
                    ?>
                    </tbody>
                </table>
                
            </div>
        </div>
        <!-- In Progress table Ends-->

        <!-- published note table -->
        <div class="notes-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-5 col-12">
                        <h2>Published Notes</h2>
                    </div>
                    <div class="col-md-6 col-sm-7 col-12 text-right">
                        <input type="text" class="search" id="published-search" placeholder="Search">
                        <button class="search-button" id="published-search-btn">Search</button>
                    </div>
                </div>
                <?php
                $query = "SELECT notes.NoteID,notes.NoteTitle,categorytable.Category,notes.CreatedDate,notes.SellType,notes.NotePrice FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID WHERE SellerID = '$user_id' and notes.NoteStatusID = 4";
                $published_notes_query = mysqli_query($connection, $query);
                if(!$published_notes_query){
                    die("QUERY FAILED".mysqli_error($connection));
                }
                ?>

                <table id="published-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Added Date</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Sell type</th>
                            <th>price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
        
                    <tbody>
                    <?php
                    while($row = mysqli_fetch_array($published_notes_query)){
                        $note_id = $row['NoteID'];  
                        $title = $row['NoteTitle'];
                        $category = $row['Category'];
                        $sell_type = $row['SellType'];
                        $note_price = $row['NotePrice'];
                        $added_date = $row['CreatedDate'];
                        $added_date = strtotime($added_date);
                    
                    ?>
                        <tr>
                            <td><?php echo date('d-m-Y',$added_date);?></td>
                            <td><?php echo $title;?></td>
                            <td><?php echo $category;?></td>
                            <td><?php echo ($sell_type == 0) ?'Free':'Paid';?></td>
                            <td>$<?php echo $note_price;?></td>
                            <td>
                                <span class="action-icons">
                                    <a href="add_notes.php?note_id=<?php echo $note_id;?>&view=1"><img src="../images/Dashboard/eye.png" alt="edit" class="view-icon"></a>
                                </span>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
        <!-- In Progress table Ends-->
       
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

        <!--bootstarp js-->
        <script src="../js/bootstrap/bootstrap.min.js"></script>

        <!--Datatable js-->
        <script src="../js/datatable/jquery.dataTables.min.js"></script>

        <!--Custom JS-->
        <script src="../js/script.js"></script>
    </body>
</html>