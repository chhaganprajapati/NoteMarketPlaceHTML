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

    $query = "SELECT typetable.TypeID, typetable.TypeName, typetable.Description, typetable.CreatedDate, typetable.IsActive, user.FirstName, user.LastName FROM typetable JOIN user ON typetable.CreatedBy = user.UserID ORDER BY typetable.CreatedDate desc";
    $type_table_data = mysqli_query($connection, $query);
    confirmQuery($type_table_data); 
?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Manage Type';
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
                        <h3>Manage Type</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-md-6" style="padding-left: 15px;">
                        <a href="add_type.php"><button>Add Type</button></a>
                    </div>
                    <div class="col-lg-5 col-md-6 text-right">
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="search" id="type-search" placeholder="Search">
                            </div>

                            <div class="col-4 pl-0">
                                <button class="search-button" id="type-search-btn">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="manage-type-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Date Added</th>
                            <th>Added By</th>
                            <th class="text-center">Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <?php
                            $count = 0;
                            while($row = mysqli_fetch_array($type_table_data)){
                                $count++;
                                $created_date = $row['CreatedDate'];
                                $created_date = date('d-m-Y, H:i',strtotime($created_date));
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td><?php echo $row['TypeName'];?></td>
                            <td><?php echo $row['Description'];?></td>
                            <td><?php echo $created_date;?></td>
                            <td><?php echo $row['FirstName'].' '.$row['LastName'];?></td>
                            <td class="text-center"><?php echo ($row['IsActive'] == 1)?'Yes':'No';?></td>
                            <td>
                                <span class="profile-table-icons">
                                    <a href="add_type.php?id=<?php echo $row['TypeID'];?>" class="mr-3"><img src="../images/front/edit.png" alt="edit image"></a>
                                    <a class="<?php echo ($row['IsActive'] == 1)?'deactivate':'';?>" data-id=<?php echo $row['TypeID'];?>><img src="../images/front/delete.png" alt="delete image"></a>
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
                var type_id = $(this).attr('data-id');
                var DeActivate_type = 'DeActivate_type';
                var c = confirm("Are you sure you want to make this type inactive?");
                
                if(c == true){
                    $.post('admin_validation.php',{DeActivate_type : DeActivate_type,type_id : type_id},function(data){
                        location.reload();
                    });    
                }
            });
        </script>
    </body>
</html>