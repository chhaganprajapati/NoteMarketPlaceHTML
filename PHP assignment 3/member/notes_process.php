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
$note_status = $_POST['note_status'];




$error = [
    'title'=>'',
    'displaypicture'=>'',
    'notes'=>'',
    'pagesno'=>'',
    'notespreview'=>'',
    'sellprice'=>''
];

if(empty($note_id)){

    $query = "SELECT NoteTitle FROM notes WHERE NoteTitle = '$title'";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("QUERY FAILED".mysqli_error($connection));
    }

    if(mysqli_num_rows($result) > 0) {
        $error['title'] = "Title already exists use unique title.";
    }
}



if(!isset($_FILES['display_picture']) || $_FILES['display_picture']['error'] == UPLOAD_ERR_NO_FILE){
    if(!empty($note_id)){
        $query = "SELECT DisplayPictureFile FROM notes WHERE NoteID = $note_id";
        $display_query = mysqli_query($connection,$query);
        confirmQuery($display_query);

        $row = mysqli_fetch_array($display_query);
        $display_picture = $row['DisplayPictureFile'];
    }
    else{
        $display_picture      = NULL;
    }
}
else{
    $display_picture = str_replace('_', '', $_FILES['display_picture']['name']);
    $display_picture      = $user_id.'_'.$date.'_'.$display_picture;
    $display_picture_file = $_FILES['display_picture']['tmp_name'];
    $display_picture_type = explode(".",$display_picture);

    if(end($display_picture_type) != 'jpg' && end($display_picture_type) != 'jpeg'){
        $error['displaypicture'] = "File with only jpg/jpeg format is allowed.";
    }
}

if(!isset($_FILES['note_preview']) || $_FILES['note_preview']['error'] == UPLOAD_ERR_NO_FILE){
    if(!empty($note_id)){
        $query = "SELECT PreviewFile FROM notes WHERE NoteID = $note_id";
        $preview_query = mysqli_query($connection,$query);
        confirmQuery($preview_query);

        $row = mysqli_fetch_array($preview_query);
        $note_preview = $row['PreviewFile'];
    }
    else{
        $note_preview      = NULL;
    }
}
else{
    $note_preview = str_replace('_', '', $_FILES['note_preview']['name']);
    $note_preview      = $user_id.'_'.$date.'_'.$note_preview;
    $note_preview = str_replace(' ', '', $note_preview);
    $note_preview_file = $_FILES['note_preview']['tmp_name'];
    $note_preview_type = explode(".",$note_preview);

    if(end($note_preview_type) != 'pdf'){
        $error['notespreview'] = "File with only pdf format is allowed.";
    }
}


if(isset($_FILES['upload_notes'])){
    for($i=0;$i<$totalfiles;$i++){
        $filename = $_FILES['upload_notes']['name'][$i];
        $note_type = explode(".",$filename);
        if(end($note_type) != 'pdf'){
            $error['notes'] = "File with only pdf format is allowed.";
            break;
        }
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
            if(!isset($_FILES['upload_notes'])){
                $query = "SELECT NoteFile FROM notes WHERE NoteID = $note_id";
                $note_file_query = mysqli_query($connection,$query);
                confirmQuery($note_file_query);
            
                $row = mysqli_fetch_array($note_file_query);
                $upload_notes = $row['NoteFile'];
            }
            else{
                // Looping over all notes files
                for($i=0;$i<$totalfiles;$i++){
                    $filename_filter[$i] = str_replace('_', '', $_FILES['upload_notes']['name'][$i]);
                    $filename = $user_id.'_'.$date.'_'.$filename_filter[$i];
                        
                    // Upload files and store in database
                    move_uploaded_file($_FILES["upload_notes"]["tmp_name"][$i],'../images/uploads/notes/'.$filename);
                    $files[] = $filename;
                }
                $upload_notes = implode('/', $files);
            }

            $query = "UPDATE notes SET NoteTitle='{$title}', CategoryID='{$category}', DisplayPictureFile='{$display_picture}', NoteFile='{$upload_notes}', TypeID='{$type}', NotePage='{$no_of_pages}', Description='{$description}', CountryID='{$country}', InstituteName='{$institute_name}', CourseName='{$course_name}', CourseCode='{$course_code}', ProfessorName='{$professor}', SellType={$sell_type}, NotePrice='{$sell_price}', PreviewFile='{$note_preview}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' ";
            $query .= "WHERE NoteID='{$note_id}';";
            $update_notes_query = mysqli_query($connection, $query);

            if(!$update_notes_query) {
                die("QUERY FAILED ." . mysqli_error($connection));   
            }

            if(isset($_FILES['display_picture'])){
                // Save display picture
                move_uploaded_file($display_picture_file, "../images/uploads/display_pictures/$display_picture");
            }
            if(isset($_FILES['note_preview'])){
                // Save note preview
                move_uploaded_file($note_preview_file, "../images/uploads/note_preview/$note_preview");
            }
            header("Location:dashboard.php");

        }else{

            // Looping over all notes files
            for($i=0;$i<$totalfiles;$i++){
                $filename_filter[$i] = str_replace('_', '', $_FILES['upload_notes']['name'][$i]);
                $filename = $user_id.'_'.$date.'_'.$filename_filter[$i];
                    
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

        if(!isset($_FILES['upload_notes'])){
            $query = "SELECT NoteFile FROM notes WHERE NoteID = $note_id";
            $note_file_query = mysqli_query($connection,$query);
            confirmQuery($note_file_query);
        
            $row = mysqli_fetch_array($note_file_query);
            $upload_notes = $row['NoteFile'];
        }
        else{
            // Looping over all notes files
            for($i=0;$i<$totalfiles;$i++){
                $filename_filter[$i] = str_replace('_', '', $_FILES['upload_notes']['name'][$i]);
                $filename = $user_id.'_'.$date.'_'.$filename_filter[$i];
                    
                // Upload files and store in database
                move_uploaded_file($_FILES["upload_notes"]["tmp_name"][$i],'../images/uploads/notes/'.$filename);
                $files[] = $filename;
            }
            $upload_notes = implode('/', $files);
        }
        
        $query = "UPDATE notes SET NoteTitle='{$title}', CategoryID='{$category}', DisplayPictureFile='{$display_picture}', NoteFile='{$upload_notes}', TypeID='{$type}', NotePage='{$no_of_pages}', Description='{$description}', CountryID='{$country}', InstituteName='{$institute_name}', CourseName='{$course_name}', CourseCode='{$course_code}', ProfessorName='{$professor}', SellType={$sell_type}, NotePrice='{$sell_price}', PreviewFile='{$note_preview}', NoteStatusID=2,ModifiedBy='{$user_id}', ModifiedDate='{$date}' ";
        $query .= "WHERE NoteID='{$note_id}';";
        $update_notes_query = mysqli_query($connection, $query);

        if(!$update_notes_query) {
            die("QUERY FAILED ." . mysqli_error($connection));   
        }

        if(isset($_FILES['display_picture'])){
            // Save display picture
            move_uploaded_file($display_picture_file, "../images/uploads/display_pictures/$display_picture");
        }
        if(isset($_FILES['note_preview'])){
            // Save note preview
            move_uploaded_file($note_preview_file, "../images/uploads/note_preview/$note_preview");
        }

        //Send mail to admin
        // Seller Data to send mail
        $query = "SELECT FirstName,LastName FROM user WHERE UserID=$user_id";
        $seller_query = mysqli_query($connection, $query);
        confirmQuery($seller_query);

        while($row = mysqli_fetch_array($seller_query)){
            $seller_fname = $row['FirstName'];
            $seller_lname = $row['LastName'];
        }

        $query = "SELECT SubscriberEmails FROM systemtable WHERE SystemID = 1";
        $get_email_query = mysqli_query($connection,$query);
        confirmQuery($get_email_query);

        $row = mysqli_fetch_array($get_email_query);
        $email_admin = $row['SubscriberEmails'];

        $email_subject = $seller_fname.' '.$seller_lname.' sent his note for review';

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
                        <td style="font-size: 18px; line-height: 22px; font-weight: 600; color: #333333; font-family: "Open Sans",sans-serif; padding-top: 20px; padding-bottom: 20px;">Hello Admins,</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>We want to inform you that, '.$seller_fname.' '.$seller_lname.' sent his note '.$title.' for review. Please look at the notes and take required actions.</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>Regards,<br>Notes Marketplace</td>
                    </tr>
                </table>     
            </body>
        </html>';

        SendMailToAdmin($email_admin,$email_subject,$email_body);
        header("Location:dashboard.php");
    }
}
?>