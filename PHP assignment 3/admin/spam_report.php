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

    $query = "SELECT spamnotes.SpamID, spamnotes.NoteID, spamnotes.Remark, spamnotes.CreatedDate, notes.NoteTitle, notes.NoteFile, user.FirstName, user.LastName, (SELECT Category FROM categorytable WHERE categorytable.CategoryID = notes.CategoryID AND categorytable.IsActive=1) AS Category  FROM spamnotes JOIN notes ON spamnotes.NoteID = notes.NoteID JOIN user ON spamnotes.CreatedBy = user.userID ORDER BY spamnotes.CreatedDate desc";
    $spam_data_query = mysqli_query($connection, $query);
    if(!$spam_data_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Spam Report';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <!-- Spam Report table -->
        <div class="admin-table box" style="margin-top: 160px;">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-7 col-md-6" style="padding-left: 15px;">
                        <h3 class="m-0">Spam Reports</h3>
                    </div>
                    <div class="col-lg-5 col-md-6 text-right">
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="search" id="spam-search" placeholder="Search">
                            </div>

                            <div class="col-4 pl-0">
                                <button class="search-button" id="spam-search-btn">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="spam-report-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Reported By</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Date Edited</th>
                            <th>Remark</th>
                            <th class="text-center">Action</th>
                            <th></th>
                        </tr>
                    </thead>
        
                    <tbody>
                    <?php
                        $count = 0;
                        while($row = mysqli_fetch_array($spam_data_query)){
                            $count++;
                            $created_date = $row['CreatedDate'];
                            $created_date = date('d-m-Y, H:i',strtotime($created_date));
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td><?php echo $row['FirstName'].' '.$row['LastName']?></td>
                            <td class="color-text"><a href="notes_details_admin.php?note=<?php echo $row['NoteID'];?>"><?php echo $row['NoteTitle'];?></a></td>
                            <td><?php echo $row['Category'];?></td>
                            <td><?php echo $created_date;?></td>
                            <td><?php echo $row['Remark'];?></td>
                            <td class="text-center">
                                <span class="profile-table-icons">
                                    <a class="delete" href="" spam-id=<?php echo $row['SpamID'];?>><img src="../images/front/delete.png" alt="delete logo"></a>
                                </span>
                            </td>
                            <td>
                                <span class="profile-table-icons">
                                    <span class="dropdown">
                                        <a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a>
                                    
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
                                            <a class="dropdown-item download" notes="<?php echo $row['NoteFile']?>">Download Notes</a>
                                            <a class="dropdown-item" href="notes_details_admin.php?note=<?php echo $row['NoteID'];?>">View More Details</a>
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

        $(".delete").on('click',function(){
            var SpamID = $(this).attr('spam-id');
            var delete_spam = 'delete_spam';

            // alert(SpamID);
            var c = confirm('Are you sure you want to delete reported issue?');
            if(c == true){
                $.post('notes_review_action.php',{delete_spam:delete_spam,SpamID:SpamID},function(data){
                    // alert('chhagan');
                });
            }
        });

        </script>
    </body>
</html>