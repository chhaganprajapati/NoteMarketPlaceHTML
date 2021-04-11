<?php
    session_start();
    if(!isset($_SESSION['admin_id'])){
        header("Location:../index.php");
    }
    include '../Database/database.php';
    include '../functions.php';
    $member_id=$_GET['member'];

    $role_id_nav = IsSuperAdmin($member_id);
    // Profile Image In Navigation
    $profile_image_nav = ProfileImage($member_id);

    $query = "SELECT * FROM user WHERE UserID = $member_id";
    $member_data_query = mysqli_query($connection, $query);
    if(!$member_data_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    while($row = mysqli_fetch_array($member_data_query)){

        $query = "SELECT CountryName FROM countrytable WHERE CountryID = {$row['CountryID']}";
        $country_query = mysqli_query($connection, $query);
        if(!$country_query ) {
            die("QUERY FAILED ." . mysqli_error($connection));   
        }
        $row1 = mysqli_fetch_array($country_query);
        $country = $row1['CountryName'];

        $fname = $row['FirstName'];
        $lname = $row['LastName'];
        $email = $row['EmailID'];
        $DOBirth   = $row['BirthDate'];
        $DOB = date('m-d-Y',strtotime($DOBirth));
        $phone_no = $row['PhoneNo'];
        $university = $row['University'];
        $address_1 = $row['Address1'];
        $address_2 = $row['Address2']; 
        $city = $row['City'];
        $state = $row['State'];
        $zipcode = $row['Zipcode'];
        $display_picture = $row['ProfilePictureFile'];
        // if(!empty($display_picture)){
        //     $display_picture = "../images/uploads/profile_picture/$display_picture";
        // }
        // else{
        //     $display_picture = "../images/uploads/profile_picture/$display_picture";
        // }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Member Details</title>

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
        
        <!-- Member details -->
        <div id="member-details" class="box">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2>Member Details</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 member-box" style="display: flex;">
                        <img src=<?php echo $profile_image_nav;?> alt="member image">
                        
                        <div class="member-box-inner" style="display: flex;">
                            <!-- Member details -->
                            <div class="col-lg-6 col-md-7 col-12">
                                <div class="row" id="text-left">

                                    <div class="label col-5">First Name:</div>      
                                    <div class="col-7 data"><?php echo $fname;?></div>
                                    
                                    <div class="label col-5">Last Name:</div>      
                                    <div class="col-7 data"><?php echo $lname;?></div>
                                    
                                    <div class="label col-5">Email:</div>      
                                    <div class="col-7 data"><?php echo $email;?></div>

                                    <div class="label col-5">DOB:</div>      
                                    <div class="col-7 data"><?php echo (!empty($DOBirth)) ? $DOB :'NA';?></div>

                                    <div class="label col-5">Phone Number:</div>      
                                    <div class="col-7 data"><?php echo $phone_no;?></div>

                                    <div class="label col-5">College/University:</div>      
                                    <div class="col-7 data"><?php echo (!empty($university)) ? $university :'NA';?></div>

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-5 col-12">
                                <div class="row pl-4" id="text-right">

                                    <div class="col-lg-4 col-5 label">Address 1:</div>      
                                    <div class="col-7 data"><?php echo $address_1;?></div>
                                    
                                    <div class="col-lg-4 col-5 label">Address 2:</div>      
                                    <div class="col-7 data"><?php echo (!empty($address_2)) ? $address_2 :'NA';?></div>
                                    
                                    <div class="col-lg-4 col-5 label">City:</div>      
                                    <div class="col-7 data"><?php echo $city;?></div>

                                    <div class="col-lg-4 col-5 label">State:</div>      
                                    <div class="col-7 data"><?php echo $state;?></div>

                                    <div class="col-lg-4 col-5 label">Country:</div>      
                                    <div class="col-7 data"><?php echo $country;?></div>

                                    <div class="col-lg-4 col-5 label">Zip Code:</div>      
                                    <div class="col-7 data"><?php echo $zipcode;?></div>

                                </div>
                            </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Member details Ends-->

        <!-- member's Notes table -->
        <div class="admin-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mb-4">Notes</h2>
                    </div>
                </div>

                <?php 
                    $query = "SELECT notes.NoteID, notes.NoteTitle, notes.NoteFile, categorytable.Category, notestatus.Status, notes.CreatedDate, notes.PublishedDate, (SELECT count(DownloadID) FROM downloads WHERE downloads.NoteID = notes.NoteID AND SellerID = $member_id AND RequestStatus = 1 AND IsActive = 1) AS TotalDownloads, (SELECT SUm(NotePrice) FROM downloads WHERE downloads.NoteID = notes.NoteID AND SellerID = $member_id AND RequestStatus = 1 AND IsActive = 1) AS TotalEarnings  FROM notes JOIN categorytable ON notes.CategoryID = categorytable.CategoryID JOIN notestatus ON notes.NoteStatusID = notestatus.NoteStatusID WHERE notes.SellerID = $member_id AND notes.NoteStatusID > 1 AND notes.IsActive = 1 ORDER BY notes.CreatedDate asc";

                    $member_table_query = mysqli_query($connection, $query);
                    if(!$member_table_query ) {
                        die("QUERY FAILED ." . mysqli_error($connection));   
                    }
                ?>
                <table id="members-notes-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th class="text-center">Downloaded notes</th>
                            <th class="text-center">Total Earnings</th>
                            <th>Date Added</th>
                            <th>Published Date</th>
                            <th></th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <?php 
                            $count = 0;
                            while($row = mysqli_fetch_array($member_table_query)){
                                $count++;
                                $created_date = $row['CreatedDate'];
                                $created_date = date('d-m-Y, H:i',strtotime($created_date));

                                $published = $row['PublishedDate'];
                                $published_date = date('d-m-Y, H:i',strtotime($published));
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td class="color-text"><a href="notes_details_admin.php?note=<?php echo $row['NoteID'];?>"><?php echo $row['NoteTitle'];?></td>
                            <td><?php echo $row['Category'];?></td>
                            <td><?php echo $row['Status'];?></td>
                            <td class="text-center color-text">
                                <a href="downloaded_notes.php?NoteID=<?php echo $row['NoteID'];?>&Title=<?php echo $row['NoteTitle'];?>">
                                    <?php echo $row['TotalDownloads'];?>
                                </a>
                            </td>
                            <td class="text-center"><?php echo (!empty($row['TotalEarnings']))?'$'.$row['TotalEarnings']:'0';?></td>
                            <td><?php echo $created_date;?></td>
                            <td><?php echo (!empty($published))?$published_date:'NA';?></td>
                            <td>
                                <span class="profile-table-icons">
                                    <span class="dropdown">
                                        <a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a>
                                    
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
                                            <a class="dropdown-item download" notes="<?php echo $row['NoteFile']?>">Download Notes</a>
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
        
        $(".download").on('click',function(){
            
            var file = $(this).attr("notes");
            // alert(note_id);
        
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