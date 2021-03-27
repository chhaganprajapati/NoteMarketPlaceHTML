<?php 
include 'Database/database.php';
include 'functions.php';
session_start();
?>

<?php

//  verify the email address
if(isset($_GET['code'])){
    $user_id = $_GET['code'];
    $query = "SELECT * FROM user WHERE UserID=$user_id";
    $user_query =  mysqli_query($connection, $query);
    confirmQuery($user_query);

    if(mysqli_fetch_array($user_query) > 0){

        $query = "SELECT * FROM user WHERE UserID=$user_id and IsEmailVerified=0";
        $isemailverified_query =  mysqli_query($connection, $query);
        confirmQuery($isemailverified_query);

        if(mysqli_fetch_array($isemailverified_query) > 0){

            $query = "UPDATE user SET IsEmailVerified=1 WHERE UserID=$user_id";
            $status_query = mysqli_query($connection, $query);
            confirmQuery($status_query);
            $_SESSION['user_id'] = $user_id;
            header("Location:member/user_profile.html");
        }
        else{
            header("Location:login.php");
        }
    }
    else{
        header("Location:index.html");
    }
}


?>

<!-- Send the verification mail -->
<?php
if(isset($_GET['id'])){
    $email = $_GET['id'];
    $query = "SELECT UserID,FirstName FROM user WHERE EmailID='$email' and IsEmailVerified=0";
    $user_id_query = mysqli_query($connection, $query);
    if(!$user_id_query)
    {
        die("QUERY FAILED".mysqli_error($connection));
    }

    if(mysqli_num_rows($user_id_query) == 0){
        header("Location:index.html");
    }
    else{

        $row=mysqli_fetch_array($user_id_query);
        $user_id = $row['UserID'];
        $fname = $row['FirstName'];

        $subject = " Note Marketplace - Email Verification";
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
                        <td style="font-size: 26px; line-height: 30px; font-weight: 600; color: #6255a5; font-family: "Open Sans",sans-serif; padding-top: 50px; padding-bottom: 30px;">Email Verification</td>
                    </tr>
                    <tr>
                        <td style="font-size: 18px; line-height: 22px; font-weight: 600; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;">Dear '.$fname.',</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 50px;">Thanks for Signing up!<br>Simply click below for email verification.</td>
                    </tr>
                    <tr>
                        <td><a href="http://localhost/NotesMarketPlace/email_verification.php?code='.$user_id.'"><button style="width: 540px; height: 50px; border-radius: 3px; background-color: #6255a5; color: #fff; border: none; font-family: "Open Sans",sans-serif; font-size: 18px; font-weight: 600; line-height: 22px; text-transform: uppercase;">Verify Email Address</button></a></td>
                    </tr>
                </table>     
            </body>
        </html>';

        SendMail($email,$subject,$email_body);
    }
   
    ?>


    <!DOCTYPE html>
    <html lang="en">
        <head>
            <!--Title-->
            <title>NotesMarketPlace-Email verification</title>

            <!--Favicon-->
            <link rel="icon" href="images/favicon.ico">

            <!-- Google Fonts -->
            <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

            <style type="text/css">
                table {
                    width: 800px; 
                    padding: 30px; 
                    margin: 0 auto;
                }
                table td.data {
                    font-size: 18px; 
                    line-height: 22px; 
                    font-weight: 600; 
                    color: #6255a5; 
                    font-family: 'Open Sans',sans-serif; 
                    padding-bottom: 20px; 
                }
            </style>
        </head>
        <body>
            <table>
                <tr>
                    <td><img src="images/front/logo.png"></td>
                </tr>
                <tr>
                    <td class="data" style="padding-top: 20px;">Thank you for Signup.</td>
                </tr>
                <tr>
                    <td class="data">Please verify the email address via clicking on the link we sent you via email. </td>
                </tr>
            </table>     
        </body>
    </html>
<?php  }
    ?>