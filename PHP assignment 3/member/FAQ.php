<?php
session_start();
include '../functions.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    // Profile Image In Navigation
    $profile_image_nav = ProfileImage($user_id);
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php $title = 'FAQ';
    include 'includes/header.php';?>
    <body>

        <!--Navbar-->
        <?php $faq = 'active';
        include 'includes/navbar.php';?>
        <!--Navbar Ends-->

        <!-- Banner  -->
        <section class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Frequently Asked Questions</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner Ends -->

        <div class="box">

            <!-- General Questions -->
            <div class="question-group">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>General Questions</h2>

                            <div class="question">
                                <button class="accordion">What is Notes Marketplace?</button>
                                <div class="panel">
                                    <p>Notes Marketplace is an online marketplace for university students to buy and sell their course notes.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">Where did Notes Marketplace start?</button>
                                <div class="panel">
                                    <p>What started out as four friends chucking around an idea in Ahmedabad ended up turning into an
                                        earliest version of Notes Marketplace. So, with 2021 batch of tatvasoft – we has developed this product.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Uploaders Questions -->
            <div class="question-group">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Uploaders</h2>

                            <div class="question">
                                <button class="accordion">Why should I upload now?</button>
                                <div class="panel">
                                    <p>To maximize sales. We can't sell your notes if they are rotting on your hard drive. Your notes are
                                        available for purchase the instant they are approved, which means that you could be missing potential
                                        sales as we speak. Despite exam and holiday breaks, our users purchase notes all year round, so the best
                                        time to upload notes is always today.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">What can't I sell?</button>
                                <div class="panel">
                                    <p>We won't approve materials that have been created by your university or another third party. We also
                                        do not accept assignments, essays, practical’s or take-home exams. We love notes though.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">How long does it take to upload?</button>
                                <div class="panel">
                                    <p>Uploading notes is quick and easy. It can take as little as 90 seconds per set of notes. Put it this way, in
                                        the time it took to read these FAQs, you could’ve uploaded several sets of notes.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Downloaders Questions -->
            <div class="question-group" style="margin-bottom: 60px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Downloaders</h2>

                            <div class="question">
                                <button class="accordion">How do I buy notes?</button>
                                <div class="panel">
                                    <p>Search for the notes you are after using the 'SEARCH NOTES' tab at the at the top right of every page.
                                        You can then filter results by university, category, course information etc. To purchase, go to detail page
                                        of note and click on download button. If notes are free to download – it will download over the browser
                                        and if notes are paid, Once Seller will allow download you can have notes at my downloads grid for
                                        actual download.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">Why should I buy notes?</button>
                                <div class="panel">
                                    <p>The notes on our site are incredibly useful as an educational tool when used correctly. They effectively
                                        demonstrate the techniques that top students employ in order to receive top marks. They also
                                        summaries the course in a concise format and show what that student believed were the most
                                        important elements of the course. Learn from the best.</p>
                                </div>
                            </div>

                            <div class="question">
                                <button class="accordion">Will downloading notes guarantee I improve my grades?</button>
                                <div class="panel">
                                    <p>How long is a piece of string? However, 90% of students who purchased notes through our site said that
                                        doing so improved their grades.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- footer include -->
        <?php include 'includes/footer.php'; ?>
    </body>
</html>