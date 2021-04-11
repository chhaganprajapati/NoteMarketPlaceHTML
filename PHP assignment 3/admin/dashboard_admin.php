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

    // NUmber of notes in review
    $query = "SELECT COUNT(*) AS NotesInReview FROM notes WHERE NoteStatusID = 3 and IsActive = 1;";
    $notes_review_query = mysqli_query($connection, $query);
    if(!$notes_review_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $row = mysqli_fetch_array($notes_review_query);
    $NotesInReview = $row['NotesInReview'];

    // NUmber of new downloads in last 7 days
    $query = "SELECT COUNT(*) AS NewDownloads FROM downloads WHERE AttachmentDownloadedDate >= DATE(NOW()) - INTERVAL 7 DAY and IsAttachmentDownloaded = 1 and IsActive = 1;";
    $new_downloads_query = mysqli_query($connection, $query);
    if(!$new_downloads_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $row = mysqli_fetch_array($new_downloads_query);
    $NewDownloads = $row['NewDownloads'];

    // NUmber of new registration in last 7 days
    $query = "SELECT COUNT(*) AS NewRegistration FROM user WHERE CreatedDate >= DATE(NOW()) - INTERVAL 7 DAY and RoleID=3 and IsActive = 1;";
    $new_registration_query = mysqli_query($connection, $query);
    if(!$new_registration_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $row = mysqli_fetch_array($new_registration_query);
    $NewRegistration = $row['NewRegistration'];
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Dashboard Admin</title>

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
                            <li><a href="#" class="link active">Dashboard</a></li>
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
                        <li><a href="#" class="active">Dashboard</a></li>
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

        <!-- Stats -->
        <div id="dashboard-admin" class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Dashboard</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-6">
                        <div class="dashboard-item">
                            <div>
                                <h4><a href="notes_under_review.php"><?php echo $NotesInReview;?></a></h4>
                                <h6>Number of Notes in Review for Publish</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="dashboard-item">
                            <div>
                                <h4><a href="downloaded_notes.php"><?php echo $NewDownloads;?></a></h4>
                                <h6>Number of New Notes Downloaded (Last 7 days)</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="dashboard-item">
                            <div>
                                <h4><a href="members.php"><?php echo $NewRegistration;?></a></h4>
                                <h6>Number of New Registrations (Last 7 days)</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> 
        <!-- Stats Ends -->

        <!-- Published Notes table -->
        <div class="admin-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-4 col-12">
                        <h2>Published Notes</h2>
                    </div>
                    <div class="col-lg-4 col-md-6 col-8 text-right">
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="search" id="published-search" placeholder="Search">
                            </div>

                            <div class="col-4 pl-0">
                                <button class="search-button" id="published-search-btn">Search</button>
                            </div>
                        </div>
                        
                        
                    </div>
                    <?php 
                        $month = date('F');
                        $month_no = date('m');
                        $year = date('Y');

                    ?>
                    <div class="col-lg-2 col-md-2 col-4 pl-0">
                        <select class="form-control" id="note_month">
                            <option value="<?php echo $year.'-'.$month_no;?>" selected hidden>Select month</option>
                            <option value="<?php echo $year.'-'.$month_no;?>">Current</option>
                            <?php 
                                for ($i=1; $i<=6 ; $i++) {
                                    $year = ($month_no-1 > 0)?$year:$year-1;
                                    $month_no = (($month_no-1) > 0)?$month_no-1:($month_no-1+12);                                 
                                    $dateObj   = DateTime::createFromFormat('m', $month_no);
                                    $month = $dateObj->format('F'); 
                            ?>
                                    <option value="<?php echo $year.'-';?><?php echo ($month_no <10 )?'0'.$month_no:$month_no;?>"><?php echo $month;?></option>
                            <?php      
                                }
                            ?>
                        </select>
                        <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                    </div>
                </div>

                <table id="published-notes-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th class="text-center">Attachment size</th>
                            <th class="text-center">sell Type</th>
                            <th>Price</th>
                            <th>Publisher</th>
                            <th>Published date</th>
                            <th class="text-center">Number of Downloads</th>
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

         <!-- Review Modal -->
        <div class="modal fade" id="UnpublishModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <div class="col-md-12" id="reject-content">
                                    <h2></h2>
                                    <form id="RejectForm">   
                                        <input type="hidden" id="NoteID" name="note_id">
                                        <h5>Remarks *</h5>  
                                        <textarea class="form-control" name="remark" placeholder="Write remarks" required></textarea>
                                        <div class="row">
                                            <div class="col-md-12 reject-btn">
                                                <button type="submit">Unpublish</button>
                                                <button type="button" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                      
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
        <!-- Review Modal Ends-->

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

            dTable_progress = $('#published-notes-table').DataTable({
                "scrollX":true,
                "bLengthChange": false, 
                "lengthMenu": [5], 
                "dom": "lrtp",
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                "ajax": {
                    "url": "datatable/published_dashboard_datable.php",
                    'data': function(data){
                        // Read values
                        var month = $('#note_month').val();
                        // alert(month);

                        // // Append to data
                        data.searchBymonth = month;
                    }
                },
                "columns": [
                    {data: "sr_no"},
                    {   
                        data: "NoteTitle",
                        render: function (data,type,row) {
                            return '<a href="notes_details_admin.php?note='+row.NoteID+'">'+row.NoteTitle+'</a>';
                        }
                    },
                    {data: "Category"},
                    {data: 'AttachmentSize'},
                    {data: "SellType"},
                    {data: "NotePrice"},
                    {data: "Seller"},
                    {data: 'PublishedDate'},
                    {
                        data: 'MyDownloads',
                        render: function (data,type,row) {
                            return '<a href="downloaded_notes.php?NoteID='+row.NoteID+'&Title='+row.NoteTitle+'">'+row.MyDownloads+'</a>';
                        }
                    },
                    {  
                        render: function (data,type,row) {
                            // alert(data);
                            return '<span class="profile-table-icons"><span class="dropdown"><a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown"><a class="dropdown-item download" notes="'+row.NoteFile+'">Download Notes</a><a class="dropdown-item" href="notes_details_admin.php?note='+row.NoteID+'">View More Details</a><a class="dropdown-item unpublish" note-id="'+row.NoteID+'" NoteTitle="'+row.NoteTitle+'" category="'+row.Category+'">Unpublish</a></div></span></span>';
                        }
                    }
                ],
            });
        
            $('#published-search-btn').on("click",function() {
                dTable_progress.search($("#published-search").val()).draw();
            });

            $("#note_month").on("change",function(){
                dTable_progress.draw();
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

            // Action on click of Unpublish Button 
            $("body").delegate('.unpublish','click',function(){
                // alert("chhagan");
                var note_id = $(this).attr('note-id');
                var NoteTitle = $(this).attr('NoteTitle');
                var category =$(this).attr('category');
                var approve = 'approve';
                
                $("#NoteID").val(note_id);
                $("#reject-content h2").text(NoteTitle+' - '+category);

                $("#RejectForm").trigger('reset');
                $("#UnpublishModal").modal('show');
            });


            $("#RejectForm").submit(function(e){
                e.preventDefault();
                var c = confirm("Are you sure you want to Unpublish this note?");

                if(c == true){
                    $("body").css('cursor','wait');
                    data = $("#RejectForm").serialize();
                    $.ajax({
                        url:"notes_review_action.php?unpublish=1",
                        method:"POST",
                        data:data,
                        success:function(response){
                            $("#UnpublishModal").modal('hide');
                            dTable_progress.draw();  
                            $("body").css('cursor','default');
                        }
                    });
                }
            });
        });
        </script>

    </body>
</html>