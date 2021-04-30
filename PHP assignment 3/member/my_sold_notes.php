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

    $query = "SELECT downloads.DownloadID, downloads.NoteID, downloads.NotePrice, downloads.CreatedDate, user.EmailID, notes.NoteTitle, notes.CategoryID, notes.SellType, notes.NoteFile FROM downloads JOIN user ON downloads.BuyerID=user.UserID JOIN notes ON downloads.NoteID = notes.NoteID WHERE downloads.SellerID = '$user_id' and downloads.RequestStatus = 1 and downloads.IsActive = 1 ORDER BY downloads.CreatedDate desc";
    $my_sold_query = mysqli_query($connection,$query);
    if(!$my_sold_query){
        die("QUERY FAILED".mysqli_error($connection));
    }  
?>

<!DOCTYPE html>
<html lang="en">
    <?php $title = 'My Sold Notes';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <!-- My Sold note table -->
        <div class="profile-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-5 col-12">
                        <h2>My Sold Notes</h2>
                    </div>
                    <div class="col-md-6 col-sm-7 col-12 text-right">
                        <input type="text" class="search" id="sold-search" placeholder="Search">
                        <button class="search-button" id="sold-search-btn">Search</button>
                    </div>
                </div>

                <table id="my-sold-notes-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Buyer</th>
                            <th>Sell Type</th>
                            <th>Price</th>
                            <th>Downloaded date/time</th>
                            <th></th>
                        </tr>
                    </thead>
        
                    <tbody>
                    <?php
                        $count = 0;
                        while($row = mysqli_fetch_array($my_sold_query)){
                            $category_id = $row['CategoryID'];

                            $query = "SELECT Category FROM categorytable WHERE CategoryID = $category_id and IsActive = 1";
                            $category_query = mysqli_query($connection, $query);
                            if(!$category_query){
                                die("QUERY FAILED".mysqli_error($connection));
                            }

                            $row1 = mysqli_fetch_array($category_query);
    
                            $category = $row1['Category'];
                            $download_id = $row['DownloadID'];
                            $note_id = $row['NoteID'];
                            $title = $row['NoteTitle'];
                            $buyer = $row['EmailID'];
                            $sell_type = $row['SellType'];
                            $note_price = $row['NotePrice'];
                            $date = $row['CreatedDate'];
                            $date = date("d M Y, H:i:s",strtotime($date));
                            $note_file = $row['NoteFile'];
                            $count++;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td><a href="notes_details.php?note=<?php echo $note_id;?>"><?php echo $title;?></a></td>
                            <td><?php echo $category;?></td>
                            <td><?php echo $buyer;?></td>
                            <td><?php if($sell_type == 1){echo'Paid';}else{echo'Free';}?></td>
                            <td>$<?php echo $note_price;?></td>
                            <td><?php echo $date;?></td>
                            <td>
                                <span class="profile-table-icons">
                                <a href="notes_details.php?note=<?php echo $note_id;?>"><img src="../images/Dashboard/eye.png" alt="edit" class="view-icon"></a>
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