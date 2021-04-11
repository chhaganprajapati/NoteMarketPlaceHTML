<?php
    date_default_timezone_set('Asia/Kolkata');  
    session_start();
    $user_id = $_SESSION['admin_id'];
    require '../Database/database.php';
    include '../functions.php';


    if(isset($_GET['InReview'])){
        $note_id = $_GET['note_id'];

        $query = "UPDATE notes SET NoteStatusID=3, ActionedBy='{$user_id}' WHERE NoteID = $note_id";
        $update_review_status = mysqli_query($connection,$query);
        confirmQuery($update_review_status);

        echo 'success';
    }

    if(isset($_GET['approve'])){
        $note_id = $_GET['note_id'];
        $date = date('YmdHis');

        $query = "UPDATE notes SET NoteStatusID=4, PublishedDate='{$date}',ActionedBy='{$user_id}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE NoteID = $note_id";
        $update_publish_status = mysqli_query($connection,$query);
        confirmQuery($update_publish_status);

        echo 'success';
    }

    if(isset($_GET['reject'])){
        $note_id = $_POST['note_id'];
        $remark = $_POST['remark'];
        $date = date('YmdHis');

        $query = "UPDATE notes SET NoteStatusID=5, ActionedBy='{$user_id}', AdminRemark='{$remark}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE NoteID = $note_id";
        $update_reject_status = mysqli_query($connection,$query);
        confirmQuery($update_reject_status);

        echo 'success';

    }

    if(isset($_GET['unpublish'])){
        $note_id = $_POST['note_id'];
        $remark = $_POST['remark'];
        $date = date('YmdHis');

        $query = "UPDATE notes SET NoteStatusID=6, ActionedBy='{$user_id}', AdminRemark='{$remark}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE NoteID = $note_id";
        $update_reject_status = mysqli_query($connection,$query);
        confirmQuery($update_reject_status);

        $query = "SELECT notes.NoteTitle, user.EmailID, user.FirstName FROM notes JOIN user On notes.SellerID = user.UserID WHERE notes.NoteID = $note_id";
        $email_data_query = mysqli_query($connection,$query);
        confirmQuery($email_data_query);

        while($row = mysqli_fetch_array($email_data_query)){
            $email = $row['EmailID'];
            $title = $row['NoteTitle'];
            $Seller_fname = $row['FirstName'];

        }

        $email_subject = "Sorry! We need to remove your notes from our portal.";

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
                            <td style="font-size: 18px; line-height: 22px; font-weight: 600; color: #333333; font-family: "Open Sans",sans-serif; padding-top: 20px; padding-bottom: 20px;">Hello '.$Seller_fname.',</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>We want to inform you that, your note <strong>'.$title.'</strong> has been removed from the portal.<br>Please find our remarks as below - <br>'.$remark.'</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>Regards,<br>Notes Marketplace</td>
                        </tr>
                    </table>     
                </body>
            </html>';


        SendMail($email,$email_subject,$email_body);

        echo 'success';

    }

    if(isset($_POST['DeActivate'])){
        $member_id = $_POST['user_id'];
        $date = date('YmdHis');

        $query = "UPDATE user SET IsActive=0 WHERE UserID = $member_id";
        $remove_member_query = mysqli_query($connection, $query);
        confirmQuery($remove_member_query);

        $query = "UPDATE notes SET NoteStatusID=6, ActionedBy='{$user_id}', ModifiedBy='{$user_id}', ModifiedDate='{$date}' WHERE SellerID = $member_id";
        $update_reject_status = mysqli_query($connection,$query);
        confirmQuery($update_reject_status);

        echo 'success';

    }

    if(isset($_GET['delete_review'])){
        $review_id = $_GET['review_id'];
        $date = date('YmdHis');

        $query = "UPDATE reviewnotes SET IsActive=0 WHERE ReviewID = $review_id";
        $remove_review_query = mysqli_query($connection, $query);
        confirmQuery($remove_review_query);

        echo 'success';
    }

    if(isset($_POST['delete_spam'])){
        $SpamID = $_POST['SpamID'];

        $query = "DELETE FROM spamnotes WHERE SpamID = $SpamID";
        $remove_review_query = mysqli_query($connection, $query);
        confirmQuery($remove_review_query);

        echo 'success';
    }
?>