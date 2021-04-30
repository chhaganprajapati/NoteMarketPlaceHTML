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
        $category = mysqli_real_escape_string($connection,$_POST['category']);
        $description = mysqli_real_escape_string($connection,$_POST['description']);
        $date = date('YmdHis');

        if(!empty($_POST['category_id'])){
            $category_id = mysqli_real_escape_string($connection,$_POST['category_id']);

            $query = "UPDATE categorytable SET Category='{$category}',Description='{$description}',ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE CategoryID = $category_id";
            $update_category_query = mysqli_query($connection,$query);
            confirmQuery($update_category_query);
            header("Location:manage_category.php");

        }
        else{
            $query = "INSERT INTO categorytable (Category, Description, CreatedDate, CreatedBy) VALUES('{$category}','{$description}','{$date}','{$user_id}')";
            $insert_category_query = mysqli_query($connection,$query);
            confirmQuery($insert_category_query);
            header("Location:manage_category.php");
        }
    }
    else if(isset($_GET['id'])){ 
        $category_id = $_GET['id'];
        $query = "SELECT * FROM categorytable WHERE CategoryID = $category_id";
        $get_data_query = mysqli_query($connection,$query);
        confirmQuery($get_data_query);

        $row = mysqli_fetch_array($get_data_query);
        $category = $row['Category'];
        $description = $row['Description'];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Add Category';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <form action="add_category.php" method="post" id="form" class="box">
        
            <!-- Add Category form -->
            <div class="form-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-9">  

                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Add Category</h2>
                                </div>
                            </div>

                            <input type="hidden" name="category_id" id="category_id" value="<?php echo isset($category_id)?$category_id:'';?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Category Name *</label>
                                        <input type="text" id="category" class="form-control" name="category" placeholder="Enter Category name" value="<?php echo isset($category) ? $category : '' ?>" required>
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
                
                <button type="submit" name="submit-btn"><?php echo isset($category_id)?'Update':'Submit'?></button>
            </div> 
        </form>

       
        <?php include 'includes/footer.php';?>
        
        <script type="text/javascript">
        
        $(function(){
            $("#category").on('keyup',function(){
                IsvalidCategory();
            });

            function IsvalidCategory(){
                var category = $("#category").val();

                if(category.match(/[0-9]/)){
                    $("#category").siblings(".error-message").text("Numeric entry should not be allowed");
                    $("#category").focus();
                    return false;
                }
                else{
                    $("#category").siblings(".error-message").text("");
                    return true;
                }
            }

            $("#form").on("submit",function(e){

                if(!IsvalidCategory()){
                    e.preventDefault();
                }   
            });
        });                      

        </script>
    </body>
</html>