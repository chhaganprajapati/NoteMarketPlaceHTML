/* ===================================
              Datatable
=================================== */
$(function(){

    // published notes table
    dTable_progress = $('#published-notes-table').DataTable({
      "scrollX":true,
      "bLengthChange": false, // this gives option for changing the number of records shown in the UI table
      "lengthMenu": [5], 
      "dom": "lrtp" 
    });
  
    $('#published-search-btn').on("click",function() {
      dTable_progress.search($("#published-search").val()).draw(); // this  is for customized searchbox with datatable search feature.
    });
  
    // manage admin table
    dTable_admin = $('#manage-admin-table').DataTable({
      "scrollX":true,
      "bLengthChange": false, 
      "lengthMenu": [5], 
      "dom": "lrtp" 
    });
  
    $('#admin-search-btn').on("click",function() {
      dTable_admin.search($("#admin-search").val()).draw(); 
    });

    // manage category table
    dTable_category = $('#manage-category-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#category-search-btn').on("click",function() {
      dTable_category.search($("#category-search").val()).draw();
    });

    // manage country table
    dTable_country = $('#manage-country-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#country-search-btn').on("click",function() {
      dTable_country.search($("#country-search").val()).draw();
    });

    // manage type table
    dTable_type = $('#manage-type-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#type-search-btn').on("click",function() {
      dTable_type.search($("#type-search").val()).draw();
    });

    // member table
    dTable_member = $('#member-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#member-search-btn').on("click",function() {
      dTable_member.search($("#member-search").val()).draw();
    });

    // member note table
    dTable_member_note = $('#members-notes-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });

    // member table
    dTable_spam = $('#spam-report-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#spam-search-btn').on("click",function() {
      dTable_spam.search($("#spam-search").val()).draw();
    });

    // notes under review table
    dTable_review = $('#notes-u-review-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#review-search-btn').on("click",function() {
      dTable_review.search($("#review-search").val()).draw();
    });
  
    // publidhes notes-2 table
    dTable_publish = $('#published-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#publish-search-btn').on("click",function() {
      dTable_publish.search($("#publish-search").val()).draw();
    });
  
    // Downloaded notes table
    dTable_publish = $('#downloaded-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#downloaded-search-btn').on("click",function() {
      dTable_publish.search($("#downloaded-search").val()).draw();
    });
  
     // Downloaded notes table
     dTable_rejected = $('#rejected-table').DataTable({
      "scrollX":true,
      "bLengthChange": false,
      "lengthMenu": [5],
      "dom": "lrtp" 
    });
  
    $('#rejected-search-btn').on("click",function() {
      dTable_rejected.search($("#rejected-search").val()).draw();
    });
  
});

/* ===================================
        input file trigger 
=================================== */
$("#upload-picture").click(function () {
    $("#picture").trigger('click');
});

$("#default-image").click(function () {
  $("#default-image-file").trigger('click');
});

$("#default-picture").click(function () {
  $("#default-picture-file").trigger('click');
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