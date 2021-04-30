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

    $query = "SELECT DISTINCT notes.SellerID,user.FirstName FROM notes JOIN user ON notes.SellerID = user.UserID WHERE notes.NoteStatusID = 4 AND notes.IsActive = 1";
    $seller_get_query = mysqli_query($connection,$query);
    if(!$seller_get_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Published Notes';
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
                        <h3>Published Notes</h3>
                    </div>
                    <div class="col-md-12">
                        <h4>Seller</h4>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6">
                        <select class="form-control" id="select_seller">
                            <option selected disabled hidden>Select Seller</option>
                            <?php 
                            if($_GET['user_id']){
                                echo '<option value="'.$_GET['user_id'].'" selected>'.$_GET['fname'].'</option>';
                            }
                            else{
                                while($row = mysqli_fetch_array($seller_get_query)){
    
                                        echo '<option value="'.$row['SellerID'].'">'.$row['FirstName'].'</option>';                              
                                }
                            }?>
                        </select>
                        <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                    </div>
                    <div class="col-lg-5 col-md-3"></div>
                    <div class="col-lg-5 col-md-6 text-right">
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="search" id="publish-search" placeholder="Search">
                            </div>

                            <div class="col-4 pl-0">
                                <button class="search-button" id="publish-search-btn">Search</button>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <table id="published-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Sell Type</th>
                            <th>Price</th>
                            <th>Seller</th>
                            <th></th>
                            <th>Published Date</th>
                            <th>Approved By</th>
                            <th class="text-center">Number of Downloads</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                
            </div>
        </div>
        <!-- Published Notes table Ends-->

         <!-- Review Modal -->
        <div class="modal fade secondmodal" id="UnpublishModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        <?php include 'includes/footer.php';?>

        <script type="text/javascript">

        $(document).ready(function(){
            dTable_publish = $('#published-table').DataTable({
                "scrollX":true,
                "bLengthChange": false, 
                "lengthMenu": [5], 
                "dom": "lrtp",
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                "ajax": {
                    "url": "datatable/published_notes_datatable.php",
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
                    {data: "SellType"},
                    {data: "NotePrice"},
                    {data: "Seller"},
                    {
                        orderable: false,
                        render: function(data,type,row){
                            return '<span class="profile-table-icons"><a href="member_details.php?member='+row.SellerID+'"><img src="../images/front/eye.png" alt="view file image"></a>    </span>';
                        }
                    },
                    {data: 'PublishedDate'},
                    {data: 'ActionedBy'},
                    {
                        data : 'Downloads',
                        render: function (data,type,row) {
                            return '<a href="downloaded_notes.php?NoteID='+row.NoteID+'&Title='+row.NoteTitle+'">'+row.Downloads+'</a>';
                        }
                    },
                    {  
                        orderable: false,
                        render: function (data,type,row) {
                            // alert(data);
                            return '<span class="profile-table-icons"><span class="dropdown"><a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown"><a class="dropdown-item download" notes="'+row.NoteFile+'">Download Notes</a><a class="dropdown-item" href="notes_details_admin.php?note='+row.NoteID+'">View More Details</a><a class="dropdown-item unpublish" note-id="'+row.NoteID+'" NoteTitle="'+row.NoteTitle+'" category="'+row.Category+'">Unpublish</a></div></span></span>';
                        }
                    }
                ],
            });
        
            $('#publish-search-btn').on("click",function() {
                dTable_publish.search($("#publish-search").val()).draw();
            });

            $("#select_seller").on("change",function(){
                dTable_publish.draw();
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
                            dTable_publish.draw();  
                            $("body").css('cursor','default');
                        }
                    });
                }
            });
        });
        </script>
    </body>
</html>