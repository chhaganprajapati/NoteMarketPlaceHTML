<?php 
date_default_timezone_set('Asia/Kolkata');
?>

<?php 
$note_id  = $_POST['note_id'];
$title    = $_POST['title'];
$category = $_POST['category'];

$date = date('YmdHis');
$user_id = $_SESSION['user_id'];
$totalfiles = count($_FILES['upload_notes']['name']);
$type        = $_POST['type'];
$no_of_pages = $_POST['pages'];
$description = $_POST['description'];
$country     = $_POST['country'];
$institute_name = $_POST['institute_name'];
$course_name    = $_POST['course_name'];
$course_code    = $_POST['course_code'];
$professor   = $_POST['professor'];
$sell_type   = $_POST['sell_type'];
$sell_price  = $_POST['sell_price'];

if(isset($_POST['publish-btn'])){
    $note_status = 1;
}
$error = [
    'displaypicture'=>'',
    'notes'=>'',
    'pagesno'=>'',
    'notespreview'=>'',
    'sellprice'=>''
];



if(!isset($_FILES['display_picture']) || $_FILES['display_picture']['error'] == UPLOAD_ERR_NO_FILE){
    $display_picture      = NULL;
}
else{
    $display_picture      = $user_id.$date.$_FILES['display_picture']['name'];
    $display_picture_file = $_FILES['display_picture']['tmp_name'];
    $display_picture_type = explode(".",$display_picture)[1];

    if($display_picture_type != 'jpg' && $display_picture_type != 'jpeg'){
        $error['displaypicture'] = "File with only jpg/jpeg format are allowed.";
    }
}

if(!isset($_FILES['note_preview']) || $_FILES['note_preview']['error'] == UPLOAD_ERR_NO_FILE){
    $note_preview      = NULL;
}
else{
    $note_preview      = $user_id.$date.$_FILES['note_preview']['name'];
    $note_preview_file = $_FILES['note_preview']['tmp_name'];
    $note_preview_type = explode(".",$note_preview)[1];

    if($note_preview_type != 'pdf'){
        $error['notespreview'] = "File with only pdf format is allowed.";
    }
}



for($i=0;$i<$totalfiles;$i++){
    $filename = $_FILES['upload_notes']['name'][$i];
    $note_type = explode(".",$filename)[1];
    if($note_type != 'pdf'){
        $error['notes'] = "File with only pdf format is allowed.";
        break;
    }
}

if(!is_numeric($no_of_pages)){
    $error['pagesno'] = "Only numeric values are allowed!";
}



if(!is_numeric($sell_price) && $sell_price != 0){
    $error['sellprice'] = "Only numeric values are allowed!";
}


foreach ($error as $key => $value) {
        
    if(empty($value)){

        unset($error[$key]);

    }
}



?>


<?php
if(empty($error)){
    if(isset($_POST['submit-btn'])){

        if(!empty($note_id)){
            // Looping over all notes files
            for($i=0;$i<$totalfiles;$i++){
                $filename = $user_id.$date.$_FILES['upload_notes']['name'][$i];
                    
                // Upload files and store in database
                move_uploaded_file($_FILES["upload_notes"]["tmp_name"][$i],'../images/uploads/notes/'.$filename);
                $files[] = $filename;
            }
            $upload_notes = implode('/', $files);

            $query = "UPDATE notes SET NoteTitle='{$title}', CategoryID='{$category}', DisplayPictureFile='{$display_picture}', NoteFile='{$upload_notes}', TypeID='{$type}', NotePage='{$no_of_pages}', Description='{$description}', CountryID='{$country}', InstituteName='{$institute_name}', CourseName='{$course_name}', CourseCode='{$course_code}', ProfessorName='{$professor}', SellType={$sell_type}, NotePrice='{$sell_price}', PreviewFile='{$note_preview}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' ";
            $query .= "WHERE NoteID='{$note_id}';";
            $update_notes_query = mysqli_query($connection, $query);

            if(!$update_notes_query) {
                die("QUERY FAILED ." . mysqli_error($connection));   
            }
            // Save display picture
            move_uploaded_file($display_picture_file, "../images/uploads/display_pictures/$display_picture");
            // Save note preview
            move_uploaded_file($note_preview_file, "../images/uploads/note_preview/$note_preview");
            header("Location:dashboard.php");

        }else{

            // Looping over all notes files
            for($i=0;$i<$totalfiles;$i++){
                $filename = $user_id.$date.$_FILES['upload_notes']['name'][$i];
                    
                // Upload files and store in database
                move_uploaded_file($_FILES["upload_notes"]["tmp_name"][$i],'../images/uploads/notes/'.$filename);
                $files[] = $filename;
            }
            $upload_notes = implode('/', $files);


            $query = "INSERT INTO notes (NoteTitle, CategoryID, DisplayPictureFile, NoteFile, TypeID, NotePage, Description, CountryID, InstituteName, CourseName, CourseCode, ProfessorName, SellType, NotePrice, PreviewFile, SellerID, NoteStatusID, CreatedBy, CreatedDate)";
            $query .= "VALUES ('{$title}', '{$category}', '{$display_picture}', '{$upload_notes}', '{$type}', '{$no_of_pages}', '{$description}', '{$country}', '{$institute_name}', '{$course_name}', '{$course_code}', '{$professor}', {$sell_type}, '{$sell_price}', '{$note_preview }', '{$user_id}', 1,'{$user_id}','{$date}');";
            $add_note_query = mysqli_query($connection, $query);

            if(!$add_note_query) {
                die("QUERY FAILED ." . mysqli_error($connection));   
            }

            // Save display picture
            move_uploaded_file($display_picture_file, "../images/uploads/display_pictures/$display_picture");
            // Save note preview
            move_uploaded_file($note_preview_file, "../images/uploads/note_preview/$note_preview");
            header("Location:dashboard.php");
        }
    }



    if(isset($_POST['publish-btn'])){
        // Looping over all notes files
        for($i=0;$i<$totalfiles;$i++){
            $filename = $user_id.$date.$_FILES['upload_notes']['name'][$i];
                
            // Upload files and store in database
            move_uploaded_file($_FILES["upload_notes"]["tmp_name"][$i],'../images/uploads/notes/'.$filename);
            $files[] = $filename;
        }
        $upload_notes = implode('/', $files);

        $query = "UPDATE notes SET NoteTitle='{$title}', CategoryID='{$category}', DisplayPictureFile='{$display_picture}', NoteFile='{$upload_notes}', TypeID='{$type}', NotePage='{$no_of_pages}', Description='{$description}', CountryID='{$country}', InstituteName='{$institute_name}', CourseName='{$course_name}', CourseCode='{$course_code}', ProfessorName='{$professor}', SellType={$sell_type}, NotePrice='{$sell_price}', PreviewFile='{$note_preview}', NoteStatusID=2,ModifiedBy='{$user_id}', ModifiedDate='{$date}' ";
        $query .= "WHERE NoteID='{$note_id}';";
        $update_notes_query = mysqli_query($connection, $query);

        if(!$update_notes_query) {
            die("QUERY FAILED ." . mysqli_error($connection));   
        }
        // Save display picture
        move_uploaded_file($display_picture_file, "../images/uploads/display_pictures/$display_picture");
        // Save note preview
        move_uploaded_file($note_preview_file, "../images/uploads/note_preview/$note_preview");
        header("Location:dashboard.php");
    }
}
?>