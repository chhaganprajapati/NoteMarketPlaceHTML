<?php

//fetch_data.php

include '../Database/database.php';

if(isset($_POST["action"]))
{
    $query = "SELECT notes.NoteID, notes.NoteTitle, categorytable.Category, notes.DisplayPictureFile, notes.NotePage, countrytable.CountryName, notes.InstituteName, notes.PublishedDate FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN countrytable ON notes.CountryID = countrytable.CountryID WHERE NoteStatusID=4";


    if(!empty($_POST["note_type"]))
    {
        $query .= " AND notes.TypeID IN('{$_POST['note_type']}')";
    }

    if(!empty($_POST["category"]))
    {
        $query .= " AND notes.CategoryID IN('{$_POST['category']}')";
    }

    if(!empty($_POST["university_name"]))
    {
        $query .= " AND notes.InstituteName IN('{$_POST['university_name']}')";
    }

    if(!empty($_POST["course_name"]))
    {
        $query .= " AND notes.CourseName IN('{$_POST['course_name']}')";
    }

    if(!empty($_POST["country"]))
    {
        $query .= " AND notes.CountryID IN('{$_POST['country']}')";
    }

    if(!empty($_POST["rating"]))
    {
        $query .= " AND (SELECT AVG(Rating) FROM reviewnotes WHERE reviewnotes.NoteID = notes.NoteID and reviewnotes.IsActive = 1) >= {$_POST["rating"]}";
    }

    if(!empty($_POST["search"]))
    {
        $query .= " AND (notes.NoteTitle LIKE '%".$_POST['search']."%' OR categorytable.Category LIKE '%".$_POST['search']."%')";
    }

    
    $query .= " ORDER BY notes.PublishedDate desc";

    $notes_query = mysqli_query($connection, $query);
    if(!$notes_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }

    $total_row = mysqli_num_rows($notes_query);
    $output = '';

    
    if($total_row > 0)
    {
        $output .= '<div class="row">
                    <div class="col-md-12">
                        <h2>Total '.$total_row.' notes</h2>
                    </div>
                </div>
                <input type="hidden" id="total_notes" value="'.$total_row.'">
                <div class="row ">
                ';

        $count = 0;

        $query = "SELECT DefaultDisplayPicture FROM systemtable WHERE SystemID = 1";
        $display_query = mysqli_query($connection,$query);
        if(!$display_query){
            die("Query Failed". mysqli_error($connection));
        }

        $row = mysqli_fetch_array($display_query);
        $default_display_picture = $row['DefaultDisplayPicture'];

        while($row = mysqli_fetch_array($notes_query))
        {
            $note_id = $row['NoteID'];
            $title = $row['NoteTitle'];
            $category = $row['Category']; 
            $display_picture = $row['DisplayPictureFile'];
            $institute_name = $row['InstituteName'];
            $country = $row['CountryName'];
            $note_pages = $row['NotePage'];
            $published_date = $row['PublishedDate'];
            $published_day = date("D",strtotime($published_date));
            $published_date = date("M d Y",strtotime($published_date));
            $count++;

            if(!empty($display_picture)){
                $display_image = "../images/uploads/display_pictures/$display_picture";
            }
            else{
                $display_image = "../images/uploads/display_pictures/$default_display_picture";
            }

            $query = "SELECT AVG(Rating) AS AvgRating, COUNT(*) AS TotalReview FROM reviewnotes WHERE NoteID = $note_id AND IsActive = 1";
            $review_count_query = mysqli_query($connection, $query);
            if(!$review_count_query){
                die("Query Failed". mysqli_error($connection));
            }

            $row1 = mysqli_fetch_array($review_count_query);
            $AvgRating = $row1['AvgRating'];
            $TotalReview = $row1['TotalReview'];

            // NOtes spam count
            $query = "SELECT COUNT(*) AS TotalSpam FROM spamnotes WHERE NoteID = $note_id";
            $spam_count_query = mysqli_query($connection, $query);
            if(!$spam_count_query){
                die("Query Failed". mysqli_error($connection));
            }

            $row1 = mysqli_fetch_array($spam_count_query);
            $TotalSpam = $row1['TotalSpam'];

        $output .= '
        <div class="col-lg-4 col-sm-6" id="notes-list-'.$count.'">
            <div class="notes-list-item">
                <div class="row">
                    <div class="col-md-12">
                        <img src='.$display_image.' class="img-fluid" alt="notes banner">
                        <div class="notes-list-detail">
                            <a href="notes_details.php?note='.$note_id.'" style="text-decoration: none;">
                                <h3>'.$title.' - '.$category.'</h3>
                            </a>
                            <p><img src="../images/front/university.png">'.$institute_name.', '.$country.'</p>
                            <p><img src="../images/front/pages.png">'.$note_pages.' Pages</p>
                            <p><img src="../images/front/date.png">'.$published_day.', '.$published_date.' </p>
                            <p style="color: #df3434;"><img src="../images/front/flag.png">';
                            
                            if(!empty($TotalSpam)){                               
                                 $output .= $TotalSpam.' Users marked this note as inappropriate';
                            }
                            
                            $output .= '</p><div class="rating-star">'; 

                            for($i = 1;$i<=5;$i++){
                                if($i <= ($AvgRating)){
                                    $output .= '<img src="../images/front/star.png" alt="star"> ';
                                }
                                else{
                                    $output .= '<img src="../images/front/star-white.png" alt="star"> ';
                                }
                            }
                            $output .= ' '.$TotalReview.' Reviews';
                            
                $output .= '</div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
        }
        $output .= '</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pagination">
                            <a href="#" style="margin-right: 15px;" id="prev">
                                <img src="../images/front/left-arrow.png">
                            </a>
                            <div id="page-no"></div>
                            <a href="#" style="margin-left: 13px; padding-left: 14px;" id="next">
                                <img src="../images/front/right-arrow.png">
                            </a>
                        </div>
                    </div>
                </div>
            ';
    }
    else
    {
        $output = '<div class="row">
                        <div class="col-md-12">
                            <h2>No Data Found</h2>
                        </div>
                    </div>
                    ';
    }
    echo $output;
}

?>