<?php 
session_start();
include '../Database/database.php';
include '../functions.php';

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
                            <input type="text" class="form-control" id="search_filter" placeholder="Search notes here...">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control filter-data" id="note_type">
                                <option selected disabled hidden>Select type</option>
                                <?php GetNoteType(0);?>
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control filter-data" id="category">
                                <option selected disabled hidden>Select category</option>
                                <?php GetCategory(0);?>
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>

                        <?php
                        
                        $query = "SELECT DISTINCT InstituteName FROM notes WHERE InstituteName != '' or InstituteName != null";
                        $filter_institute_query = mysqli_query($connection, $query);
                        confirmQuery($filter_institute_query);
                        
                        ?>



                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control filter-data" id="university_name">
                                <option selected disabled hidden>Select university</option>

                                <?php 
                                foreach($filter_institute_query as $row){
                                    echo "<option>{$row['InstituteName']}</option>";
                                }
                                
                                ?>

                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>

                        <?php
                        
                        $query = "SELECT DISTINCT CourseName FROM notes WHERE CourseName != '' or CourseName != null";
                        $filter_course_query = mysqli_query($connection, $query);
                        confirmQuery($filter_course_query);
                        
                        ?>



                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control filter-data" id="course_name">
                                <option selected disabled hidden>Select course</option>
                                <?php 
                                foreach($filter_course_query as $row){
                                    echo "<option>{$row['CourseName']}</option>";
                                }
                                
                                ?>

                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control filter-data" id="country">
                                <option selected disabled hidden>Select country</option>
                                <?php GetCountry(0);?>
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <select class="form-control filter-data" id="rating">
                                <option selected disabled hidden>Select rating</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5</option> 
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
            <div class="container-fluid filter-notes">

                
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
                $(document).ready(function(){

                    filter_data();

                    $(".filter-data").on("change",function(){
                        filter_data();
                    });

                    $("#search_filter").on("keyup",function(){
                        filter_data();
                    });

                    function filter_data()
                    {
                        var action = 'fetch_data';
                        var search = $("#search_filter").val();
                        var note_type = $('#note_type').val();
                        var category = $('#category').val();
                        var university_name = $('#university_name').val();
                        var course_name = $('#course_name').val();
                        var country = $('#country').val();
                        var rating = $('#rating').val();

                        // alert(note_type + category + university_name + course_name + country + rating);
                        $.ajax({
                            url:"fetch_data.php",
                            method:"POST",
                            data:{action:action, search:search, note_type:note_type, category:category, university_name:university_name, course_name:course_name, country:country, rating:rating},
                            success:function(data){
                                $('.filter-notes').html(data);
                                $books = $("#total_notes").val();
                                for (let index = 1; index <= Math.ceil($books/9); index++) {
                                    $("div#page-no").append("<a href='#' class='page' value='"+index+"'>"+index+"</a>"); 
                                }

                                $(".pagination a.page[value=1]").addClass("active");
                                for (let index = 10; index <= $books; index++){
                                    $("#notes-list-"+index).hide();
                                }
                                
                                // Previous Button
                                $("#prev").click(function(){
                                    $a=$(".pagination a.active").attr("value");
                                    if($a>1){
                                    $page_no=$a-1;
                                    }
                                    else{
                                    $page_no=$a;
                                    }
                                    pagination();
                                });

                                // Next Button
                                $("#next").click(function(){
                                    
                                    $a=$(".pagination a.active").attr("value");
                                    if($a<($books/9)){
                                    $page_no=parseInt($a) + 1;
                                    }
                                    else{
                                    $page_no=$a;
                                    }
                                    pagination();
                                });

                                // On page number click
                                $(".pagination a.page").click(function(){
                                    $page_no=$(this).attr("value");
                                    pagination();
                                });

                                // Pagination function
                                function pagination() {
                                    $(".pagination a").removeClass("active");
                                    $(".pagination a.page[value="+$page_no+"]").addClass("active");

                                    $start_page_no=($page_no-1)*9+1;
                                    $end_page_no=$page_no*9;

                                    for (let index = 1; index <= $books; index++){

                                    if(index>=$start_page_no && index<=$end_page_no)
                                    {
                                        $("#notes-list-"+index).show();
                                    }
                                    else {
                                        $("#notes-list-"+index).hide();
                                    }
                                    }
                                }
                            }
                        });
                        
                    }
                    
                    

                });

                
                

                
        </script>


        <!--Custom JS-->
        <script src="../js/script.js"></script>

    </body>
</html>