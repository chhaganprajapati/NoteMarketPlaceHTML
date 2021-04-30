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

    if($role_id_nav != 1){
        header("Location:../index.php");
    }

    $query = 'SELECT * FROM user WHERE RoleID = 2 ORDER BY CreatedDate desc';
    $admin_data_query = mysqli_query($connection,$query);
    if(!$admin_data_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Manage Administrator';
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
                        <h3>Manage Administrator</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-md-6" style="padding-left: 15px;">
                        <a href="add_admin.php"><button>Add Administrator</button></a>
                    </div>
                    <div class="col-lg-5 col-md-6 text-right">
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="search" id="admin-search" placeholder="Search">
                            </div>

                            <div class="col-4 pl-0">
                                <button class="search-button" id="admin-search-btn">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="manage-admin-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone No.</th>
                            <th>Date Added</th>
                            <th class="text-center">Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <?php
                        $count = 0;
                        while($row = mysqli_fetch_array($admin_data_query)){
                            $count++;     
                            if(!empty($row['PhoneNo'])){
                                $phone_no = explode(' ',$row['PhoneNo'])[1];
                            }   
                            $created_date = $row['CreatedDate'];
                            $created_date = date('d-m-Y, H:i',strtotime($created_date));
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td><?php echo $row['FirstName'];?></td>
                            <td><?php echo $row['LastName'];?></td>
                            <td><?php echo $row['EmailID'];?></td>
                            <td><?php echo $phone_no;?></td>
                            <td><?php echo $created_date;?></td>
                            <td class="text-center"><?php echo ($row['IsActive'] == 1)?'Yes':'No';?></td>
                            <td>
                                <span class="profile-table-icons">
                                    <a href="add_admin.php?id=<?php echo $row['UserID'];?>" class="mr-3"><img src="../images/front/edit.png" alt="edit image"></a>
                                    <a class="<?php echo ($row['IsActive'] == 1)?'deactivate':'';?>" user-id=<?php echo $row['UserID'];?>><img src="../images/front/delete.png" alt="delete image"></a>
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
                var c = confirm("Are you sure you want to make this administrator inactive?");
                
                if(c == true){
                    $.post('notes_review_action.php',{DeActivate : DeActivate,user_id : user_id},function(data){
                        location.reload();
                    });    
                }
            });
        </script>
    </body>
</html>