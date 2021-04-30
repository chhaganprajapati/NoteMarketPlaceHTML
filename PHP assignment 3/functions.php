<?php  
include 'Database/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php 

function confirmQuery($result) {
    
    global $connection;

    if(!$result ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }
}


function GetCategory($category_value)
{
    global $connection;
    $query = "SELECT * FROM categorytable WHERE IsActive='1'";
    $category_query = mysqli_query($connection, $query);
    confirmQuery($category_query);


    while($row = mysqli_fetch_array($category_query)) {
        $category_id = $row['CategoryID'];
        $category = $row['Category'];
        if($category_value == $category_id){
            echo "<option value={$category_id} selected>{$category}</option>"; 
        }
        else{
            echo "<option value={$category_id}>{$category}</option>";
        }
    }
}

function GetNoteType($type_value)
{
    global $connection;
    $query = "SELECT * FROM typetable WHERE IsActive='1'";
    $type_query = mysqli_query($connection, $query);
    confirmQuery($type_query);


    while($row = mysqli_fetch_array($type_query)) {
        $type_id = $row['TypeID'];
        $type = $row['TypeName'];
        if($type_value == $type_id){
            echo "<option value={$type_id} selected>{$type}</option>"; 
        }
        else{
            echo "<option value={$type_id}>{$type}</option>";
        }
    }
}

function GetCountry($country_value)
{
    global $connection;
    $query = "SELECT * FROM countrytable WHERE IsActive='1'";
    $country_query = mysqli_query($connection, $query);
    confirmQuery($country_query);


    while($row = mysqli_fetch_array($country_query)) {
        $country_id = $row['CountryID'];
        $country = $row['CountryName'];
        if($country_value == $country_id){
            echo "<option value={$country_id} selected>{$country}</option>";
        }
        else{
            echo "<option value={$country_id}>{$country}</option>";
        }
    }
}

function SendMail($email,$email_subject,$email_body){
    //include PHPMailer classes to your PHP file for sending email
    require_once __DIR__ . '/src/Exception.php';
    require_once __DIR__ . '/src/PHPMailer.php';
    require_once __DIR__ . '/src/SMTP.php';
     
    // Create an object of the PHPMailer class. Passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);
     
    try {
        // Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;        // You can enable this for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  // This is fixed port for gmail SMTP
     
        $config_email = 'notesmarketplace2021@gmail.com';
        $mail->Username = $config_email; // YOUR gmail email which will be used as sender and PHPMailer configuration 
        $mail->Password = 'notes@2021';   // YOUR gmail password for above account

        // Sender and recipient settings
        $mail->setFrom($config_email, 'Notesmarketplace');  // This email address and name will be visible as sender of email                   
        $mail->addAddress($email);  // This email is where you want to send the email
     
        // Setting the email content
        $mail->IsHTML(true);  // You can set it to false if you want to send raw text in the body
        $mail->Subject = $email_subject;       //subject line of email
        $mail->Body = $email_body;   //Email body
     
        $mail->send();
        // echo "<script> alert('Deleted successfully!');window.location='login.php'</script>";
        return true;
    } catch (Exception $e) {
        echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
    }
}

function SendMailToAdmin($email_admin,$email_subject,$email_body){
    //include PHPMailer classes to your PHP file for sending email
    require_once __DIR__ . '/src/Exception.php';
    require_once __DIR__ . '/src/PHPMailer.php';
    require_once __DIR__ . '/src/SMTP.php';
     
    // Create an object of the PHPMailer class. Passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);
     
    try {
        // Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;        // You can enable this for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  // This is fixed port for gmail SMTP
     
        $config_email = 'notesmarketplace2021@gmail.com';
        $mail->Username = $config_email; // YOUR gmail email which will be used as sender and PHPMailer configuration 
        $mail->Password = 'notes@2021';   // YOUR gmail password for above account

        // Sender and recipient settings
        $mail->setFrom($config_email, 'Notesmarketplace');  // This email address and name will be visible as sender of email  
        
        $addr = explode(',',$email_admin);

        foreach ($addr as $ad) {
            $mail->AddAddress( trim($ad) );       
        }
        // $mail->addAddress($email);  // This email is where you want to send the email
     
        // Setting the email content
        $mail->IsHTML(true);  // You can set it to false if you want to send raw text in the body
        $mail->Subject = $email_subject;       //subject line of email
        $mail->Body = $email_body;   //Email body
     
        $mail->send();
        // echo "<script> alert('Deleted successfully!');window.location='login.php'</script>";
        return true;
    } catch (Exception $e) {
        echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
    }
}

function ProfileImage($user_id){

    global $connection;
    $query = "SELECT DefaultProfilePicture FROM systemtable WHERE SystemID = 1";
    $profile_query = mysqli_query($connection,$query);
    confirmQuery($profile_query);

    $row = mysqli_fetch_array($profile_query);
    $default_profile_picture = $row['DefaultProfilePicture'];

    $query = "SELECT ProfilePictureFile FROM user WHERE UserID = $user_id";
    $profile_picture_query = mysqli_query($connection, $query);
    confirmQuery($profile_picture_query);

    $row = mysqli_fetch_array($profile_picture_query);
    $profile_image = $row['ProfilePictureFile'];

    if(!empty($profile_image)){
        $profile_image = "../images/uploads/profile_picture/$profile_image";
    }
    else{
        $profile_image = "../images/uploads/profile_picture/$default_profile_picture";
    }

    return $profile_image;
}

function IsSuperAdmin($user_id){
    // check for super admin
    global $connection;
    $query = "SELECT RoleID From user WHERE UserID = $user_id";
    $get_role_query = mysqli_query($connection,$query);
    if(!$get_role_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $row = mysqli_fetch_array($get_role_query);
    return $row['RoleID'];
}

function GetfacebookURL(){
    global $connection;
    $query = "SELECT FacebookURL FROM systemtable WHERE SystemID = 1";
    $profile_query = mysqli_query($connection,$query);
    confirmQuery($profile_query);

    $row = mysqli_fetch_array($profile_query);
    if(mysqli_num_rows($profile_query) > 0){
        $FacebookURL = $row['FacebookURL'];
    }
    
    if(!empty($FacebookURL)){
        return $FacebookURL;
    }
    else{
        return '#';
    }
}

function GetlinkedinURL(){
    global $connection;
    $query = "SELECT LinkedinURL FROM systemtable WHERE SystemID = 1";
    $profile_query = mysqli_query($connection,$query);
    confirmQuery($profile_query);

    $row = mysqli_fetch_array($profile_query);
    if(mysqli_num_rows($profile_query) > 0){
        $LinkedinURL = $row['LinkedinURL'];
    }
    
    if(!empty($LinkedinURL)){
        return $LinkedinURL;
    }
    else{
        return '#';
    }
}

function GettwitterURL(){
    global $connection;
    $query = "SELECT TwitterURL FROM systemtable WHERE SystemID = 1";
    $profile_query = mysqli_query($connection,$query);
    confirmQuery($profile_query);

    $row = mysqli_fetch_array($profile_query);
    if(mysqli_num_rows($profile_query) > 0){
        $TwitterURL = $row['TwitterURL'];
    }
    
    if(!empty($TwitterURL)){
        return $TwitterURL;
    }
    else{
        return '#';
    }
}

?>