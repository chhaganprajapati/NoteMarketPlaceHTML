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

    $query = "SELECT DISTINCT downloads.SellerID,user.FirstName FROM downloads JOIN user ON downloads.SellerID = user.UserID WHERE downloads.IsAttachmentDownloaded = 1 AND downloads.IsActive = 1";
    $seller_get_query = mysqli_query($connection,$query);
    if(!$seller_get_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $query = "SELECT DISTINCT downloads.BuyerID,user.FirstName FROM downloads JOIN user ON downloads.BuyerID = user.UserID WHERE downloads.IsAttachmentDownloaded = 1 AND downloads.IsActive = 1";
    $buyer_get_query = mysqli_query($connection,$query);
    if(!$buyer_get_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $query = "SELECT DISTINCT downloads.NoteID,notes.NoteTitle FROM downloads JOIN notes ON downloads.NoteID = notes.NoteID WHERE downloads.IsAttachmentDownloaded = 1 AND downloads.IsActive = 1";
    $notes_get_query = mysqli_query($connection,$query);
    if(!$notes_get_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Downloaded Notes';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <!-- Published Notes table -->
        <div class="admin-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Downloaded Notes</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-7 col-12">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <h4>Note</h4>
                                    </div>

                                    <div class="col-md-4 col-4">
                                        <h4>Seller</h4>
                                    </div>

                                    <div class="col-md-4 col-4">
                                        <h4>Buyer</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-7">
                        <div class="row">
                            <div class="col-md-4 col-4">
                                <select class="form-control" id="note-id">
                                    <option selected disabled hidden>Select note</option>
                                    <?php 
                                    if($_GET['NoteID']){
                                        echo '<option value="'.$_GET['NoteID'].'" selected>'.$_GET['Title'].'</option>';
                                    }
                                    else{
                                        while($row = mysqli_fetch_array($notes_get_query)){
                                            echo '<option value="'.$row['NoteID'].'">'.$row['NoteTitle'].'</option>';                              
                                        }
                                    }?>
                                </select>
                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                            </div>

                            <div class="col-md-4 col-4">
                                <select class="form-control" id="select_seller">
                                    <option selected disabled hidden>Select Seller</option>
                                    <?php 
                                    while($row = mysqli_fetch_array($seller_get_query)){
                                        echo '<option value="'.$row['SellerID'].'">'.$row['FirstName'].'</option>';
                                    }?> 
                                </select>
                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                            </div>

                            <div class="col-md-4 col-4"> 
                                <select class="form-control" id="select_buyer">
                                    <option selected disabled hidden>Select buyer</option>
                                    <?php 
                                    if($_GET['user_id']){
                                        echo '<option value="'.$_GET['user_id'].'" selected>'.$_GET['fname'].'</option>';
                                    }
                                    else{
                                        while($row = mysqli_fetch_array($buyer_get_query)){
                                            echo '<option value="'.$row['BuyerID'].'">'.$row['FirstName'].'</option>';                              
                                        }
                                    }?>
                                </select>
                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1"></div>

                    <div class="col-md-5 text-right">
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="search" id="downloaded-search" placeholder="Search">
                            </div>

                            <div class="col-4 pl-0">
                                <button class="search-button" id="downloaded-search-btn">Search</button>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <table id="downloaded-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Buyer</th>
                            <th></th>
                            <th>Seller</th>
                            <th></th>
                            <th>Sell Type</th>
                            <th>Price</th>
                            <th class="text-center">Downloaded Date/Time</th>
                            <th></th>
                        </tr>
                    </thead>
        
                </table>
                
            </div>
        </div>
        <!-- Published Notes table Ends-->
       
        <?php include 'includes/footer.php';?>

        <script type="text/javascript">

        $(document).ready(function(){
            dTable_download = $('#downloaded-table').DataTable({
                "scrollX":true,
                "bLengthChange": false, 
                "lengthMenu": [5], 
                "dom": "lrtp",
                'processing': true,
                'serverSide': true,
                "sortable": true,
                'serverMethod': 'post',
                "ajax": {
                    "url": "datatable/downloaded_notes_datatable.php",
                    'data': function(data){
                        // Read values
                        var seller = $('#select_seller').val();
                        var buyer = $('#select_buyer').val();
                        var note_id = $('#note-id').val();
                        // alert(month);

                        // // Append to data
                        data.searchByseller = seller;
                        data.searchBybuyer = buyer;
                        data.searchByNoteID = note_id;
                        
                    }
                },
                "columns": [
                    {data: "sr_no"},
                    {   
                        data : "NoteTitle",
                        render: function (data,type,row) {
                            return '<a href="notes_details_admin.php?note='+row.NoteID+'">'+row.NoteTitle+'</a>';
                        }
                    },
                    {data: "Category"},
                    {data: "Buyer"},
                    {
                        orderable: false,
                        render: function(data,type,row){
                            return '<span class="profile-table-icons"><a href="member_details.php?member='+row.BuyerID+'"><img src="../images/front/eye.png" alt="view file image"></a></span>';
                        }
                    },
                    {data: "Seller"},
                    {
                        orderable: false,
                        render: function(data,type,row){
                            return '<span class="profile-table-icons"><a href="member_details.php?member='+row.SellerID+'"><img src="../images/front/eye.png" alt="view file image"></a></span>';
                        }
                    },
                    {data: "SellType"},
                    {data: "NotePrice"},
                    {data: 'AttachmentDownloadedDate'},
                    {  
                        orderable: false,
                        render: function (data,type,row) {
                            // alert(data);
                            return '<span class="profile-table-icons"><span class="dropdown"><a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown"><a class="dropdown-item download" notes="'+row.NoteFile+'">Download Notes</a><a class="dropdown-item" href="notes_details_admin.php?note='+row.NoteID+'">View More Details</a></div></span></span>';
                        }
                    }
                ],
            });
        
            $('#downloaded-search-btn').on("click",function() {
                dTable_download.search($("#downloaded-search").val()).draw();
            });

            $("#select_seller").on("change",function(){
                dTable_download.draw();
            });

            $("#select_buyer").on("change",function(){
                dTable_download.draw();
            });

            $("#note-id").on("change",function(){
                dTable_download.draw();
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
        });
        </script>
    </body>
</html>