<?php
include 'Database/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['forgot_pass'])){
    $email = strtolower(trim($_POST['email']));
    $email = mysqli_real_escape_string($connection, $email);

    $query = "SELECT EmailID FROM user WHERE EmailID = '$email'";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("QUERY FAILED".mysqli_error($connection));
    }

    if(mysqli_num_rows($result) == 0) {
        $message = "&#10008;"."User does not exists.Please verify email!";
    }
    else{

        $data_password = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz@!';
        $password = substr(str_shuffle($data_password), 0, 8);
        $password_hash = md5($password);

        $query = "UPDATE user SET Password='{$password_hash}' WHERE EmailID='{$email}'";
        $update_pass_query = mysqli_query($connection, $query);
        if(!$update_pass_query){
            die("QUERY FAILED".mysqli_error($connection));
        }
         
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
                        <td style="font-size: 18px; line-height: 22px; font-weight: 600; color: #333333; font-family: "Open Sans",sans-serif; padding-top: 20px; padding-bottom: 20px;">Hello,</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;">We have generated a new password for you<br>Password: '.$password.'</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;">Regards,<br>Notes Marketplace</td>
                    </tr>
                </table>     
            </body>
        </html>';
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
            $mail->Subject = "New Temporary Password has been created for you";       //subject line of email
            $mail->Body = $email_body;   //Email body
         
            $mail->send();
            // echo "<script> alert('Deleted successfully!');window.location='login.php'</script>";
            header("Location:login.php");
        } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        }
        
    }
}
else{
    $message= "";
}



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-Forgot password?</title>

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
        <link rel="stylesheet" href="css/form-style.css">
    </head>
    <body>

            <!-- Forgot password form -->
            <div class="form-container">

                <!-- logo -->
                <div class="content-logo text-center">
                    <img src="images/pre-login/top-logo.png">
                </div>

                <!-- Form content -->
                <form action="forgot_password.php" method="post" class="form-content">

                    <h2>Forgot Password?</h2>
                    <p>Enter your email to reset your password</p>
                    <p style="margin-bottom: 5px; color: red;"><?php echo $message;?></p>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo isset($email) ? $email : '' ?>" required>
                        </div>
                    </div>

                    <button type="submit" name="forgot_pass">SUBMIT</button>
                </form>

        </div>

        <!--JQuery-->
        <script src="js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="js/bootstrap/bootstrap.min.js"></script>

        <!--Custom JS-->
        <script src="js/script.js"></script>
    </body>
</html>