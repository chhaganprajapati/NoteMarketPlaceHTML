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
    <?php $title = 'Member Details';
    include 'includes/header.php';?>

    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
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
        
        <?php include 'includes/footer.php';?>

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