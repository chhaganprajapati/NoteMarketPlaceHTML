<?php
    date_default_timezone_set('Asia/Kolkata');
    include "../Database/database.php";

    session_start();
    $user = $_SESSION['user_id'];
    if(!isset($user)){
        header("Location:../login.php");
    }


    if(isset($_GET['spam'])){
        $note_id = $_POST['note_id'];
        $remark = $_POST['remark'];
        $date = date('YmdHis');

        $query = "INSERT INTO spamnotes (NoteID, Remark, CreatedDate, CreatedBy) VALUES('{$note_id}','{$remark}','{$date}','{$user}');";
        $spam_notes_query = mysqli_query($connection,$query);
        if(!$spam_notes_query){
            die("Query Failed". mysqli_error($connection));
        }

        //Send mail to admin
        $query = "SELECT notes.NoteTitle, user.FirstName, user.LastName FROM notes JOIN user ON notes.SellerID = user.UserID WHERE notes.NoteID = $note_id";
        $note_detail_query = mysqli_query($connection,$query);
        confirmQuery($note_detail_query);

        $row = mysqli_fetch_array($note_detail_query);
        $note_title = $row['NoteTitle'];
        $seller_fname = $row['FirstName'];
        $seller_lname = $row['LastName'];

        // Seller Data to send mail
        $query = "SELECT FirstName,LastName FROM user WHERE UserID=$user";
        $buyer_query = mysqli_query($connection, $query);
        confirmQuery($buyer_query);

        while($row = mysqli_fetch_array($buyer_query)){
            $buyer_fname = $row['FirstName'];
            $buyer_lname = $row['LastName'];
        }

        $query = "SELECT SubscriberEmails FROM systemtable WHERE SystemID = 1";
        $get_email_query = mysqli_query($connection,$query);
        confirmQuery($get_email_query);

        $row = mysqli_fetch_array($get_email_query);
        $email_admin = $row['SubscriberEmails'];

        $email_subject = $buyer_fname.' '.$buyer_lname.' Reported an issue for '.$note_title;

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
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>We want to inform you that, '.$buyer_fname.' '.$buyer_lname.' Reported an issue for '.$seller_fname.' '.$seller_lname.' Note with title '.$note_title.'. Please look at the notes and take required actions.</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>Regards,<br>Notes Marketplace</td>
                    </tr>
                </table>     
            </body>
        </html>';

        SendMailToAdmin($email_admin,$email_subject,$email_body);

        echo 'success';

    }
    else{
        $note_id = $_POST['note_id'];
        $rating = $_POST['rate'];
        $comments = $_POST['comments'];
        $date = date('YmdHis');

        $query = "INSERT INTO reviewnotes (Rating, Comments, NoteID, ReviewerID, CreatedDate, CreatedBy) VALUES('{$rating}','{$comments}','{$note_id}','{$user}','{$date}','{$user}');";
        $add_review_query = mysqli_query($connection, $query);
        if(!$add_review_query){
            die("Query Failed". mysqli_error($connection));
        }
        else{
            echo "success";
        }
    }

?>