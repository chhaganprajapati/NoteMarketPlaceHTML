<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:../index.php");
}
include "../Database/database.php";
include "../functions.php";
$user_id = $_SESSION['user_id'];
$profile_image_nav = ProfileImage($user_id);

if(isset($_GET['note_id'])){
    $note_id =  $_GET['note_id'];
    if(isset($_GET['view'])){
        $view = $_GET['view'];
    }

    if(isset($_GET['clone'])){
        $clone = $_GET['clone'];
    }

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

    if(isset($_GET['clone'])){
        unset($note_id);
        $clone = $_GET['clone'];
    }

    if($sell_type == 0)
    {
        $sell = "disabled";
    }
}


if(isset($_POST['submit-btn']) || isset($_POST['publish-btn'])){
    include "notes_process.php";
}

    if(!empty($display_picture)){
        $display_picture = explode('_',$display_picture)[2];
    }
    if(!empty($note_preview)){
        $note_preview = explode('_',$note_preview)[2];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php
    $title = 'Add Notes';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php include 'includes/navbar.php';?>
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

                    
                    <input type="hidden" name="note_id" value=<?php echo isset($note_id) ? $note_id : '';?>>
                    <input type="hidden" name="note_status" value=<?php echo isset($note_status) ? $note_status : ''; ?>>
                    <input type="hidden" name="clone" value=<?php echo isset($clone) ? $clone : '';?>>
                
                    
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title *</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter your notes title" value="<?php echo isset($title) ? $title : '' ?>" <?php echo !empty($note_id) ? 'readonly' : '' ?> required>
                                <div class="error-message"><?php echo isset($error['title'])? $error['title']:'' ?></div>
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
                                <?php if(isset($view)){?>
                                    <div id="display_picture_name" style="color : green;"><?php echo $display_picture;?></div>
                                <?php }
                                else{?>
                                    <div class="form-group text-center">
                                        <div class="upload" id="display-picture-icon">
                                            <img src="../images/User-Profile/upload.png">
                                            <figcaption id="imagetext">Upload a picture</figcaption>
                                        </div>
                                        <input type="file" id="display-picture" name="display_picture" style="display:none" accept="image/*">
                                    </div>
                                    <div id="display_picture_name" style="color : green;">
                                        <?php echo (!empty($display_picture) && !empty($note_id)) ?$display_picture :''?>
                                    </div>
                                    <div class="error-message"><?php echo isset($error['displaypicture'])? $error['displaypicture']:'' ?></div>
                                <?php }?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload Notes *</label>
                                <?php if(isset($view)){?>
                                    <div id="notes_name" style="color : green;"><?php 
                                    
                                    $upload_notes = explode('/',$upload_notes);
                                    $i=0;
                                    echo "<ul>";
                                    while(isset($upload_notes[$i])){
                                        $upload_notes[$i] = explode('_',$upload_notes[$i])[2];
                                        echo "<li>$upload_notes[$i]</li>";
                                        $i++;
                                    }
                                    echo "</ul>";
                                    
                                    ?></div>
                                <?php
                                }
                                else{?>
                                    <div class="form-group text-center">
                                        <div class="upload" id="upload-notes-icon">
                                            <img src="../images/Add-notes/upload-note.svg">
                                            <figcaption id="imagetext">Upload your notes</figcaption>
                                        </div>
                                        <input type="file" id="upload-notes" name="upload_notes[]" style="display:none" multiple <?php echo (empty($upload_notes))? 'required':''?> >
                                    </div>
                                    <div id="notes_name" style="color : green;"><?php
                                    if(!empty($upload_notes) && !empty($note_id)){
                                        $upload_notes = explode('/',$upload_notes);
                                        $i=0;
                                        echo "<ul>";
                                        while(isset($upload_notes[$i])){
                                            $upload_notes[$i] = explode('_',$upload_notes[$i])[2];
                                            echo "<li>$upload_notes[$i]</li>";
                                            $i++;
                                        }
                                        echo "</ul>"; 
                                    }
                                    ?></div>
                                    <div id="error-notes" class="error-message"><?php echo isset($error['notes'])? $error['notes']:'' ?></div>
                                <?php }?>
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
                                <div class="error-message"><?php echo isset($error['pagesno'])? $error['pagesno']:'' ?></div>
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
                                        <input type="text" id="sell_price" name="sell_price" class="form-control" placeholder="Enter your price" value="<?php echo isset($sell_price) ? $sell_price : '' ?>" <?php echo isset($sell_type)?(($sell_type==0)?'readonly':''):'' ?> required>
                                        <div class="error-message"><?php echo isset($error['sellprice'])? $error['sellprice']:'' ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Note Preview</label>
                                <?php if(isset($view)){?>
                                    <div id="note_preview_name" style="color : green;"><?php echo $note_preview;?></div>
                                <?php }
                                else{?>
                                    <div class="form-group text-center">
                                        <div class="upload" id="upload-file-icon" style="padding: 44px;">
                                            <img src="../images/User-Profile/upload.png">
                                            <figcaption id="imagetext">Upload a file</figcaption>
                                        </div>
                                        <input type="file" id="upload-file" name="note_preview" style="display:none" <?php echo (isset($sell_type))?(($sell_type==1 && (empty($note_id) || empty($note_preview)))?'required':''):'' ?>>
                                    </div>
                                    <div id="note_preview_name" style="color : green;"><?php echo (!empty($note_preview) && !empty($note_id)) ?$note_preview :''?></div>
                                    <div class="error-message"><?php echo isset($error['notespreview'])? $error['notespreview']:'' ?></div>
                                <?php }?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php 
                if(!isset($_GET['view'])){
                    if(empty($note_status) || !empty($clone)){?>
                        <button id="submit-btn" name="submit-btn">SAVE</button>
                    <?php 
                    }
                    if(isset($note_status) && $note_status == 1){?>
                        <button id="submit-btn" name="submit-btn">SAVE</button>
                        <button id="publish-btn" name="publish-btn">Publish</button>
                    <?php } 
                }?>
            </div> 
        </form>

        <!-- footer include -->
        <?php include 'includes/footer.php'; ?>

        <script type="text/javascript">

                <?php
            if(isset($_GET['view'])){ ?>

            $("input").attr("readonly","readonly");
            $("textarea").attr("readonly","readonly");
            $("select").attr("disabled","disabled");

            <?php   
            }?>
            
            // Notes preview required validation
            $("#submit-btn").on('click',function(){
                $('body').css('cursor','wait');
                var input = document.getElementById('upload-notes');
                var notes_file = $("#notes_name ul li").text();
                var file = $("#note_preview_name").text();
                if(input.files.length == 0  && notes_file == '') 
                {
                    $("#error-notes").text("Please select the pdf file/files to upload.");
                    $("#upload-notes").trigger('click');
                }

                var radio = $('input[name="sell_type"]:checked').val();
                if(radio == 1 && file == ''){
                    
                    var preview = document.getElementById('upload-file');
                    if(preview.files.length == 0)
                    {   
                        $("#upload-file").parent().siblings("div.error-message").text("Please select the file with pdf format to upload.");
                    }
                }
                $('body').css('cursor','default');
            });


            $("#publish-btn").on('click',function(){
                $('body').css('cursor','wait');
                var input = document.getElementById('upload-notes');
                var notes_file = $("#notes_name ul li").text();
                var radio = $('input[name="sell_type"]:checked').val();
                var file = $("#note_preview_name").text();
                
                if(input.files.length == 0 && notes_file == '')
                {
                    $("#error-notes").text("Please select the pdf file/files to upload.");
                    $("#upload-notes").trigger('click');
                }
                else if(radio == 1 && file == ''){
                    var preview = document.getElementById('upload-file');
                    if(preview.files.length == 0 )
                    {   
                        $("#upload-file").parent().siblings("div.error-message").text("Please select the file wiht pdf format to upload.");
                    }
                    else{
                        confirm("Publishing this note will send note to administrator for review, once administrator review and approve then this note will be published to portal. Press yes to continue.");
                    }
                }
                else {
                    confirm("Publishing this note will send note to administrator for review, once administrator review and approve then this note will be published to portal. Press yes to continue.");
                }
                $('body').css('cursor','default');
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
                // alert(radio);
                var file = $("#note_preview_name").text();
                if(radio == 0){
                    $('#sell_price').val(0);
                    $('#sell_price').attr('disabled','disabled');       
                }
                else{
                    $('#sell_price').val('');
                    $('#sell_price').removeAttr('disabled','disabled');                
                }

                if(radio == 1 && file == ''){
                    $('#upload-file').attr('required','required');
                }   
                else{
                    $('#upload-file').removeAttr('required','required');
                }
            });



            $("#pages_no").on('keyup',function(){
                var pages = $(this).val();
                // alert(pages);
                if(!pages.match(/^[0-9]+$/)){
                    $(this).addClass('error-input');
                    $(this).siblings("div.error-message").text("Only numeric values are allowed!");
                }
                else{
                    $(this).removeClass('error-input');
                    $(this).siblings("div.error-message").text('');
                }

                if(pages == ''){
                    $(this).removeClass('error-input');
                    $(this).siblings("div.error-message").text('');
                }
            });

            $("#sell_price").on('keyup',function(){
                var pages = $(this).val();
                // alert(pages);
                if(!pages.match(/^[0-9]+$/)){
                    $(this).addClass('error-input');
                    $(this).siblings("div.error-message").text("Only numeric values are allowed!");
                }
                else{
                    $(this).removeClass('error-input');
                    $(this).siblings("div.error-message").text('');
                }

                if(pages == ''){
                    $(this).removeClass('error-input');
                    $(this).siblings("div.error-message").text('');
                }
            });
            
            
        </script>

    </body>
</html>