<nav class="navbar fixed-top navbar-expand-lg box white-nav-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
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
                    <?php if(isset($_SESSION['user_id'])){ ?>
                        <li><a href="search_notes.php" class="link <?php echo isset($search_notes)?'active':''?>">Search Notes</a></li>
                        <li><a href="dashboard.php" class="link <?php echo isset($sell_notes)?'active':''?>">Sell Your Notes</a></li>
                        <li><a href="buyer_requests.php" class="link <?php echo isset($buyer_request)?'active':''?>">Buyer Requests</a></li>
                        <li><a href="FAQ.php" class="link <?php echo isset($faq)?'active':''?>">FAQ</a></li>
                        <li><a href="contact_us.php" class="link <?php echo isset($contact_us)?'active':''?>">Contact Us</a></li>
                        <li class="dropdown">
                        <a class="dropbtn">
                                <img src=<?php echo $profile_image_nav;?> alt="progile image">
                                </a>
                                <div class="dropdown-content">
                                    <a href="user_profile.php">My Profile</a>
                                    <a href="my_downloads.php">My Downloads</a>
                                    <a href="my_sold_notes.php">My Sold Notes</a>
                                    <a href="my_rejected_notes.php">My Rejected Notes</a>
                                    <a href="../change_password.php">Change Password</a>
                                    <a href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                                </div>
                        </li>
                        <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
                    <?php }
                    else{ ?>
                        <li><a href="search_notes.php" class="link <?php echo isset($search_notes)?'active':''?>">Search Notes</a></li>
                        <li><a href="../login.php" class="link">Sell Your Notes</a></li>
                        <li><a href="FAQ.php" class="link <?php echo isset($faq)?'active':''?>">FAQ</a></li>
                        <li><a href="contact_us.php" class="link <?php echo isset($contact_us)?'active':''?>">Contact Us</a></li>
                        <li style="padding-right:0;"><a href="../login.php" style="border: none;"><button>Login</button></a></li>
                    <?php }
                    ?>
                </ul>
            </div>
        </div>
        <!-- Mobile Nav menu bar Ends-->

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav ml-auto">
            <?php if(isset($_SESSION['user_id'])){ ?>
                    <li><a href="search_notes.php" class="<?php echo isset($search_notes)?'active':''?>">Search Notes</a></li>
                    <li><a href="dashboard.php" class="<?php echo isset($sell_notes)?'active':''?>">Sell Your Notes</a></li>
                    <li><a href="buyer_requests.php" class="<?php echo isset($buyer_request)?'active':''?>">Buyer Requests</a></li>
                    <li><a href="FAQ.php" class="<?php echo isset($faq)?'active':''?>">FAQ</a></li>
                    <li><a href="contact_us.php" class="<?php echo isset($contact_us)?'active':''?>">Contact Us</a></li>
                    <li class="dropdown">
                        <a href="#" style="border: none;" class="dropdown-toggle" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src=<?php echo $profile_image_nav;?> alt="progile image"></a>
                        
                        <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                            <a class="dropdown-item" href="user_profile.php">My Profile</a>
                            <a class="dropdown-item" href="my_downloads.php">My Downloads</a>
                            <a class="dropdown-item" href="my_sold_notes.php">My Sold Notes</a>
                            <a class="dropdown-item" href="my_rejected_notes.php">My Rejected Notes</a>
                            <a class="dropdown-item" href="../change_password.php">Change Password</a>
                            <a class="dropdown-item" href="../logout.php" style="color:#6255a5;">LOGOUT</a>
                        </div>
                    </li>
                    <li style="padding-right:0;"><a href="../logout.php" style="border: none;"><button>Logout</button></a></li>
            <?php }
                else{ ?>
                    <li><a href="search_notes.php" class="<?php echo isset($search_notes)?'active':''?>">Search Notes</a></li>
                    <li><a href="../login.php">Sell Your Notes</a></li>
                    <li><a href="FAQ.php" class="<?php echo isset($faq)?'active':''?>">FAQ</a></li>
                    <li><a href="contact_us.php" class="<?php echo isset($contact_us)?'active':''?>">Contact Us</a></li>
                    <li style="padding-right:0;"><a href="../login.php" style="border: none;"><button>Login</button></a></li>
            <?php }
                ?>
            </ul>
        </div>   
    </div>
</nav>