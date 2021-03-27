<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location:../index.html");
    }
    include '../Database/database.php';
    $user_id = $_SESSION['user_id'];

    $query = "SELECT downloads.DownloadID, downloads.NoteID, downloads.NotePrice, downloads.CreatedDate, user.EmailID, notes.NoteTitle, notes.CategoryID, notes.SellType, notes.NoteFile FROM downloads JOIN user ON downloads.BuyerID=user.UserID JOIN notes ON downloads.NoteID = notes.NoteID WHERE downloads.SellerID = '$user_id' and downloads.RequestStatus = 1 and downloads.IsActive = 1 ORDER BY downloads.CreatedDate desc";
    $my_sold_query = mysqli_query($connection,$query);
    if(!$my_sold_query){
        die("QUERY FAILED".mysqli_error($connection));
    }  
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Title-->
        <title>NotesMarketPlace-My Sold Notes</title>

        <!--Meta tags-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

        <!--Favicon-->
        <link rel="icon" href="../images/favicon.ico">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!--datatable css-->
        <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">

        <!--bootstarp css-->
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">

        <!--Custom css-->
        <link rel="stylesheet" href="../css/user-style.css">

        <!--Responsive css-->
        <link rel="stylesheet" href="../css/user-responsive.css">
    </head>
    <body>

        <!--Navbar-->
        <nav class="navbar fixed-top navbar-expand-lg box white-nav-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../images/home/logo.png" alt="NotesMarketPlace logo">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-nav" aria-controls="mobile-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-icon">&#9776;</span>
                </button>

                <!-- Mobile Nav menu bar -->
                <div id="mobile-nav" class="collapse navbar-collapse">

                    <span id="mobile-nav-logo"><img src="../images/home/logo.png" alt="NotesMarketPlace logo"></span>
                    <!--Close button-->
                    <span id="mobile-nav-close-btn">&times;</span>

                    <div id="mobile-nav-content">
                        <ul class="navbar-nav">
                            <li><a href="#" class="link">Search Notes</a></li>
                            <li><a href="#" class="link">Sell Your Notes</a></li>
                            <li><a href="#" class="link">Buyer Requests</a></li>
                            <li><a href="#" class="link">FAQ</a></li>
                            <li><a href="#" class="link">Contact Us</a></li>
                            <li class="dropdown">
                                    <a class="dropbtn">
                                        <img src="../images/front/user-img.png" alt="progile image">
                                    </a>
                                    <div class="dropdown-content">
                                        <a href="#">My Profile</a>
                                        <a href="#">My Downloads</a>
                                        <a href="#">My Sold Notes</a>
                                        <a href="#">My Rejected Notes</a>
                                        <a href="#">Change Password</a>
                                        <a href="#" style="color:#6255a5;">LOGOUT</a>
                                    </div>
                            </li>
                            <li style="padding-right:0;"><a href="#" style="border: none;"><button>Logout</button></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Nav menu bar Ends-->

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ml-auto">
                      <li><a href="#">Search Notes</a></li>
                      <li><a href="#">Sell Your Notes</a></li>
                      <li><a href="#">Buyer Requests</a></li>
                      <li><a href="#">FAQ</a></li>
                      <li><a href="#">Contact Us</a></li>
                      <li class="dropdown">
                        <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/Add-notes/user-img.png" class="img-fluid" alt="progile image"></a>
                    
                        <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                            <a class="dropdown-item" href="#">My Profile</a>
                            <a class="dropdown-item" href="#">My Downloads</a>
                            <a class="dropdown-item" href="#">My Sold Notes</a>
                            <a class="dropdown-item" href="#">My Rejected Notes</a>
                            <a class="dropdown-item" href="#">Change Password</a>
                            <a class="dropdown-item" href="#" style="color:#6255a5;">LOGOUT</a>
                        </div>
                        </li>
                        <li style="padding-right:0;"><a href="#" style="border: none;"><button>Logout</button></a></li>
                    </ul>
                </div>   
            </div>
        </nav>
        <!--Navbar Ends-->

        <!-- My Sold note table -->
        <div class="profile-table box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-5 col-12">
                        <h2>My Sold Notes</h2>
                    </div>
                    <div class="col-md-6 col-sm-7 col-12 text-right">
                        <input type="text" class="search" id="sold-search" placeholder="Search">
                        <button class="search-button" id="sold-search-btn">Search</button>
                    </div>
                </div>

                <table id="my-sold-notes-table" class="datatable display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No.</th>
                            <th>Note Title</th>
                            <th>Category</th>
                            <th>Buyer</th>
                            <th>Sell Type</th>
                            <th>Price</th>
                            <th>Downloaded date/time</th>
                            <th></th>
                        </tr>
                    </thead>
        
                    <tbody>
                    <?php
                        $count = 0;
                        while($row = mysqli_fetch_array($my_sold_query)){
                            $category_id = $row['CategoryID'];

                            $query = "SELECT Category FROM categorytable WHERE CategoryID = $category_id and IsActive = 1";
                            $category_query = mysqli_query($connection, $query);
                            if(!$category_query){
                                die("QUERY FAILED".mysqli_error($connection));
                            }

                            $row1 = mysqli_fetch_array($category_query);
    
                            $category = $row1['Category'];
                            $download_id = $row['DownloadID'];
                            $note_id = $row['NoteID'];
                            $title = $row['NoteTitle'];
                            $buyer = $row['EmailID'];
                            $sell_type = $row['SellType'];
                            $note_price = $row['NotePrice'];
                            $date = $row['CreatedDate'];
                            $date = date("d M Y, H:i:s",strtotime($date));
                            $note_file = $row['NoteFile'];
                            $count++;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $count;?></td>
                            <td><?php echo $title;?></td>
                            <td><?php echo $category;?></td>
                            <td><?php echo $buyer;?></td>
                            <td><?php if($sell_type == 1){echo'Paid';}else{echo'Free';}?></td>
                            <td>$<?php echo $note_price;?></td>
                            <td><?php echo $date;?></td>
                            <td>
                                <span class="profile-table-icons">
                                <a href="notes_details.php?note=<?php echo $note_id;?>"><img src="../images/Dashboard/eye.png" alt="edit" class="view-icon"></a>
                                    <span class="dropdown">
                                        <a href="#" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/front/dots.png" alt="progile image"></a>
                                    
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
                                            <a class="dropdown-item download" href="#" notes="<?php echo $note_file;?>">Download Note</a>
                                        </div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <?php 
                        }?>
                    
                        
                        
                    </tbody>
                </table>
                
            </div>
        </div>
        <!-- My Downloads note table Ends-->
      
        <!-- Footer -->
        <footer class="box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-8">
                        <p>Copyright &copy; TatvaSOft All rigths reserved.</p>
                    </div>
                    <div class="col-md-6 col-4 text-right">
                        <ul class="social-list">
                            <li><a href="#"><img src="../images/home/facebook.png" alt="facebook icon"></a></li>
                            <li><a href="#"><img src="../images/home/twitter.png" alt="twitter icon"></a></li>
                            <li><a href="#"><img src="../images/home/linkedin.png" alt="linkedin icon"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Ends-->

        <!--JQuery-->
        <script src="../js/jquery.js"></script>

        <!--bootstarp js-->
        <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>

        <!--Datatable js-->
        <script src="../js/datatable/jquery.dataTables.min.js"></script>

        <!--Custom JS-->
        <script src="../js/script.js"></script>

        <script type="text/javascript">
        
            $(".download").click(function(){
                
                var file = $(this).attr("notes");
                
                var note = file.split('/');
                var i = 0;
                while(note[i]){
                    var a = $("<a />");
                    a.attr("download", note[i]);
                    a.attr("href", '../images/uploads/notes/'+note[i]);
                    $("notes-details-left").append(a);
                    a[0].click();
                    $("notes-details-left").remove(a);
                    i++;
                }
        
            });

        </script>
    </body>
</html>