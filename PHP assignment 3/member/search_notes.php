<?php 
session_start();
include '../Database/database.php';
include '../functions.php';

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    // Profile Image In Navigation
    $profile_image_nav = ProfileImage($user_id);
}

$query = "SELECT notes.NoteID, notes.NoteTitle, categorytable.Category, notes.DisplayPictureFile, notes.NotePage, countrytable.CountryName, notes.InstituteName, notes.PublishedDate FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN countrytable ON notes.CountryID = countrytable.CountryID WHERE NoteStatusID=4 ORDER BY PublishedDate Desc";
$notes_query = mysqli_query($connection, $query);

if(!$notes_query){
    die("Query Failed". mysqli_error($connection));
}

$total_notes = mysqli_num_rows($notes_query);
?>

<!DOCTYPE html>
<html lang="en">
    <?php $title = 'Search Notes';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php $search_notes = 'active';
        include 'includes/navbar.php';?>
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
                                <?php
                                    $query = "SELECT * FROM typetable";
                                    $type_query = mysqli_query($connection, $query);
                                    confirmQuery($type_query);
                                                          
                                    while($row = mysqli_fetch_array($type_query)) {
                                        echo "<option value={$row['TypeID']}>{$row['TypeName']}</option>";
                                    }
                                ?>
                            </select>
                            <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">

                            <select class="form-control filter-data" id="category">
                                <option selected disabled hidden>Select category</option>
                                <?php 
                                    $query = "SELECT * FROM categorytable";
                                    $category_query = mysqli_query($connection, $query);
                                    confirmQuery($category_query);
                 
                                    while($row = mysqli_fetch_array($category_query)) {
                                        echo "<option value={$row['CategoryID']}>{$row['Category']}</option>";                        
                                    }
                                ?>
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
                                <?php
                                    $query = "SELECT * FROM countrytable";
                                    $country_query = mysqli_query($connection, $query);
                                    confirmQuery($country_query);
                                                               
                                    while($row = mysqli_fetch_array($country_query)) {
                                        echo "<option value={$row['CountryID']}>{$row['CountryName']}</option>";
                                    }
                                ?>
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


        <!-- footer include -->
        <?php include 'includes/footer.php'; ?>
        
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

    </body>
</html>