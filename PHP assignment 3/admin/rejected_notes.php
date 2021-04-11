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

    $query = "SELECT DISTINCT notes.SellerID,user.FirstName FROM notes JOIN user ON notes.SellerID = user.UserID WHERE notes.NoteStatusID = 5 AND notes.IsActive = 1";
    $seller_get_query = mysqli_query($connection,$query);
    if(!$seller_get_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Rejected Notes</title>

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
                                    <a href="#">Rejected Notes</a>
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
                                <a class="dropdown-item" href="#">Rejected Notes</a>
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

        <!-- Published Notes table -->
        <div class="admin-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Rejected Notes</h3>
                    </div>
                    <div class="col-md-12">
                        <h4>Seller</h4>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6">
                        <select class="form-control" id="select_seller">
                            <option selected disabled hidden>Select Seller</option>
                            <?php 
                            while($row = mysqli_fetch_array($seller_get_query)){
                                echo '<option value="'.$row['SellerID'].'">'.$row['FirstName'].'</option>';
                            }?>
                        </select>
                        <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                    </div>
                    <div class="col-lg-5 col-md-3"></div>
                    <div class="col-lg-5 col-md-6 text-right">
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="search" id="rejected-search" placeholder="Search">
                            </div>

                            <div class="col-4 pl-0">
                                <button class="search-button" id="rejected-search-btn">Search</button>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <table id="rejected-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Seller</th>
                            <th></th>
                            <th>Date Added</th>
                            <th>Rejected By</th>
                            <th>Remark</th>
                            <th></th>
                        </tr>
                    </thead>
    
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

        $(document).ready(function(){
            dTable_rejected = $('#rejected-table').DataTable({
                "scrollX":true,
                "bLengthChange": false, 
                "lengthMenu": [5], 
                "dom": "lrtp",
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                "ajax": {
                    "url": "datatable/rejected_notes_datatable.php",
                    'data': function(data){
                        // Read values
                        var seller = $('#select_seller').val();
                        // alert(month);

                        // // Append to data
                        data.searchByseller = seller;
                    }
                },
                "columns": [
                    {data: "sr_no"},
                    {   
                        data : 'NoteTitle',
                        render: function (data,type,row) {
                            return '<a href="notes_details_admin.php?note='+row.NoteID+'">'+row.NoteTitle+'</a>';
                        }
                    },
                    {data: "Category"},
                    {data: "Seller"},
                    {
                        orderable: false,
                        render: function(data,type,row){
                            return '<span class="profile-table-icons"><a href="member_details.php?member='+row.SellerID+'"><img src="../images/front/eye.png" alt="view file image"></a></span>';
                        }
                    },
                    {data: 'ModifiedDate'},
                    {data: 'ActionedBy'},
                    {data: 'AdminRemark'},
                    {  
                        orderable: false,
                        render: function (data,type,row) {
                            // alert(data);
                            return '<span class="profile-table-icons"><span class="dropdown"><a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown"><a class="dropdown-item approve" note-id="'+row.NoteID+'">Approve</a><a class="dropdown-item download" notes="'+row.NoteFile+'">Download Notes</a><a class="dropdown-item" href="notes_details_admin.php?note='+row.NoteID+'">View More Details</a></div></span></span>';
                        }
                    }
                ],
            });
        
            $('#rejected-search-btn').on("click",function() {
                dTable_rejected.search($("#rejected-search").val()).draw();
            });

            $("#select_seller").on("change",function(){
                dTable_rejected.draw();
            });

            $("body").delegate('.download','click',function(){
            
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

            // Action on click of Accept Button 
            $("body").delegate('.approve','click',function(){
                // alert("chhagan");
                var note_id = $(this).attr('note-id');
                var approve = 'approve';
                var c = confirm("If you approve the notes - System will publish the notes over portal. Please press yes to continue.");
                
                if(c == true){
                    $.get('notes_review_action.php',{approve : approve,note_id : note_id},function(data){
                        dTable_rejected.draw();
                    });    
                }
            });
        });
        </script>
    </body>
</html>