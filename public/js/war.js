$(function () {

  $('input.toggles').change(function() {
    console.log($(this).val());
      if(this.checked) {
        $(this).val("1");
      } else {
        $(this).val("0");
      }
      console.log($(this).val());
  });

  $('button#saveSettingsButton').click(function() {
    saveSettings();
  });


function saveSettings() {
  var gets = $("form#toggleSettings :input").serialize();

  $.ajax({
  method: "POST",
  url: "process/saveWarSettings.php",
  data: gets
  })
  .fail(function() {
    $('div#maincontainer').prepend('<div class="alert alert-danger alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">Settings failed to save.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
  })
  .done(function(response) {
    $('div#maincontainer').prepend('<div class="alert alert-success alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">Settings saved successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
  });
}




$('#fidEnemy_button').click(function(e) {
  if ( !$('#fidEnemyInput').val() || !$.isNumeric($('#fidEnemyInput').val())) {
    e.preventDefault();
  } else {
  $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
  }
});


$('ul > li > button.removeFaction').click(function() {
    console.log($(this).parent('li').data("faction"));
    $('input#removeEnemyInput').val($(this).parent('li').data("faction"));
    $('span#enemyFactionSpan').html($(this).parent('li').data("name") + " [" + $(this).parent('li').data("faction") + "]")
});

});
