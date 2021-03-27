<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-FAQ</title>

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
                <a class="navbar-brand" href="#">
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
                                <li><a href="#" class="link active">FAQ</a></li>
                                <li><a href="contact_us.php" class="link">Contact Us</a></li>
                                <li class="dropdown">
                                        <a class="dropbtn">
                                            <img src="../images/front/user-img.png" alt="progile image">
                                        </a>
                                        <div class="dropdown-content">
                                            <a href="#">My Profile</a>
                                            <a href="#">My Downloads</a>
                                            <a href="#">My Sold Notes</a>
                                            <a href="#">My Rejected Notes</a>
                                            <a href="#">Change Password</a>
                                            <a href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                        </div>
                                </li>
                                <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                            <?php }
                            else{ ?>
                                <li><a href="search_notes.php" class="link active">Search Notes</a></li>
                                <li><a href="../login.php" class="link">Sell Your Notes</a></li>
                                <li><a href="#" class="link">FAQ</a></li>
                                <li><a href="contact_us.php" class="link">Contact Us</a></li>
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
                            <li><a href="#" class="active">FAQ</a></li>
                            <li><a href="contact_us.php">Contact Us</a></li>
                            <li class="dropdown">
                                <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/user-img.png" alt="progile image"></a>
                            
                                <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                                    <a class="dropdown-item" href="#">My Profile</a>
                                    <a class="dropdown-item" href="#">My Downloads</a>
                                    <a class="dropdown-item" href="#">My Sold Notes</a>
                                    <a class="dropdown-item" href="#">My Rejected Notes</a>
                                    <a class="dropdown-item" href="#">Change Password</a>
                                    <a class="dropdown-item" href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                </div>
                            </li>
                            <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                    <?php }
                        else{ ?>
                            <li><a href="search_notes.php" class="active">Search Notes</a></li>
                            <li><a href="../login.php">Sell Your Notes</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="contact_us.php">Contact Us</a></li>
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
                        <h1 class="text-center">Frequently Asked Questions</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner Ends -->

        <div class="box">

            <!-- General Questions -->
            <div class="question-group">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>General Questions</h2>

                            <div class="question">
                                <button class="accordion">What is Notes Marketplace?</button>
                                <div class="panel">
                                    <p>Notes Marketplace is an online marketplace for university students to buy and sell their course notes.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">Where did Notes Marketplace start?</button>
                                <div class="panel">
                                    <p>What started out as four friends chucking around an idea in Ahmedabad ended up turning into an
                                        earliest version of Notes Marketplace. So, with 2021 batch of tatvasoft – we has developed this product.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Uploaders Questions -->
            <div class="question-group">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Uploaders</h2>

                            <div class="question">
                                <button class="accordion">Why should I upload now?</button>
                                <div class="panel">
                                    <p>To maximize sales. We can't sell your notes if they are rotting on your hard drive. Your notes are
                                        available for purchase the instant they are approved, which means that you could be missing potential
                                        sales as we speak. Despite exam and holiday breaks, our users purchase notes all year round, so the best
                                        time to upload notes is always today.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">What can't I sell?</button>
                                <div class="panel">
                                    <p>We won't approve materials that have been created by your university or another third party. We also
                                        do not accept assignments, essays, practical’s or take-home exams. We love notes though.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">How long does it take to upload?</button>
                                <div class="panel">
                                    <p>Uploading notes is quick and easy. It can take as little as 90 seconds per set of notes. Put it this way, in
                                        the time it took to read these FAQs, you could’ve uploaded several sets of notes.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Downloaders Questions -->
            <div class="question-group" style="margin-bottom: 60px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Downloaders</h2>

                            <div class="question">
                                <button class="accordion">How do I buy notes?</button>
                                <div class="panel">
                                    <p>Search for the notes you are after using the 'SEARCH NOTES' tab at the at the top right of every page.
                                        You can then filter results by university, category, course information etc. To purchase, go to detail page
                                        of note and click on download button. If notes are free to download – it will download over the browser
                                        and if notes are paid, Once Seller will allow download you can have notes at my downloads grid for
                                        actual download.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">Why should I buy notes?</button>
                                <div class="panel">
                                    <p>The notes on our site are incredibly useful as an educational tool when used correctly. They effectively
                                        demonstrate the techniques that top students employ in order to receive top marks. They also
                                        summaries the course in a concise format and show what that student believed were the most
                                        important elements of the course. Learn from the best.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">Will downloading notes guarantee I improve my grades?</button>
                                <div class="panel">
                                    <p>How long is a piece of string? However, 90% of students who purchased notes through our site said that
                                        doing so improved their grades.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer -->
        <footer class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-8">
                        <p>Copyright &copy; TatvaSOft All rigths reserved.</p>
                    </div>
                    <div class="col-md-6 col-4 text-right">
                        <ul class="social-list">
                            <li><a href="#"><img src="../images/home/facebook.png" alt="facebook icon"></a></li>
                            <li><a href="#"><img src="../images/home/twitter.png" alt="twitter icon"></a></li>
                            <li><a href="#"><img src="../images/home/linkedin.png" alt="linkedin icon"></a></li>
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
    </body>
</html>