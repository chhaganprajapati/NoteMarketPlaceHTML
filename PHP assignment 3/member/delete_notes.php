<?php
    include "../Database/database.php";

    session_start();
    $user = $_SESSION['user_id'];
    if(!isset($user)){
        header("Location:../login.php");
    }

    if(isset($_POST['note_id'])){
        $note_id = $_POST['note_id'];

        $query = "DELETE FROM notes WHERE NoteID = $note_id";
        $delete_notes_query = mysqli_query($connection, $query);
        if(!$delete_notes_query){
            die("Query Failed". mysqli_error($connection));
        }    

        echo 'success';
    }
?>