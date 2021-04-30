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

    $query = "SELECT downloads.DownloadID, downloads.NoteID, downloads.NotePrice, downloads.CreatedDate, user.EmailID, notes.NoteTitle, notes.CategoryID, notes.SellType FROM downloads JOIN user ON downloads.BuyerID=user.UserID JOIN notes ON downloads.NoteID = notes.NoteID WHERE downloads.BuyerID = '$user_id' and downloads.RequestStatus = 1 and downloads.IsActive = 1 ORDER BY downloads.CreatedDate desc";
    $my_downloads_query = mysqli_query($connection,$query);
    if(!$my_downloads_query){
        die("QUERY FAILED".mysqli_error($connection));
    }  
?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'My Downloads';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <!-- My Downloads note table -->
        <div class="profile-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-5 col-12">
                        <h2>My Downloads</h2>
                    </div>
                    <div class="col-md-6 col-sm-7 col-12 text-right">
                        <input type="text" class="search" id="downloads-search" placeholder="Search">
                        <button class="search-button" id="downloads-search-btn">Search</button>
                    </div>
                </div>

                <table id="my-downloads-table" class="datatable display nowrap" style="width: 100%;">
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
                        while($row = mysqli_fetch_array($my_downloads_query)){
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
                                        <a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" class="img-fluid" alt="progile image"></a>
                                    
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
                                            <a class="dropdown-item download" download-id="<?php echo $download_id;?>">Download Note</a>
                                            <a class="dropdown-item review_notes" note-id="<?php echo $note_id;?>">Add Reviews/Feedback</a>
                                            <a class="dropdown-item spam" note-id="<?php echo $note_id;?>" NoteTitle="<?php echo $title;?>">Report as Inappropriate</a>
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
      

        <!-- Review Modal -->
        <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <div class="col-md-12" id="review-content">
                                    <h2>Add Review</h2>
                                    <form id="ReviewForm">   
                                        <input type="hidden" id="NoteID" name="note_id">
                                        <div class="rate">
                                            <input type="radio" id="star5" name="rate" value="5" required/>
                                            <label for="star5" title="text"><img src="../images/front/star-white.png"></label>
                                            <input type="radio" id="star4" name="rate" value="4" />
                                            <label for="star4" title="text"><img src="../images/front/star-white.png"></label>
                                            <input type="radio" id="star3" name="rate" value="3" />
                                            <label for="star3" title="text"><img src="../images/front/star-white.png"></label>
                                            <input type="radio" id="star2" name="rate" value="2" />
                                            <label for="star2" title="text"><img src="../images/front/star-white.png"></label>
                                            <input type="radio" id="star1" name="rate" value="1" />
                                            <label for="star1" title="text"><img src="../images/front/star-white.png"></label>
                                        </div>
                                        <h5>Comments *</h5>  
                                        <textarea class="form-control" name="comments" placeholder="Comments..." required></textarea>
                                        <div id="review-error" class="error-message"></div>
                                        <button id="submit-review-btn" type="submit">Submit</button>
                                    </form>
                                      
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
        <!-- Review Modal Ends-->

        <!-- Spam Modal -->
        <div class="modal fade secondmodal" id="SpamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <input type="hidden" id="note_id_spam" name="note_id">
                                        <h5>Remarks *</h5>  
                                        <textarea class="form-control" name="remark" placeholder="Write remarks" required></textarea>
                                        <div class="row">
                                            <div class="col-md-12 reject-btn">
                                                <button type="submit">Issue</button>
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

        <!-- footer include -->
        <?php include 'includes/footer.php'; ?>
                
        <script type="text/javascript">
           
        $(".download").click(function(){
            
            var download_id = $(this).attr("download-id");
            $.get("download.php",{download_id : download_id},function(data){
                var note = data.split('/');
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

        $(".review_notes").click(function(){
            var note_id = $(this).attr("note-id");
            // alert(note_id);
            $("#ReviewForm").trigger('reset');
            $("#reviewModal").modal('show');
            $('#NoteID').val(note_id);
            
        });

        $("#ReviewForm").submit(function(e){
            e.preventDefault();
            var data = $("#ReviewForm").serialize(); 

            $.ajax({
                url:"add_review.php",
                method:"POST",
                data:data,
                success:function(response){
                    if(response == 'success'){
                        $("#reviewModal").modal('hide');
                    }
                    else{
                        $("#review-error").text('Error in submitting the review please try again letter.');
                    }
                }
            });
        });

        // Action on click of inappropriate Button 
        $(".spam").on('click',function(){
                // alert("chhagan");
                var note_id = $(this).attr('note-id');
                var NoteTitle = $(this).attr('NoteTitle');
                
                // alert(note_id);
                $("#note_id_spam").val(note_id);
                $("#reject-content h2").text(NoteTitle);

                $("#RejectForm").trigger('reset');
                $("#SpamModal").modal('show');
            });


            $("#RejectForm").submit(function(e){
                e.preventDefault();
                var c = confirm("Are you sure you want to mark this report as spam, you cannot update it later?");

                if(c == true){
                    $("body").css('cursor','wait');
                    data = $("#RejectForm").serialize();
                    $.ajax({
                        url:"add_review.php?spam=1",
                        method:"POST",
                        data:data,
                        success:function(response){
                            $("#SpamModal").modal('hide');
                            $("body").css('cursor','default');
                        }
                    });
                }
            });
      
        </script>
        
    </body>
</html>