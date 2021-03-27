<?php
date_default_timezone_set('Asia/Kolkata');
include '../Database/database.php';
include '../functions.php';
session_start();
$buyer = $_SESSION['user_id'];
if(!isset($buyer)){
    header("Location:../login.php");
}

    // Download From notes detail page
    if(isset($_GET["note_id"])){
        $note_id = htmlspecialchars($_GET["note_id"]);

        $query = "SELECT SellerID,SellType,NotePrice FROM notes WHERE NoteID=$note_id";
        $notes_query = mysqli_query($connection, $query);
        if(!$notes_query){
            die("Query Failed". mysqli_error($connection));
        }


        while($row = mysqli_fetch_array($notes_query)){
            $seller = $row['SellerID'];
            $sell_type = $row['SellType'];
            $note_price = $row['NotePrice'];
        }
        $date = date('YmdHis');
        if($sell_type == 0){

            $query = "INSERT INTO downloads (NoteID, BuyerID, SellerID, RequestStatus, NotePrice, IsAttachmentDownloaded, 	AttachmentDownloadedDate, CreatedDate, 	CreatedBy)";
            $query .= "VALUES ('{$note_id}', '{$buyer}', '{$seller}', 1, '{$note_price}', 1, '{$date}', '{$date}', '{$buyer}');";
            $download_query = mysqli_query($connection, $query);

            if(!$download_query){
                die("Query Failed". mysqli_error($connection));
            }
        }

        if($sell_type == 1){

            $query = "INSERT INTO downloads (NoteID, BuyerID, SellerID, RequestStatus, NotePrice, IsAttachmentDownloaded, CreatedDate, 	CreatedBy)";
            $query .= "VALUES ('{$note_id}', '{$buyer}', '{$seller}', 0, '{$note_price}', 0, '{$date}', '{$buyer}');";
            $download_query = mysqli_query($connection, $query);

            if(!$download_query){
                die("Query Failed". mysqli_error($connection));
            }

            // Seller Data to send mail
            $query = "SELECT EmailID,FirstName FROM user WHERE UserID=$seller";
            $seller_query = mysqli_query($connection, $query);
            confirmQuery($seller_query);

            while($row = mysqli_fetch_array($seller_query)){
                $email = $row['EmailID'];
                $seller_fname = $row['FirstName'];
            }

            // Buyer Data to send mail
            $query = "SELECT FirstName,LastName FROM user WHERE UserID=$buyer";
            $buyer_query = mysqli_query($connection, $query);
            confirmQuery($buyer_query);

            while($row = mysqli_fetch_array($buyer_query)){
                $buyer_fname = $row['FirstName'];
                $buyer_lname = $row['LastName'];
            }

            $email_subject = "$buyer_fname $buyer_lname wants to purchase your notes ";

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
                                <td style="font-size: 18px; line-height: 22px; font-weight: 600; color: #333333; font-family: "Open Sans",sans-serif; padding-top: 20px; padding-bottom: 20px;">Hello '.$seller_fname.',</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;">We would like to inform you that, '.$buyer_fname.' wants to purchase your notes. Please see
                                Buyer Requests tab and allow download access to Buyer if you have received the payment from
                                him.</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;">Regards,<br>Notes Marketplace</td>
                            </tr>
                        </table>     
                    </body>
                </html>';


            SendMail($email,$email_subject,$email_body);
        }
    }


    if(isset($_GET['download_id'])){
        $download_id = htmlspecialchars($_GET["download_id"]);

        $query = "SELECT notes.NoteFile FROM downloads JOIN notes ON downloads.NoteID = notes.NoteID WHERE DownloadID = $download_id";
        $notes_file_query = mysqli_query($connection,$query);
        confirmQuery($notes_file_query);

        $row = mysqli_fetch_array($notes_file_query);
        $note_file = $row['NoteFile'];
        $date = date('YmdHis');

        $query = "UPDATE downloads SET IsAttachmentDownloaded = 1, AttachmentDownloadedDate = '{$date}' WHERE DownloadID = $download_id";
        $update_download_query = mysqli_query($connection,$query);
        confirmQuery($update_download_query);

        echo $note_file;
    }

    // Allow Download in buyer request page
    if(isset($_GET['allow_download'])){
        $download_id = $_GET['allow_download'];
        $date = date('YmdHis');

        $query = "UPDATE downloads SET RequestStatus = 1, ModifiedDate = '{$date}', ModifiedBy = '{$buyer}'  WHERE DownloadID = $download_id";
        $allow_download_query = mysqli_query($connection,$query);
        confirmQuery($allow_download_query);

        // Email to buyer
        $user_id = $_SESSION['user_id'];
        // Seller Data to send mail
        $query = "SELECT FirstName,LastName FROM user WHERE UserID=$user_id";
        $seller_query = mysqli_query($connection, $query);
        confirmQuery($seller_query);

        while($row = mysqli_fetch_array($seller_query)){
            $seller_fname = $row['FirstName'];
            $seller_lname = $row['LastName'];
        }

         // Buyer Data to send mail
         $query = "SELECT user.EmailID,user.FirstName FROM downloads JOIN user ON downloads.BuyerID = user.UserID WHERE DownloadID=$download_id";
         $buyer_query = mysqli_query($connection, $query);
         confirmQuery($buyer_query);

         while($row = mysqli_fetch_array($buyer_query)){
             $buyer_fname = $row['FirstName'];
             $email = $row['EmailID'];
         }

         $email_subject = "$seller_fname $seller_lname Allows you to download a note ";

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
                                <td style="font-size: 18px; line-height: 22px; font-weight: 600; color: #333333; font-family: "Open Sans",sans-serif; padding-top: 20px; padding-bottom: 20px;">Hello '.$buyer_fname.',</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>We would like to inform you that, '.$seller_fname.' Allows you to download a note.
                                Please login and see My Download tabs to download particular note.</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #333333; font-family: "Open Sans",sans-serif; padding-bottom: 20px;"><br>Regards,<br>Notes Marketplace</td>
                            </tr>
                        </table>     
                    </body>
                </html>';


            SendMail($email,$email_subject,$email_body);
    }
?>