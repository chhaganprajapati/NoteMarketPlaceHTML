<?php
    date_default_timezone_set('Asia/Kolkata');
    include "../Database/database.php";

    session_start();
    $user = $_SESSION['user_id'];
    if(!isset($user)){
        header("Location:../login.php");
    }


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

?>