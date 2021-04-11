
<?php
    include '../../Database/database.php';
    if(isset($_GET['note_id'])){
        $note_id = htmlspecialchars($_GET["note_id"]);

        $query = "SELECT NoteFile FROM notes WHERE NoteID = $note_id";
        $notes_file_query = mysqli_query($connection,$query);
        if(!$notes_file_query ) {
            die("QUERY FAILED ." . mysqli_error($connection));   
        }

        $row = mysqli_fetch_array($notes_file_query);
        $note_file = $row['NoteFile'];

        echo $note_file;
    }
?>