<?php
session_start();
include '../Database/database.php';
include '../functions.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    // Profile Image In Navigation
    $profile_image_nav = ProfileImage($user_id);

    $query = "SELECT FirstName,LastName,EmailID FROM user WHERE UserID=$user_id";
    $user_data_query = mysqli_query($connection, $query);
    if(!$user_data_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    while($row = mysqli_fetch_array($user_data_query)){
        $fname = $row['FirstName'];
        $lname = $row['LastName'];
        $email = $row['EmailID'];
    }
    
}

if(isset($_POST['contact_us_btn'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $comments = $_POST['comments'];

    if(preg_match('/\\d/', $name))
    {
        $message = "Numeric Value is not allowed in name.";
    }

    if(empty($message)){
        //Send mail to admin
        $query = "SELECT SubscriberEmails FROM systemtable WHERE SystemID = 1";
        $get_email_query = mysqli_query($connection,$query);
        confirmQuery($get_email_query);

        $row = mysqli_fetch_array($get_email_query);
        $email_admin = $row['SubscriberEmails'];

        $email_subject = $subject.' - Query';

        $email_body = '<!DOCTYPE html>
        <html lang="en">
            <head>      
                <!-- Google Fonts -->
                <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
            </head>
            <body>
                <table style="width: 600px; padding: 30px;">
                    <tr>
                        <td><img src="../images/front/logo.png"></td>
                    </tr>
                    <tr>
                        <td style="font-size: 18px; line-height: 22px; font-weight: 600; color: #333333; font-family: "Open Sans",sans-serif; padding-top: 20px; padding-bottom: 20px;">Hello,</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>'.$comments.'</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>Regards,<br>'.$name.'</td>
                    </tr>
                </table>     
            </body>
        </html>';

        SendMailToAdmin($email_admin,$email_subject,$email_body);
        if(isset($_SESSION['user_id'])){
            header("Location:dashboard.php");
        }
        else{
            header("Location:../index.php");
        }
    }
}
else{
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Contact Us';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php $contact_us = 'active';
        include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <!-- Banner  -->
        <section class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Contact Us</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner Ends -->

       
        <form action="contact_us.php" method="post" class="box" id="contact-form">

            <div class="form-details">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="mb-2">Get in Touch</h2>
                            <h5>Let us know how to get back to you</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Full Name *</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" value="<?php echo isset($fname) ? $fname.' '.$lname:''?>" required>
                                        <div class="error-message"><?php echo isset($message) ? $message:'' ?></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email Address *</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter your email address" value="<?php echo isset($email) ? $email:''?>" <?php echo isset($email) ? 'disabled':''?> required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Subject *</label>
                                        <input type="text" name="subject" class="form-control" placeholder="Enter your subject" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Comments / Questions *</label>
                                <textarea class="form-control" name="comments" placeholder="Comments..." style="height: 275px;" required></textarea>
                            </div>
                        </div>
                    </div>
                    <button name="contact_us_btn" type="submit">Submit</button>
                </div>
            </div>
        </form>

        <!-- footer include -->
        <?php include 'includes/footer.php'; ?>

        <script type="text/javascript">

            $("#name").on('keyup',function(){
                var name = $(this).val();

                if(name.match(/[0-9]/g)){
                    $("#name").siblings("p.error-message").text("Numeric values are not allowed.");
                }
                else{
                    $("#name").siblings("p.error-message").text("");
                }
            });

            $("button[type='submit']").click(function(){
                $('body').css('cursor','wait');
            });
        </script>

    </body>
</html>