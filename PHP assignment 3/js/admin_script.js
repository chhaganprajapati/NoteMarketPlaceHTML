/* ===================================
              Datatable
=================================== */
$(function(){

  
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
      "dom": "lrtp", 
      "columnDefs":[
        {
          sortable :false,
          targets : -1,
        }
      ]     
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