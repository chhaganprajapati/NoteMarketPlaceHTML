<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:../index.html");
}
include "../Database/database.php";
include "../functions.php";

if(isset($_GET['note_id'])){
    $note_id =  $_GET['note_id'];

    $query = "SELECT * FROM notes WHERE NoteID = '$note_id'";
    $notes_query = mysqli_query($connection, $query);
    confirmQuery($notes_query);

    while($row = mysqli_fetch_array($notes_query)){
        $title    = $row['NoteTitle'];
        $category = $row['CategoryID'];
        $display_picture = $row['DisplayPictureFile'];
        $upload_notes = $row['NoteFile'];
        $type     = $row['TypeID'];
        $no_of_pages = $row['NotePage'];
        $description = $row['Description'];
        $country        = $row['CountryID'];
        $institute_name = $row['InstituteName'];
        $course_name    = $row['CourseName'];
        $course_code    = $row['CourseCode'];
        $professor   = $row['ProfessorName'];
        $sell_type   = $row['SellType'];
        $sell_price  = $row['NotePrice'];
        $note_preview = $row['PreviewFile'];
        $note_status = $row['NoteStatusID'];
    }

    if($sell_type == 0)
    {
        $sell = "disabled";
    }
}


if(isset($_POST['submit-btn']) || isset($_POST['publish-btn'])){
    include "notes_process.php";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Add Notes</title>

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
                            <li><a href="#" class="link">Search Notes</a></li>
                            <li><a href="#" class="link">Sell Your Notes</a></li>
                            <li><a href="#" class="link">Buyer Requests</a></li>
                            <li><a href="#" class="link">FAQ</a></li>
                            <li><a href="#" class="link">Contact Us</a></li>
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
                                        <a href="#" style="color:#6255a5;">LOGOUT</a>
                                    </div>
                            </li>
                            <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Nav menu bar Ends-->

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ml-auto">
                      <li><a href="search_notes.php">Search Notes</a></li>
                      <li><a href="dashboard.php">Sell Your Notes</a></li>
                      <li><a href="buyer_request.php">Buyer Requests</a></li>
                      <li><a href="FAQ.php">FAQ</a></li>
                      <li><a href="contact_us.php">Contact Us</a></li>
                      <li class="dropdown">
                        <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/Add-notes/user-img.png" class="img-fluid" alt="progile image"></a>
                    
                        <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                            <a class="dropdown-item" href="#">My Profile</a>
                            <a class="dropdown-item" href="#">My Downloads</a>
                            <a class="dropdown-item" href="#">My Sold Notes</a>
                            <a class="dropdown-item" href="#">My Rejected Notes</a>
                            <a class="dropdown-item" href="#">Change Password</a>
                            <a class="dropdown-item" href="#" style="color:#6255a5;">LOGOUT</a>
                        </div>
                        </li>
                        <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                    </ul>
                </div>   
            </div>
        </nav>
        <!--Navbar Ends-->

        <!-- Banner  -->
        <section class="banner stats-text">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Add Notes</h1>
                    </div>
                </div>
            </div>
        </section>

        <form action="add_notes.php" method="post" class="box"  enctype="multipart/form-data">

            <!-- Basic Note Details -->
            <div class="form-details" style="margin-top: 60px;">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Basic Note Details</h2>
                        </div>
                    </div>

                    <input type="hidden" name="note_id" value="<?php echo isset($note_id) ? $note_id : '' ?>">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title *</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter your notes title" value="<?php echo isset($title) ? $title : '' ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category *</label>
                                <select class="form-control" name="category" required>
                                    <option value="" selected disabled hidden>Select your Category</option>
                                    <?php GetCategory($category); ?>
                                </select>
                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                            </div>
                        </div>     
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Display Picture</label>
                                <div id="display_picture_name" style="color : green;"></div>
                                <div class="form-group text-center">
                                    <div class="upload" id="display-picture-icon">
                                        <img src="../images/User-Profile/upload.png">
                                        <figcaption id="imagetext">Upload a picture</figcaption>
                                    </div>
                                    <input type="file" id="display-picture" name="display_picture" style="display:none" accept="image/*">
                                </div>
                                <p class="error-message"><?php echo isset($error['displaypicture'])? $error['displaypicture']:'' ?></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload Notes *</label>
                                <div id="notes_name" style="color : green;"></div>
                                <div class="form-group text-center">
                                    <div class="upload" id="upload-notes-icon">
                                        <img src="../images/Add-notes/upload-note.svg">
                                        <figcaption id="imagetext">Upload your notes</figcaption>
                                    </div>
                                    <input type="file" id="upload-notes" name="upload_notes[]" style="display:none" multiple required>
                                </div>
                                <p id="error-notes" class="error-message"><?php echo isset($error['notes'])? $error['notes']:'' ?></p>
                            </div>
                        </div>    
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" name="type" required>
                                    <option value="" selected disabled hidden>Select your note type</option>
                                    <?php GetNoteType($type); ?>
                                </select>
                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Number of Pages</label>
                                <input type="text" id="pages_no" name="pages" class="form-control" placeholder="Enter number of note pages" value="<?php echo isset($no_of_pages) ? $no_of_pages : '' ?>">
                                <p class="error-message"><?php echo isset($error['pagesno'])? $error['pagesno']:'' ?></p>
                            </div>
                        </div>   

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Description *</label>
                            <textarea class="form-control" name="description" placeholder="Enter your description" style="height: 151px;" required><?php echo isset($description) ? $description : '' ?></textarea>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Institution Information -->
            <div class="form-details">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Institution Information</h2>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select class="form-control" name="country" required>
                                    <option value="" selected disabled hidden>Select your Country</option>
                                    <?php GetCountry($country); ?>
                                </select>
                                <img src="../images/User-Profile/down-arrow.png" class="arrow-select">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Institution Name</label>
                                <input type="text" class="form-control" name="institute_name" placeholder="Enter your institution name" value="<?php echo isset($institute_name) ? $institute_name : '' ?>">
                            </div>
                        </div>     
                    </div>

                </div>
            </div>

            <!-- Course Details -->
            <div class="form-details">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Course Details</h2>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name</label>
                                <input type="text" name="course_name" class="form-control" placeholder="Enter your course name" value="<?php echo isset($course_name) ? $course_name : '' ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Code</label>
                                <input type="text" name="course_code" class="form-control" placeholder="Enter your course code" value="<?php echo isset($course_code) ? $course_code : '' ?>">
                            </div>
                        </div>     
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Professor / Lecturer</label>
                                <input type="text" name="professor" class="form-control" placeholder="Enter your professor name" value="<?php echo isset($professor) ? $professor : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

            <!-- Selling Information -->
            <div class="form-details">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Selling Information</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">

                                <!-- Custom Radio button -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sell For *</label>
                                        <div>
                                            <label class="sell-radio-btn">Free
                                                <input type="radio" value="0" name="sell_type" <?php echo isset($sell_type)?(($sell_type==0)?'checked':''):'' ?> required>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="sell-radio-btn">Paid
                                                <input type="radio" value="1" name="sell_type" <?php echo isset($sell_type)?(($sell_type==1)?'checked':''):'' ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sell Price *</label>
                                        <input type="text" id="sell_price" name="sell_price" class="form-control" placeholder="Enter your price" value="<?php echo isset($sell_price) ? $sell_price : '' ?>" <?php echo isset($sell_type)?(($sell_type==0)?'disabled':''):'' ?> required>
                                        <p class="error-message"><?php echo isset($error['sellprice'])? $error['sellprice']:'' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Note Preview</label>
                                <div id="note_preview_name" style="color : green;"></div>
                                <div class="form-group text-center">
                                    <div class="upload" id="upload-file-icon" style="padding: 44px;">
                                        <img src="../images/User-Profile/upload.png">
                                        <figcaption id="imagetext">Upload a file</figcaption>
                                    </div>
                                    <input type="file" id="upload-file" name="note_preview" style="display:none" <?php echo isset($sell_type)?(($sell_type==1)?'required':''):'' ?>>
                                </div>
                                <p class="error-message"><?php echo isset($error['notespreview'])? $error['notespreview']:'' ?></p>
                            </div>
                        </div>
                    </div>

                </div>
                <?php if(empty($note_status)){?>
                    <button id="submit-btn" name="submit-btn">SAVE</button>
                <?php 
                }
                if(isset($note_status) && $note_status == 1){?>
                    <button id="submit-btn" name="submit-btn">SAVE</button>
                    <button id="publish-btn" name="publish-btn">Publish</button>
                <?php } ?>
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

        <script type="text/javascript">

            
            $("#submit-btn").on('click',function(){

                var input = document.getElementById('upload-notes');
                if(input.files.length == 0)
                {
                    $("#error-notes").text("Please select the pdf file/files to upload.");
                    $("#upload-notes").trigger('click');
                }

                var radio = $('input[name="sell_type"]:checked').val();
                if(radio == 1){
                    
                    var preview = document.getElementById('upload-file');
                    if(preview.files.length == 0)
                    {   
                        $("#upload-file").parent().siblings("p.error-message").text("Please select the file wiht pdf format to upload.");
                    }
                }
            });


            $("#publish-btn").on('click',function(){

                var input = document.getElementById('upload-notes');
                var radio = $('input[name="sell_type"]:checked').val();
                if(input.files.length == 0)
                {
                    $("#error-notes").text("Please select the pdf file/files to upload.");
                    $("#upload-notes").trigger('click');
                }
                else if(radio == 1){
                    var preview = document.getElementById('upload-file');
                    if(preview.files.length == 0)
                    {   
                        $("#upload-file").parent().siblings("p.error-message").text("Please select the file wiht pdf format to upload.");
                    }
                }
                else{
                    confirm("Publishing this note will send note to administrator for review, once administrator review and approve then this note will be published to portal. Press yes to continue.");
                }
            });


                  
            $('#display-picture').on( 'change', function() {
                var file = $('#display-picture')[0].files[0].name;
                $('#display_picture_name').html(file);
            });



            $('#upload-file').on( 'change', function() {
                var file = $('#upload-file')[0].files[0].name;
                $('#note_preview_name').html(file);
            });



            $('#upload-notes').on( 'change', function() {
                var input = document.getElementById('upload-notes');
                var output = document.getElementById('notes_name');
                var children = "";
                for (var i = 0; i < input.files.length; ++i) {
                    children += '<li>' + input.files.item(i).name + '</li>';
                }
                output.innerHTML = '<ul>'+children+'</ul>';
                $("#error-notes").text("");
            });



            $('input[name="sell_type"]').on('click',function(){
                var radio = $('input[name="sell_type"]:checked').val();
                if(radio == 0){
                    $('#sell_price').val(0);
                    $('#sell_price').attr('disabled','disabled');
                    $('#upload-file').removeAttr('required','required');
                }
                else{
                    $('#sell_price').val('');
                    $('#sell_price').removeAttr('disabled','disabled');
                    $('#upload-file').attr('required','required');
                }
            });



            $("#pages_no").on('keyup',function(){
                var pages = $(this).val();
                // alert(pages);
                if(!pages.match(/^[0-9]+$/)){
                    $(this).addClass('error-input');
                    $(this).siblings("p.error-message").text("Only numeric values are allowed!");
                }
                else{
                    $(this).removeClass('error-input');
                    $(this).siblings("p.error-message").text('');
                }

                if(pages == ''){
                    $(this).removeClass('error-input');
                    $(this).siblings("p.error-message").text('');
                }
            });

            $("#sell_price").on('keyup',function(){
                var pages = $(this).val();
                // alert(pages);
                if(!pages.match(/^[0-9]+$/)){
                    $(this).addClass('error-input');
                    $(this).siblings("p.error-message").text("Only numeric values are allowed!");
                }
                else{
                    $(this).removeClass('error-input');
                    $(this).siblings("p.error-message").text('');
                }

                if(pages == ''){
                    $(this).removeClass('error-input');
                    $(this).siblings("p.error-message").text('');
                }
            });
            
            
        </script>

    </body>
</html>