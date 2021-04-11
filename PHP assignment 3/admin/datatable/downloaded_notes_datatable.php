<?php
include '../../Database/database.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
// $sort = $_POST['request'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
$seller = $_POST['searchByseller'];
$buyer = $_POST['searchBybuyer'];
$note_id = $_POST['searchByNoteID'];

$i=0;


// filter queries
$filterQuery = "";


if($seller != ''){
    $filterQuery .= " AND (downloads.SellerID = '".$seller."')";
}

if($buyer != ''){
    $filterQuery .= " AND (downloads.BuyerID = '".$buyer."')";
}

if($note_id != ''){
    $filterQuery .= " AND (downloads.NoteID = '".$note_id."')";
}

// Order by
$orderby = '';

if($columnName == 'sr_no'){
    $orderby = 'downloads.AttachmentDownloadedDate desc';
}
else if($columnName == 'Category'){
    $orderby = "(SELECT Category FROM categorytable WHERE categorytable.CategoryID = notes.CategoryID AND IsActive = 1) ".$columnSortOrder ;
}
else if($columnName == 'Seller'){
    $orderby = "u1.FirstName ".$columnSortOrder.", u1.LastName ".$columnSortOrder ;
}
else if($columnName == 'Buyer'){
    $orderby = "u2.FirstName ".$columnSortOrder.", u2.LastName ".$columnSortOrder ;
}
else{
    $orderby = $columnName." ".$columnSortOrder ;
}

// datatable search query
if($searchValue != ''){
    $filterQuery .= " AND (notes.NoteTitle LIKE '%".$searchValue."%' OR 
       notes.NotePrice LIKE'%".$searchValue."%' OR u1.FirstName LIKE'%".$searchValue."%' OR downloads.AttachmentDownloadedDate LIKE'%".$searchValue."%' OR  u1.LastName LIKE'%".$searchValue."%' OR u2.FirstName LIKE'%".$searchValue."%' OR u2.LastName LIKE'%".$searchValue."%' OR (SELECT Category FROM categorytable WHERE categorytable.CategoryID = notes.CategoryID AND IsActive = 1) LIKE'%".$searchValue."%') ";
}


$query = "SELECT downloads.NoteID, notes.NoteFile, notes.NoteTitle, notes.CategoryID, downloads.AttachmentDownloadedDate, notes.SellType, notes.NotePrice, u1.FirstName AS SellerFname, u1.LastName AS SellerLname, u2.FirstName AS BuyerFname, u2.LastName AS BuyerLname, downloads.SellerID, downloads.BuyerID FROM downloads JOIN notes ON downloads.NoteID=notes.NoteID JOIN user u1 ON downloads.SellerID = u1.UserID JOIN user u2 ON downloads.BuyerID = u2.UserID WHERE downloads.IsAttachmentDownloaded = 1 AND downloads.IsActive=1".$filterQuery." ORDER BY ".$orderby." LIMIT ".$row.",".$rowperpage."";
$downloaded_notes_query = mysqli_query($connection, $query);
if(!$downloaded_notes_query ) {
    die("QUERY FAILED ." . mysqli_error($connection));   
}
$data = array();
$count = $row;

// total rows of record
$query = "SELECT count(*) AS allcount FROM downloads WHERE downloads.IsAttachmentDownloaded = 1 AND downloads.IsActive=1";
$record_all_query = mysqli_query($connection,$query);
$record = mysqli_fetch_array($record_all_query);
$totalRecords  = $record['allcount'];

// Total rows after aplying filter
$query = "SELECT count(*) AS allcount FROM downloads JOIN notes ON downloads.NoteID=notes.NoteID JOIN user u1 ON downloads.SellerID = u1.UserID JOIN user u2 ON downloads.BuyerID = u2.UserID WHERE downloads.IsAttachmentDownloaded = 1 AND downloads.IsActive=1".$filterQuery;
$record_query = mysqli_query($connection,$query);
$record1 = mysqli_fetch_array($record_query);
$totalRecordwithFilter = $record1['allcount'];


while($row = mysqli_fetch_array($downloaded_notes_query)){
    $sr_no = ++$count;
    $downloaded_date = strtotime($row['AttachmentDownloadedDate']);
    $downloaded_date = date('d-m-Y, H:i',$downloaded_date);//change date format according to user interface

    // fetch name of Approver
    $query = "SELECT Category FROM categorytable WHERE CategoryID = ".$row['CategoryID']." AND IsActive = 1";
    $category_get_query = mysqli_query($connection,$query);
    if(!$category_get_query ) {
        die("QUERY FAILED ." . mysqli_error($connection));   
    }
    $row2 = mysqli_fetch_array($category_get_query);
    $category = $row2['Category'];

    // Set value of Selltype
    if($row['SellType'] == 0){
        $SellType = 'Free';
    }
    else{
        $SellType = 'Paid';
    }

    // array of all data
    $data[] = array( 
        "sr_no"=>$sr_no,
        "NoteID"=>$row['NoteID'],
        "NoteTitle"=>$row['NoteTitle'],
        "Category"=>$category,
        "SellType"=>$SellType,
        "NotePrice"=>'$'.$row['NotePrice'],
        "Seller"=>$row['SellerFname'].' '.$row['SellerLname'],
        "SellerID"=>$row['SellerID'],
        "Buyer"=>$row['BuyerFname'].' '.$row['BuyerLname'],
        "BuyerID"=>$row['BuyerID'],
        "AttachmentDownloadedDate"=>$downloaded_date,
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