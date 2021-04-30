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
        $country = mysqli_real_escape_string($connection,$_POST['country']);
        $country_code = mysqli_real_escape_string($connection,$_POST['country_code']);
        $date = date('YmdHis');

        if(!empty($_POST['country_id'])){
            $country_id = mysqli_real_escape_string($connection,$_POST['country_id']);

            $query = "UPDATE countrytable SET CountryName='{$country}',CountryCode='{$country_code}',ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE countryID = $country_id";
            $update_country_query = mysqli_query($connection,$query);
            confirmQuery($update_country_query);
            header("Location:manage_country.php");

        }
        else{
            $query = "INSERT INTO countrytable (CountryName, CountryCode, CreatedDate, CreatedBy) VALUES('{$country}','{$country_code}','{$date}','{$user_id}')";
            $insert_country_query = mysqli_query($connection,$query);
            confirmQuery($insert_country_query);
            header("Location:manage_country.php");
        }
    }
    else if(isset($_GET['id'])){ 
        $country_id = $_GET['id'];
        $query = "SELECT * FROM countrytable WHERE countryID = $country_id";
        $get_data_query = mysqli_query($connection,$query);
        confirmQuery($get_data_query);

        $row = mysqli_fetch_array($get_data_query);
        $country = $row['CountryName'];
        $country_code = $row['CountryCode'];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Add Country';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <form action="add_country.php" method="post" id="form" class="box">
        
            <!-- Add Country form -->
            <div class="form-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-9">  

                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Add Country</h2>
                                </div>
                            </div>

                            <input type="hidden" name="country_id" id="country_id" value="<?php echo isset($country_id)?$country_id:'';?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Country Name *</label>
                                        <input type="text" id="country" class="form-control" name="country" placeholder="Enter country name" value="<?php echo isset($country) ? $country : '' ?>" required>
                                        <div class="error-message"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Country Code *</label>
                                        <input type="text" name="country_code" class="form-control" placeholder="Enter country code" value="<?php echo isset($country_code) ? $country_code : '' ?>" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="submit-btn"><?php echo isset($country_id)?'Update':'Submit'?></button>
            </div> 
        </form>

       
        <?php include 'includes/footer.php';?>

        <script type="text/javascript">
        
        $(function(){
            $("#country").on('keyup',function(){
                Isvalidcountry();
            });

            function Isvalidcountry(){
                var country = $("#country").val();

                if(country.match(/[0-9]/)){
                    $("#country").siblings(".error-message").text("Numeric entry should not be allowed");
                    $("#country").focus();
                    return false;
                }
                else{
                    $("#country").siblings(".error-message").text("");
                    return true;
                }
            }

            $("#form").on("submit",function(e){

                if(!Isvalidcountry()){
                    e.preventDefault();
                }   
            });
        });                      

        </script>
    </body>
</html>