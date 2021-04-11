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
    "dom": "lrtp",
    "order": [ 0, "desc" ]  
  });

  $('#progress-search-btn').on("click",function() {
    dTable_progress.search($("#progress-search").val()).draw(); // this  is for customized searchbox with datatable search feature.
  });

  // Published notes table
  dTable_published = $('#published-table').DataTable({
    "scrollX":true,
    "bLengthChange": false, 
    "lengthMenu": [5], 
    "dom": "lrtp",
    "order": [ 0, "desc" ] 
  });

  $('#published-search-btn').on("click",function() {
    dTable_published.search($("#published-search").val()).draw(); 
  });

  // my downloads table
  dTable_downloads = $('#my-downloads-table').DataTable({
    "scrollX":true,
    "bLengthChange": false, 
    "lengthMenu": [10], 
    "dom": "lrtp",
    "columnDefs":[
      {
        sortable :false,
        targets : -1,
      }
    ]  
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
    "dom": "lrtp",
    "columnDefs":[
      {
        sortable :false,
        targets : -1,
      }
    ]  
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