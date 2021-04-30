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
    <?php $title = 'My Rejected Notes';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
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
      
        <!-- footer include -->
        <?php include 'includes/footer.php'; ?>

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