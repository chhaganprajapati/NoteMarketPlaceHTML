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


$query = "SELECT downloads.DownloadID, downloads.NoteID, user.EmailID, user.PhoneNo, downloads.NotePrice ,downloads.CreatedDate FROM downloads JOIN user ON downloads.BuyerID = user.UserID WHERE SellerID=$user_id and RequestStatus=0";
$buyer_request_query = mysqli_query($connection, $query);
if(!$buyer_request_query){
    die("QUERY FAILED".mysqli_error($connection));
}


?>

<!DOCTYPE html>
<html lang="en">
    <?php
    $title = 'Buyer Requests';
    include 'includes/header.php';?>
    <body id="body">

        <!--Navbar-->
        <?php 
        $buyer_request = 'active';
        include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <!-- Buyer Request table -->
        <div class="profile-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-5 col-12">
                        <h2>Buyer Requests</h2>
                    </div>
                    <div class="col-md-6 col-sm-7 col-12 text-right">
                        <input type="text" class="search" id="buyer-search" placeholder="Search">
                        <button class="search-button" id="buyer-search-btn">Search</button>
                    </div>
                </div>

                <table id="buyer-request-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Buyer</th>
                            <th>phone No.</th>
                            <th>Sell Type</th>
                            <th>Price</th>
                            <th>Downloaded date/time</th>
                            <th></th>
                        </tr>
                    </thead>
        
                    <tbody>
                    <?php 
                    $count = 0;
                    while($row = mysqli_fetch_array($buyer_request_query)){
                        $download_id = $row['DownloadID'];
                        $note_id = $row['NoteID'];
                        $email = $row['EmailID'];
                        $phone_no = $row['PhoneNo'];
                        $note_price = $row['NotePrice'];
                        $date = $row['CreatedDate'];
                        $date = date("d M Y, H:i:s",strtotime($date));

                        // notes details
                        $query = "SELECT notes.NoteTitle, categorytable.Category FROM notes JOIN categorytable ON notes.CategoryID = categorytable.CategoryID WHERE NoteID=$note_id";
                        $notes_data_query = mysqli_query($connection,$query);
                        if(!$notes_data_query){
                            die("QUERY FAILED".mysqli_error($connection));
                        }
                    
                        $row1 = mysqli_fetch_array($notes_data_query);
                        $note_title = $row1['NoteTitle'];
                        $category = $row1['Category'];

                        $count++;
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td><a href="notes_details.php?note=<?php echo $note_id;?>"><?php echo $note_title;?></a></td>
                            <td><?php echo $category;?></td>
                            <td><?php echo $email;?></td>
                            <td><?php echo $phone_no;?></td>
                            <td>Paid</td>
                            <td>$<?php echo $note_price;?></td>
                            <td><?php echo $date;?></td>
                            <td>
                                <span class="profile-table-icons">
                                    <a href="notes_details.php?note=<?php echo $note_id;?>"><img src="../images/Dashboard/eye.png" alt="edit" class="view-icon"></a>
                                    <span class="dropdown">
                                        <a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a>
                                    
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
                                            <a class="dropdown-item allow-download" download-id="<?php echo $download_id;?>">Allow Download</a>
                                        </div>
                                    </span>
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
        <!-- Buyer Request table Ends-->
      
        <!-- footer include -->
        <?php include 'includes/footer.php'; ?>

        <script type="text/javascript">
           
        $(".allow-download").click(function(){
            
            $("#body").css('cursor','wait');
            var download_id = $(this).attr("download-id");
            $.get("download.php",{allow_download : download_id},function(){
                $("#body").css('cursor','default');
                location.reload();
            });
        });

        </script>
    </body>
</html>