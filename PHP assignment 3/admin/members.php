<?php
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


    $query =  "SELECT FirstName, LastName, EmailID, CreatedDate, UserID FROM user WHERE RoleID = 3 and IsActive = 1 ORDER BY CreatedDate desc";
    $member_query = mysqli_query($connection, $query);
    if(!$member_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    } 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Members</title>

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
                            <li><a href="#" class="link active">Members</a></li>
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
                        <li><a href="#" class="active">Members</a></li>
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

        <!-- Published Notes table -->
        <div class="admin-table box" style="margin-top: 160px;">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-7 col-md-6" style="padding-left: 15px;">
                        <h3 class="m-0">Members</h3>
                    </div>
                    <div class="col-lg-5 col-md-6 text-right">
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="search" id="member-search" placeholder="Search">
                            </div>

                            <div class="col-4 pl-0">
                                <button class="search-button" id="member-search-btn">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="member-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Joining Date</th>
                            <th class="text-center">Under Review Notes</th>
                            <th class="text-center">Published Notes</th>
                            <th class="text-center">Downloaded Notes</th>
                            <th class="text-center">Total Expenses</th>
                            <th class="text-center">Total Earnings</th>
                            <th></th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <?php 
                        $count = 0;
                        while($row = mysqli_fetch_array($member_query)){
                            $user_id = $row['UserID'];
                            $fname = $row['FirstName'];
                            $lname = $row['LastName'];
                            $email = $row['EmailID'];
                            $created_date = $row['CreatedDate'];
                            $created_date = date('d-m-Y, H:i',strtotime($created_date));
                            $count++;

                            // under review notes 
                            $query = "SELECT COUNT(*) AS NotesUnderReview FROM notes WHERE SellerID = $user_id AND (NoteStatusID = 2 OR NoteStatusID= 3) AND IsActive = 1";
                            $under_review_query = mysqli_query($connection, $query);
                            if(!$under_review_query ) {
                                die("QUERY FAILED ." . mysqli_error($connection));   
                            }

                            $row1 = mysqli_fetch_array($under_review_query);
                            $NotesUnderReview = $row1['NotesUnderReview'];

                            // Published notes
                            $query = "SELECT COUNT(*) AS NotesPublished FROM notes WHERE SellerID = $user_id AND NoteStatusID = 4 AND IsActive = 1";
                            $published_query = mysqli_query($connection, $query);
                            if(!$published_query ) {
                                die("QUERY FAILED ." . mysqli_error($connection));   
                            }

                            $row1 = mysqli_fetch_array($published_query);
                            $NotesPublished = $row1['NotesPublished'];

                            // Downloaded notes and total expenses
                            $query = "SELECT COUNT(DownloadID) AS DownloadedNotes, SUM(NotePrice) AS TotalExpenses FROM downloads WHERE BuyerID = $user_id AND IsAttachmentDownloaded = 1 AND IsActive = 1";
                            $downloaded_query = mysqli_query($connection, $query);
                            if(!$downloaded_query ) {
                                die("QUERY FAILED ." . mysqli_error($connection));   
                            }

                            $row1 = mysqli_fetch_array($downloaded_query);
                            $TotalExpenses = $row1['TotalExpenses'];
                            $DownloadedNotes = $row1['DownloadedNotes'];

                            // Total Earning
                            $query = "SELECT SUM(NotePrice) AS TotalEarning FROM downloads WHERE SellerID = $user_id AND RequestStatus = 1 AND IsActive = 1";
                            $Earning_query = mysqli_query($connection, $query);
                            if(!$Earning_query ) {
                                die("QUERY FAILED ." . mysqli_error($connection));   
                            }

                            $row1 = mysqli_fetch_array($Earning_query);
                            $TotalEarning = $row1['TotalEarning'];

                        ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td><?php echo $fname; ?></td>
                            <td><?php echo $lname; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $created_date; ?></td>
                            <td class="text-center color-text">
                                <a href="notes_under_review.php?user_id=<?php echo $user_id;?>&fname=<?php echo $fname;?>">
                                    <?php echo $NotesUnderReview;?>
                                </a>
                            </td>
                            <td class="text-center color-text">
                                <a href="published_notes.php?user_id=<?php echo $user_id;?>&fname=<?php echo $fname;?>">
                                    <?php echo $NotesPublished;?>
                                </a>
                            </td>
                            <td class="text-center color-text">
                                <a href="downloaded_notes.php?user_id=<?php echo $user_id;?>&fname=<?php echo $fname;?>">
                                    <?php echo $DownloadedNotes;?>
                                </a>
                            </td>
                            <td class="text-center color-text">
                                <a href="downloaded_notes.php?user_id=<?php echo $user_id;?>&fname=<?php echo $fname;?>">
                                    <?php echo (!empty($TotalExpenses))?'$'.$TotalExpenses:'0';?>
                                </a>
                            </td>
                            <td class="text-center"><?php echo (!empty($TotalEarning))?'$'.$TotalEarning:'0';?></td>
                            <td>
                                <span class="profile-table-icons">
                                    <span class="dropdown">
                                        <a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a>
                                    
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
                                            <a class="dropdown-item" href="member_details.php?member=<?php echo $user_id;?>">View More Details</a>
                                            <a class="dropdown-item deactivate" user-id=<?php echo $user_id;?>>Deactivate</a>
                                        </div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    <?php }?>
                        
                    </tbody>
                </table>
                
            </div>
        </div>
        <!-- Published Notes table Ends-->
       
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
        <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>

        <!--Datatable js-->
        <script src="../js/datatable/jquery.dataTables.min.js"></script>

        <!--Custom JS-->
        <script src="../js/admin_script.js"></script>
                            
        <script type="text/javascript">
            // Action on click of Inactive Button 
            $(".deactivate").on('click',function(){
                // alert("chhagan");
                var user_id = $(this).attr('user-id');
                var DeActivate = 'DeActivate';
                var c = confirm("Are you sure you want to make this member inactive?");
                
                if(c == true){
                    $.post('notes_review_action.php',{DeActivate : DeActivate,user_id : user_id},function(data){
                            location.reload();
                    });    
                }
            });
        </script>
    </body>
</html>