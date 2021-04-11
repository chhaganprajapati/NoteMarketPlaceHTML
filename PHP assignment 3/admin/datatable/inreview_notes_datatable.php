<?php
include '../../Database/database.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
$seller = $_POST['searchByseller'];

// filter queries
$filterQuery = "";

if($seller != ''){
    $filterQuery .= " AND (notes.SellerID = '".$seller."')";
}

// Order by
$orderby = '';

if($columnName == 'sr_no'){
    $orderby = 'notes.ModifiedDate asc';
}
else if($columnName == 'Category'){
    $orderby = "categorytable.".$columnName." ".$columnSortOrder ;
}
else if($columnName == 'Seller'){
    $orderby = "user.FirstName ".$columnSortOrder.", user.LastName ".$columnSortOrder ;
}
else if($columnName == 'Status'){
    $orderby = "notestatus.Status ".$columnSortOrder ;
}
else{
    $orderby = "notes.".$columnName." ".$columnSortOrder ;
}

// datatable search query
if($searchValue != ''){
    $filterQuery .= " AND (notes.NoteTitle LIKE '%".$searchValue."%' OR 
       categorytable.Category LIKE '%".$searchValue."%' OR 
       user.FirstName LIKE'%".$searchValue."%' OR notes.ModifiedDate LIKE'%".$searchValue."%' OR user.LastName LIKE'%".$searchValue."%' OR notestatus.Status LIKE'%".$searchValue."%') ";
}


$query = "SELECT notes.NoteID, notes.NoteFile, notes.NoteTitle, categorytable.Category, notes.ModifiedDate, user.FirstName, user.LastName, notestatus.Status, notes.SellerID ,notes.NoteStatusID FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN user ON notes.SellerID=user.UserID JOIN notestatus ON notes.NoteStatusID=notestatus.NoteStatusID WHERE (notes.NoteStatusID = 2 OR notes.NoteStatusID = 3 ) AND notes.IsActive=1".$filterQuery." ORDER BY ".$orderby." LIMIT ".$row.",".$rowperpage."";
$inreview_notes_query = mysqli_query($connection, $query);
if(!$inreview_notes_query ) {
    die("QUERY FAILED ." . mysqli_error($connection));   
}
$data = array();
$count = $row;

// total rows of record
$query = "SELECT count(*) AS allcount FROM notes WHERE (NoteStatusID = 2 OR NoteStatusID = 3) AND IsActive=1";
$record_all_query = mysqli_query($connection,$query);
$record = mysqli_fetch_array($record_all_query);
$totalRecords  = $record['allcount'];

// Total rows after aplying filter
$query = "SELECT count(*) AS allcount FROM notes  JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN user ON notes.SellerID=user.UserID JOIN notestatus ON notes.NoteStatusID=notestatus.NoteStatusID WHERE (notes.NoteStatusID = 2 OR notes.NoteStatusID = 3 ) AND notes.IsActive=1".$filterQuery;
$record_query = mysqli_query($connection,$query);
$record1 = mysqli_fetch_array($record_query);
$totalRecordwithFilter = $record1['allcount'];


while($row = mysqli_fetch_array($inreview_notes_query)){
    $sr_no = ++$count;
    $added_date = strtotime($row['ModifiedDate']);
    $added_date = date('d-m-Y, H:i',$added_date);//change date format according to user interface

    // array of all data
    $data[] = array( 
        "sr_no"=>$sr_no,
        "NoteID"=>$row['NoteID'],
        "NoteTitle"=>$row['NoteTitle'],
        "Category"=>$row['Category'],
        "SellerID"=>$row['SellerID'],
        "Seller"=>$row['FirstName'].' '.$row['LastName'],
        "ModifiedDate"=>$added_date,
        "NoteFile"=>$row['NoteFile'],
        "Status"=>$row['Status'],
        "NoteStatusID"=>$row['NoteStatusID']
    );
}

$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "data" => $data
);
  
echo json_encode($response);

?>