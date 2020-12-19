$(function () {


  $('tr > td > select').change(function() {
    var siteID = $(this).parent().parent().data('siteid');
    var role = $(this).val();

    saveRole(siteID, role);
  });

function saveRole(siteID, role) {
  var gets = 'siteID=' + encodeURIComponent(siteID) + '&role=' + encodeURIComponent(role);

  $.ajax({
  method: "POST",
  url: "process/saveuserlist.php",
  data: gets
  })
}

});
