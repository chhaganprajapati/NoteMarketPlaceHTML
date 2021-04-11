<?php 
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace</title>

        <!--Meta tags-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Favicon-->
        <link rel="icon" href="images/favicon.ico">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!--bootstarp css-->
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

        <!--Custom css-->
        <link rel="stylesheet" href="css/user-style.css">

        <!--Responsive css-->
        <link rel="stylesheet" href="css/user-responsive.css">
    </head>
    <body>

        <!--Navbar-->
        <nav class="navbar fixed-top navbar-expand-lg box home">
            <div class="container-fluid">
                <a class="navbar-brand" id="home-logo" href="#">
                    <img src="images/home/top-logo.png">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-nav" aria-controls="mobile-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-icon">&#9776;</span>
                </button>

                <!-- Mobile Nav menu bar -->
                <div id="mobile-nav" class="collapse navbar-collapse">

                    <span id="mobile-nav-logo"><img src="images/home/logo.png" alt="NotesMarketPlace logo"></span>
                    <!--Close button-->
                    <span id="mobile-nav-close-btn">&times;</span>

                    <div id="mobile-nav-content">
                        <ul class="navbar-nav">
                            <li><a href="member/search_notes.php" class="link">Search Notes</a></li>
                            <li><a href="login.php" class="link">Sell Your Notes</a></li>
                            <li><a href="member/FAQ.php" class="link">FAQ</a></li>
                            <li><a href="member/contact_us.php" class="link">Contact Us</a></li>
                            <li style="padding-right:0;"><a href="login.php" style="border: none;"><button style="color: #fff; background-color: #6255a5;">Login</button></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Nav menu bar Ends-->


                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ml-auto">
                      <li><a href="member/search_notes.php" class="mt-1">Search Notes</a></li>
                      <li> <a href="login.php">Sell Your Notes</a> </li>
                      <li><a href="member/FAQ.php">FAQ</a></li>
                      <li><a href="member/contact_us.php">Contact Us</a></li>
                      <li style="padding-right:0;"><a href="login.php" style="border: none;"><button>Login</button></a></li>
                    </ul>
                </div>   
            </div>
        </nav>
    <!--Navbar Ends-->

        <!-- Banner  -->
        <section class="banner-home">
            <div class="content-box-banner-home">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Download Free/Paid Notes<br>or Sale your Book</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus ipsum voluptas saepe<br>necessitatibus vel ipsa officia aperiam delectus ullam error sint.</p>
                        <Button><a href="member/FAQ.php" style="text-decoration: none; color:#fff;">Learn More</a></Button>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <!-- Banner Ends -->

        <!-- About -->
        <section id="about" class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-12">
                        <h2>About<br>NotesMarketPlace</h2>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-12">
                        <p style="margin-bottom: 50px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum rerum eaque minima aliquam. Aliquid eius aliquam nemo expedita reprehenderit harum cupiditate amet, eum odit, dignissimos excepturi pariatur doloribus esse quaerat.Assumenda, saepe aliquam placeat similique dolore vel debitis natus tempore provident fugiat minima.</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, saepe aliquam placeat similique dolore vel debitis natus tempore provident fugiat minima temporibus cum quasi. Aut nobis illo officiis vel nesciunt.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section id="how-it-works">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <h2>How it Works</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="container">

                        <div class="row">

                            <div class="col-md-6 text-center">
                                <div class="image-box"></div>
                                <h3>Download Free/Paid Notes</h3>
                                <h5>Get Material for your<br>Course etc.</h5>
                                <a href="member/search_notes.php"><button>Download</button></a>
                            </div>

                            <div class="col-md-6 text-center">
                                <div class="image-box" style=" background: url('images/home/seller.png') no-repeat center;"></div>
                                <h3>Seller</h3>
                                <h5>Upload and Download Course<br>and Materials etc.</h5>
                                <a href="login.php"><button>Sell Book</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- How it works Ends-->

        <!-- Testimonial -->
        <section id="testimonials" class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2>What our Customers are Saying</h2>
                    </div>
                </div>
                <div class="row">

                        <!-- testimonial-1 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="testimonial">
                            <div class="row">
                                <div class="col-md-3 col-3">
                                    <img src="images/home/customer-1.png" alt="client">
                                </div>
                                <div class="col-md-8 col-7">
                                    <h3>Walter Meller</h3>
                                    <h5>Founder & CEO, Matrix Group</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut fuga non rerum quam aspernatur nobis, tempore earum nemo aut. Natus voluptatibus ex voluptate cumque vitae voluptatem atque? Accusantium, placeat minima."</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- tesimonial-2 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="testimonial">
                            <div class="row">
                                <div class="col-md-3 col-3">
                                    <img src="images/home/customer-2.png" alt="client">
                                </div>
                                <div class="col-md-8 col-7">
                                    <h3>Jonnie Riley</h3>
                                    <h5>Employee, Curious Snakcs</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut fuga non rerum quam aspernatur nobis, tempore earum nemo aut. Natus voluptatibus ex voluptate cumque vitae voluptatem atque? Accusantium, placeat minima."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- testimonial-3 -->
                <div class="col-lg-6 col-md-12">
                    <div class="testimonial">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <img src="images/home/customer-3.png" alt="client">
                            </div>
                            <div class="col-md-8 col-7">
                                <h3>Amilia Luna</h3>
                                <h5>Teacher, Saint Joseph High School</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut fuga non rerum quam aspernatur nobis, tempore earum nemo aut. Natus voluptatibus ex voluptate cumque vitae voluptatem atque? Accusantium, placeat minima."</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- tesimonial-4 -->
                <div class="col-lg-6 col-md-12">
                    <div class="testimonial">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <img src="images/home/customer-4.png" alt="client">
                            </div>
                            <div class="col-md-8 col-7">
                                <h3>Danial Cardos</h3>
                                <h5>Software Engineer, Infinitum Company</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut fuga non rerum quam aspernatur nobis, tempore earum nemo aut. Natus voluptatibus ex voluptate cumque vitae voluptatem atque? Accusantium, placeat minima."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-8">
                        <p>Copyright &copy; TatvaSOft All rigths reserved.</p>
                    </div>
                    <div class="col-md-6 col-4 text-right">
                        <ul class="social-list">
                            <li><a href=<?php echo GetfacebookURL();?>><img src="images/home/facebook.png" alt="facebook icon"></a></li>
                            <li><a href=<?php echo GettwitterURL();?>><img src="images/home/twitter.png" alt="twitter icon"></a></li>
                            <li><a href=<?php echo GetlinkedinURL();?>><img src="images/home/linkedin.png" alt="linkedin icon"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
         <!-- Footer Ends-->

        <!--JQuery-->
        <script src="js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="js/bootstrap/bootstrap.min.js"></script>

        <!--Custom JS-->
        <script src="js/script.js"></script>
    </body>
</html>
