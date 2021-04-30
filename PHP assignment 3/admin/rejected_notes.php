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
    <?php $title = 'Rejected Notes';
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
       
        <?php include 'includes/footer.php';?>

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