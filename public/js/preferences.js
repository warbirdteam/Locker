$(function () {

  $('input#shareAPIswitch').change(function() {
      if(this.checked) {
        $(this).val("1");
      } else {
        $(this).val("0");
      }
  });

  $('button#savePreferencesButton').click(function() {
    savePreferences();
  });


function savePreferences() {
  var gets = $("form :input").serialize();

  $.ajax({
  method: "POST",
  url: "process/savepreferences.php",
  data: gets
  })
  .fail(function() {
    $('div#maincontainer').prepend('<div class="alert alert-danger alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">Preferences failed to save.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
  })
  .done(function(response) {
    $('div#maincontainer').prepend('<div class="alert alert-success alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">Preferences saved successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
  });
}

});
