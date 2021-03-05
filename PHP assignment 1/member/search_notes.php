<?php 
session_start();
include '../Database/database.php';

$query = "SELECT notes.NoteID, notes.NoteTitle, categorytable.Category, notes.DisplayPictureFile, notes.NotePage, countrytable.CountryName, notes.InstituteName, notes.PublishedDate FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN countrytable ON notes.CountryID = countrytable.CountryID WHERE NoteStatusID=4 ORDER BY PublishedDate Desc";
$notes_query = mysqli_query($connection, $query);

if(!$notes_query){
    die("Query Failed". mysqli_error($connection));
}

$total_notes = mysqli_num_rows($notes_query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Search Notes</title>

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
                                <li><a href="#" class="link active">Search Notes</a></li>
                                <li><a href="dashboard.php" class="link">Sell Your Notes</a></li>
                                <li><a href="buyer_requests.php" class="link">Buyer Requests</a></li>
                                <li><a href="FAQ.php" class="link">FAQ</a></li>
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
                                <li><a href="#" class="link active">Search Notes</a></li>
                                <li><a href="../login.php" class="link">Sell Your Notes</a></li>
                                <li><a href="FAQ.php" class="link">FAQ</a></li>
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
                            <li><a href="#" class="active">Search Notes</a></li>
                            <li><a href="dashboard.php">Sell Your Notes</a></li>
                            <li><a href="buyer_requests.php">Buyer Requests</a></li>
                            <li><a href="FAQ.php">FAQ</a></li>
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
                            <li><a href="#" class="active">Search Notes</a></li>
                            <li><a href="../login.php">Sell Your Notes</a></li>
                            <li><a href="FAQ.php">FAQ</a></li>
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
                        <h1 class="text-center">Search Notes</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner Ends -->

        <!-- Search Filter -->
        <section id="search-filter" class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Search and Filter notes</h2>
                    </div>
                </div>
                <div id="filters">

                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Search notes here...">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control">
                                <option selected disabled hidden>Select type</option>
                                <option>Handwritten Notes</option>
                                <option>University Notes</option>
                                <option>Notebook</option>
                                <option>Novel</option> 
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control">
                                <option selected disabled hidden>Select category</option>
                                <option>IT</option>
                                <option>CA</option>
                                <option>CS</option>
                                <option>MBA</option> 
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control">
                                <option selected disabled hidden>Select university</option>
                                <option>Gujarat Technological University</option>
                                <option>Gujarat University</option>
                                <option>Nirma University</option> 
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control">
                                <option selected disabled hidden>Select course</option>
                                <option>Computer Science</option>
                                <option>Civil Engineering</option> 
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control">
                                <option selected disabled hidden>Select country</option>
                                <option>India</option>
                                <option>Canada</option>
                                <option>USA</option> 
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control">
                                <option selected disabled hidden>Select rating</option>
                                <option>1+</option>
                                <option>2+</option>
                                <option>3+</option>
                                <option>4+</option>
                                <option>5</option> 
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Search Filter Ends-->

        <!-- Notes list -->
        <section id="notes-list" class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Total <?php echo $total_notes;?> notes</h2>
                    </div>
                </div>

                <div class="row">

                <?php 
                $count = 0;
                while($row = mysqli_fetch_array($notes_query)){
                    
                    $note_id = $row['NoteID'];
                    $title = $row['NoteTitle'];
                    $category = $row['Category']; 
                    $display_picture = $row['DisplayPictureFile'];
                    $institute_name = $row['InstituteName'];
                    $country = $row['CountryName'];
                    $note_pages = $row['NotePage'];
                    $published_date = $row['PublishedDate'];
                    $published_day = date("D",strtotime($published_date));
                    $published_date = date("M d Y",strtotime($published_date));
                    $count++;
                
                ?>

                     <!-- Note-1 -->
                    <div class="col-lg-4 col-sm-6" id="notes-list-<?php echo $count;?>">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/1.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <a href="notes_details.php?note=<?php echo $note_id;?>" style="text-decoration: none;">
                                            <h3><?php echo $title;?> - <?php echo $category;?></h3>
                                        </a>
                                        <p><img src="../images/front/university.png"><?php echo $institute_name;?>, <?php echo $country;?></p>
                                        <p><img src="../images/front/pages.png"><?php echo $note_pages;?> Pages</p>
                                        <p><img src="../images/front/date.png"><?php echo $published_day;?>, <?php echo $published_date;?> </p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php 
                
                }?>

                    <!-- Note-2 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-2">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/2.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Computer Science</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-3 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-3">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/3.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Basic Computer Engineering Tech India Publication Series</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-4 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-4">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/4.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Computer Science Illuminated - Seventh Edition</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-5 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-5">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/5.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>The Principles of Computer Hardware - Oxford</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-6 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-6">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/6.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>The Computer Book</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                     <!-- Note-7 -->
                     <!-- <div class="col-lg-4 col-sm-6" id="notes-list-7">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/1.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Computer Operating System - Final Exam Book With Paper Solution</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-8 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-8">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/2.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Computer Science</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-9 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-9">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/3.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Basic Computer Engineering Tech India Publication Series</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-10 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-10">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/4.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Computer Science Illuminated - Seventh Edition</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-11 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-11">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/5.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>The Principles of Computer Hardware - Oxford</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-12 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-12">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/6.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>The Computer Book</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                     <!-- Note-13 -->
                     <!-- <div class="col-lg-4 col-sm-6" id="notes-list-13">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/1.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Computer Operating System - Final Exam Book With Paper Solution</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-14 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-14">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/2.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Computer Science</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-15 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-15">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/3.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Basic Computer Engineering Tech India Publication Series</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-16 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-16">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/4.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>Computer Science Illuminated - Seventh Edition</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-17 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-17">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/5.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>The Principles of Computer Hardware - Oxford</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-18 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-18">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/6.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>The Computer Book</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Note-19 -->
                    <!-- <div class="col-lg-4 col-sm-6" id="notes-list-19">
                        <div class="notes-list-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../images/Search/6.jpg" class="img-fluid" alt="notes banner">
                                    <div class="notes-list-detail">
                                        <h3>The Computer Book</h3>
                                        <p><img src="../images/front/university.png">University of California, US</p>
                                        <p><img src="../images/front/pages.png">204 Pages</p>
                                        <p><img src="../images/front/date.png">Thu, Nov 26 2020</p>
                                        <p style="color: #df3434;"><img src="../images/front/flag.png">5 Users marked this note as inappropriate</p>
                                        <div class="rating-star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <img src="../images/front/star-white.png" alt="star">
                                            <span>100 reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="pagination">
                            <a href="#" style="margin-right: 15px;" id="prev">
                                <img src="../images/front/left-arrow.png">
                            </a>
                            <div id="page-no"></div>
                            <a href="#" style="margin-left: 13px; padding-left: 14px;" id="next">
                                <img src="../images/front/right-arrow.png">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Pagination Ends -->
                
            </div>
        </section>
        <!-- Notes list Ends-->

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
        
        <script type="text/javascript">
            $books=<?php echo $total_notes;?>;
        </script>
        <!--Custom JS-->
        <script src="../js/script.js"></script>
>
    </body>
</html>