/* ===================================
            Password hide/show
=================================== */
$(".toggle-password").click(function() {

    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

/* ===================================
            Navigation
=================================== */
/*Show and Hide white nav*/
$(function () {

  /*show/hide nav on page load*/
  showHideNav();

  $(window).scroll(function () {
      showHideNav();
  });

  function showHideNav() {

      if ($(window).scrollTop() > 50) {

          /*Show white navbar*/
          $('nav.home').addClass('white-nav-top');

          /*Change logo*/
          $('#home-logo img').attr("src", "images/home/logo.png");

      } else {

          $('nav.home').removeClass('white-nav-top');

          /*Change logo*/
          $('#home-logo img').attr("src", "images/home/top-logo.png");

      }
  }

});

/* ===================================
        Book list pagination
=================================== */
$books=19;
// To add pagination
$(function(){
  for (let index = 1; index <= Math.ceil($books/9); index++) {
    $("div#page-no").append("<a href='#' class='page' value='"+index+"'>"+index+"</a>"); 
  }  
});

$(function() {
  $(".pagination a.page[value=1]").addClass("active");
  for (let index = 10; index <= $books; index++){
    $("#notes-list-"+index).hide();
  }
  
  // Previous Button
  $("#prev").click(function(){
    $a=$(".pagination a.active").attr("value");
    if($a>1){
      $page_no=$a-1;
    }
    else{
      $page_no=$a;
    }
    pagination();
  });

  // Next Button
  $("#next").click(function(){
    
    $a=$(".pagination a.active").attr("value");
    if($a<($books/9)){
      $page_no=parseInt($a) + 1;
    }
    else{
      $page_no=$a;
    }
    pagination();
  });

  // On page number click
  $(".pagination a.page").click(function(){
    $page_no=$(this).attr("value");
    pagination();
  });

  // Pagination function
  function pagination() {
    $(".pagination a").removeClass("active");
    $(".pagination a.page[value="+$page_no+"]").addClass("active");

    $start_page_no=($page_no-1)*9+1;
    $end_page_no=$page_no*9;

    for (let index = 1; index <= $books; index++){

      if(index>=$start_page_no && index<=$end_page_no)
      {
        $("#notes-list-"+index).show();
      }
      else {
        $("#notes-list-"+index).hide();
      }
    }
  }

});

/* ===================================
        Download button
=================================== */
function Download() {
  var r = confirm("Are you sure you want to download this paid note.\nPlease confirm.");
  if (r == true) {
    $("#ThanksModal").modal();
  } 
}

/* ===================================
        input file trigger 
=================================== */
$("#upload-picture").click(function () {
  $("#picture").trigger('click');
});

$("#display-picture-icon").click(function () {
  $("#display-picture").trigger('click');
});

$("#upload-notes-icon").click(function () {
  $("#upload-notes").trigger('click');
});

$("#upload-file-icon").click(function () {
  $("#upload-file").trigger('click');
});


/* ===================================
              Datatable
=================================== */
$(function(){

  // In progress notes table
  dTable_progress = $('#in-progress-table').DataTable({
    "scrollX":true,
    "bLengthChange": false, // this gives option for changing the number of records shown in the UI table
    "lengthMenu": [5], 
    "dom": "lrtp" 
  });

  $('#progress-search-btn').on("click",function() {
    dTable_progress.search($("#progress-search").val()).draw(); // this  is for customized searchbox with datatable search feature.
  });

  // Published notes table
  dTable_published = $('#published-table').DataTable({
    "scrollX":true,
    "bLengthChange": false, 
    "lengthMenu": [5], 
    "dom": "lrtp" 
  });

  $('#published-search-btn').on("click",function() {
    dTable_published.search($("#published-search").val()).draw(); 
  });

  // my downloads table
  dTable_downloads = $('#my-downloads-table').DataTable({
    "scrollX":true,
    "bLengthChange": false, 
    "lengthMenu": [10], 
    "dom": "lrtp" 
  });

  $('#downloads-search-btn').on("click",function() {
    dTable_downloads.search($("#downloads-search").val()).draw(); 
  });

  // my sold notes table
  dTable_sold = $('#my-sold-notes-table').DataTable({
    "scrollX":true,
    "bLengthChange": false, 
    "lengthMenu": [10], 
    "dom": "lrtp" 
  });

  $('#sold-search-btn').on("click",function() {
    dTable_sold.search($("#sold-search").val()).draw(); 
  });

  // buyer request table
  dTable_buyer = $('#buyer-request-table').DataTable({
    "scrollX":true,
    "bLengthChange": false, 
    "lengthMenu": [10], 
    "dom": "lrtp" 
  });

  $('#buyer-search-btn').on("click",function() {
    dTable_buyer.search($("#buyer-search").val()).draw(); 
  });

  // Rejected notes  table
  dTable_rejected = $('#my-rejected-notes-table').DataTable({
    "scrollX":true,
    "bLengthChange": false, 
    "lengthMenu": [10], 
    "dom": "lrtp" 
  });

  $('#rejected-search-btn').on("click",function() {
    dTable_rejected.search($("#rejected-search").val()).draw(); 
  });

});

/* ===================================
            Accordion
=================================== */
$(function(){
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
        this.parentElement.style.border="none";
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        this.parentElement.style.border="1px solid #d1d1d1";
      } 
    });
  }
});

/* ===================================
            Mobile Menu
=================================== */
$(function () {

  /*Hide Mobile Nav*/
  $('#mobile-nav-close-btn, #mobile-nav a.link').click(function () {
    $(".navbar-toggler").addClass("collapsed");  
    $("#mobile-nav").removeClass("show");  
  });

});