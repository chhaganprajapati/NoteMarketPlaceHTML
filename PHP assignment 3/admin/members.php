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
    <?php $title = 'Members';
    include 'includes/header.php';?>
    <body>

        <?php $member = 'member';
        include 'includes/navbar.php';?>

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
       
        <?php include 'includes/footer.php';?>
                            
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