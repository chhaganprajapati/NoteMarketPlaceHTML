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
    $orderby = 'notes.ModifiedDate desc';
}
else if($columnName == 'Category'){
    $orderby = "categorytable.".$columnName." ".$columnSortOrder ;
}
else if($columnName == 'Seller'){
    $orderby = "u1.FirstName ".$columnSortOrder.", u1.LastName" ;
}
else if($columnName == 'ActionedBy'){
    $orderby = "u2.FirstName ".$columnSortOrder.", u2.LastName" ;
}
else{
    $orderby = "notes.".$columnName." ".$columnSortOrder ;
}

// datatable search query
if($searchValue != ''){
    $filterQuery .= " AND (notes.NoteTitle LIKE '%".$searchValue."%' OR 
       categorytable.Category LIKE '%".$searchValue."%' OR 
       notes.AdminRemark LIKE'%".$searchValue."%' OR u1.FirstName LIKE'%".$searchValue."%' OR notes.ModifiedDate LIKE'%".$searchValue."%' OR u1.LastName LIKE'%".$searchValue."%' OR u2.FirstName LIKE'%".$searchValue."%' OR u2.LastName LIKE'%".$searchValue."%') ";
}


$query = "SELECT notes.NoteID, notes.NoteFile, notes.NoteTitle, categorytable.Category, notes.ModifiedDate, notes.AdminRemark,  u1.FirstName AS SellerFname, u1.LastName AS SellerLname, u2.FirstName AS ActionFname, u2.LastName AS ActionLname, notes.SellerID, notes.ActionedBy FROM notes JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN user u1 ON notes.SellerID = u1.UserID JOIN user u2 ON notes.ActionedBy = u2.UserID WHERE notes.NoteStatusID = 5 AND notes.IsActive=1".$filterQuery." ORDER BY ".$orderby." LIMIT ".$row.",".$rowperpage."";
$rejected_notes_query = mysqli_query($connection, $query);
if(!$rejected_notes_query ) {
    die("QUERY FAILED ." . mysqli_error($connection));   
}
$data = array();
$count = $row;

// total rows of record
$query = "SELECT count(*) AS allcount FROM notes WHERE NoteStatusID = 5 AND IsActive=1";
$record_all_query = mysqli_query($connection,$query);
$record = mysqli_fetch_array($record_all_query);
$totalRecords  = $record['allcount'];

// Total rows after aplying filter
$query = "SELECT count(*) AS allcount FROM notes  JOIN categorytable ON notes.CategoryID=categorytable.CategoryID JOIN user ON notes.SellerID=user.UserID JOIN user u1 ON notes.SellerID = u1.UserID JOIN user u2 ON notes.ActionedBy = u2.UserID WHERE notes.NoteStatusID = 5 AND notes.IsActive=1".$filterQuery;
$record_query = mysqli_query($connection,$query);
$record1 = mysqli_fetch_array($record_query);
$totalRecordwithFilter = $record1['allcount'];


while($row = mysqli_fetch_array($rejected_notes_query)){
    $sr_no = ++$count;
    $rejected_date = strtotime($row['ModifiedDate']);
    $rejected_date = date('d-m-Y, H:i',$rejected_date);//change date format according to user interface

    // array of all data
    $data[] = array( 
        "sr_no"=>$sr_no,
        "NoteID"=>$row['NoteID'],
        "NoteTitle"=>$row['NoteTitle'],
        "Category"=>$row['Category'],
        "Seller"=>$row['SellerFname'].' '.$row['SellerLname'],
        "SellerID"=>$row['SellerID'],
        "ModifiedDate"=>$rejected_date,
        "ActionedBy"=>$row['ActionFname'].' '.$row['ActionLname'],
        "AdminRemark"=>$row['AdminRemark'],
        "NoteFile"=>$row['NoteFile']
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