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
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Contact Us</title>

        <!--Meta tags-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

        <!--Favicon-->
        <link rel="icon" href="../images/favicon.ico">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!--bootstarp css-->
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">

        <!--Custom css-->
        <link rel="stylesheet" href="../css/user-style.css">

        <!--Responsive css-->
        <link rel="stylesheet" href="../css/user-responsive.css">
    </head>
    <body>

        <!--Navbar-->
        <nav class="navbar fixed-top navbar-expand-lg box white-nav-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php">
                    <img src="../images/home/logo.png" alt="NotesMarketPlace logo">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-nav" aria-controls="mobile-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-icon">&#9776;</span>
                </button>

                <!-- Mobile Nav menu bar -->
                <div id="mobile-nav" class="collapse navbar-collapse">

                    <span id="mobile-nav-logo"><img src="../images/home/logo.png" alt="NotesMarketPlace logo"></span>
                    <!--Close button-->
                    <span id="mobile-nav-close-btn">&times;</span>

                    <div id="mobile-nav-content">
                        <ul class="navbar-nav">
                            <?php if(isset($_SESSION['user_id'])){ ?>
                                <li><a href="search_notes.php" class="link">Search Notes</a></li>
                                <li><a href="dashboard.php" class="link">Sell Your Notes</a></li>
                                <li><a href="buyer_requests.php" class="link">Buyer Requests</a></li>
                                <li><a href="FAQ.php" class="link">FAQ</a></li>
                                <li><a href="#" class="link active">Contact Us</a></li>
                                <li class="dropdown">
                                    <a class="dropbtn">
                                        <img src=<?php echo $profile_image_nav;?> alt="progile image">
                                    </a>
                                    <div class="dropdown-content">
                                        <a href="user_profile.php">My Profile</a>
                                        <a href="my_downloads.php">My Downloads</a>
                                        <a href="my_sold_notes.php">My Sold Notes</a>
                                        <a href="my_rejected_notes.php">My Rejected Notes</a>
                                        <a href="../change_password.php">Change Password</a>
                                        <a href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                    </div>
                                </li>
                                <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                            <?php }
                            else{ ?>
                                <li><a href="search_notes.php" class="link">Search Notes</a></li>
                                <li><a href="../login.php" class="link">Sell Your Notes</a></li>
                                <li><a href="FAQ.php" class="link">FAQ</a></li>
                                <li><a href="#" class="link active">Contact Us</a></li>
                                <li style="padding-right:0;"><a href="../login.php" style="border: none;"><button>Login</button></a></li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Nav menu bar Ends-->

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ml-auto">
                    <?php if(isset($_SESSION['user_id'])){ ?>
                            <li><a href="search_notes.php">Search Notes</a></li>
                            <li><a href="dashboard.php">Sell Your Notes</a></li>
                            <li><a href="buyer_requests.php">Buyer Requests</a></li>
                            <li><a href="FAQ.php">FAQ</a></li>
                            <li><a href="contact_us.php" class="active">Contact Us</a></li>
                            <li class="dropdown">
                                <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src=<?php echo $profile_image_nav;?> alt="progile image"></a>
                                
                                <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                    <a class="dropdown-item" href="user_profile.php">My Profile</a>
                                    <a class="dropdown-item" href="my_downloads.php">My Downloads</a>
                                    <a class="dropdown-item" href="my_sold_notes.php">My Sold Notes</a>
                                    <a class="dropdown-item" href="my_rejected_notes.php">My Rejected Notes</a>
                                    <a class="dropdown-item" href="../change_password.php">Change Password</a>
                                    <a class="dropdown-item" href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                </div>
                            </li>
                            <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                    <?php }
                        else{ ?>
                            <li><a href="search_notes.php">Search Notes</a></li>
                            <li><a href="../login.php">Sell Your Notes</a></li>
                            <li><a href="FAQ.php">FAQ</a></li>
                            <li><a href="#" class="active">Contact Us</a></li>
                            <li style="padding-right:0;"><a href="../login.php" style="border: none;"><button>Login</button></a></li>
                    <?php }
                        ?>
                    </ul>
                </div>   
            </div>
        </nav>
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

        <!-- Footer -->
        <footer class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-8">
                        <p>Copyright &copy; TatvaSOft All rigths reserved.</p>
                    </div>
                    <div class="col-md-6 col-4 text-right">
                        <ul class="social-list">
                            <li><a href=<?php echo GetfacebookURL();?>><img src="../images/home/facebook.png" alt="facebook icon"></a></li>
                            <li><a href=<?php echo GettwitterURL();?>><img src="../images/home/twitter.png" alt="twitter icon"></a></li>
                            <li><a href=<?php echo GetlinkedinURL();?>><img src="../images/home/linkedin.png" alt="linkedin icon"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
         <!-- Footer Ends-->


        <!--JQuery-->
        <script src="../js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="../js/bootstrap/bootstrap.min.js"></script>

        <!--Custom JS-->
        <script src="../js/script.js"></script>

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
        </script>

    </body>
</html>