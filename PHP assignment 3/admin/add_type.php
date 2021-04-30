<?php
    date_default_timezone_set('Asia/Kolkata');
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

    if(isset($_POST['submit-btn'])){
        $type = mysqli_real_escape_string($connection,$_POST['type']);
        $description = mysqli_real_escape_string($connection,$_POST['description']);
        $date = date('YmdHis');

        if(!empty($_POST['type_id'])){
            $type_id = mysqli_real_escape_string($connection,$_POST['type_id']);

            $query = "UPDATE typetable SET TypeName='{$type}',Description='{$description}',ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE typeID = $type_id";
            $update_type_query = mysqli_query($connection,$query);
            confirmQuery($update_type_query);
            header("Location:manage_type.php");

        }
        else{
            $query = "INSERT INTO typetable (TypeName, Description, CreatedDate, CreatedBy) VALUES('{$type}','{$description}','{$date}','{$user_id}')";
            $insert_type_query = mysqli_query($connection,$query);
            confirmQuery($insert_type_query);
            header("Location:manage_type.php");
        }
    }
    else if(isset($_GET['id'])){ 
        $type_id = $_GET['id'];
        $query = "SELECT * FROM typetable WHERE typeID = $type_id";
        $get_data_query = mysqli_query($connection,$query);
        confirmQuery($get_data_query);

        $row = mysqli_fetch_array($get_data_query);
        $type = $row['TypeName'];
        $description = $row['Description'];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Add Type';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <form action="add_type.php" method="post" id="form" class="box">
        
            <!--Add Type form-->
            <div class="form-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-9">  

                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Add Type</h2>
                                </div>
                            </div>

                            <input type="hidden" name="type_id" id="type_id" value="<?php echo isset($type_id)?$type_id:'';?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Type *</label>
                                        <input type="text" id="type" class="form-control" name="type" placeholder="Enter Type name" value="<?php echo isset($type) ? $type : '' ?>" required>
                                        <div class="error-message"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description *</label>
                                        <textarea class="form-control" name="description" placeholder="Enter your description" style="height: 151px;" required><?php echo isset($description) ? $description : '' ?></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="submit-btn"><?php echo isset($type_id)?'Update':'Submit'?></button>
            </div> 
        </form>

       
        <?php include 'includes/footer.php';?>

        <script type="text/javascript">
        
        $(function(){
            $("#type").on('keyup',function(){
                Isvalidtype();
            });

            function Isvalidtype(){
                var type = $("#type").val();

                if(type.match(/[0-9]/)){
                    $("#type").siblings(".error-message").text("Numeric entry should not be allowed");
                    $("#type").focus();
                    return false;
                }
                else{
                    $("#type").siblings(".error-message").text("");
                    return true;
                }
            }

            $("#form").on("submit",function(e){

                if(!Isvalidtype()){
                    e.preventDefault();
                }   
            });
        });                      

        </script>
    </body>
</html>