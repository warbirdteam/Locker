$(function () {

  $('input.toggles').change(function() {
      if(this.checked) {
        $(this).val("1");
      } else {
        $(this).val("0");
      }
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
    $('div#maincontainer').prepend('<div class="alert alert-danger alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">Settings failed to save.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
  })
  .done(function(response) {
    $('div#maincontainer').prepend('<div class="alert alert-success alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">Settings saved successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
  });
}




$('#fidEnemy_button').click(function(e) {
  const fid = $('#fidEnemyInput').val();
  if (!fid) {
    e.preventDefault();
    return;
  }

  const pattern = /^[0-9,]*$/g;
  if (fid.match(pattern)) {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    return;
  } else {
    if (!$.isNumeric($('#fidEnemyInput').val())) {
      e.preventDefault();
    } else {
      $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    }
  }
});


$('ul > li > button.removeFaction').click(function() {
    $('input#removeEnemyInput').val($(this).parent('li').data("faction"));
    $('span#enemyFactionSpan').html($(this).parent('li').data("name") + " [" + $(this).parent('li').data("faction") + "]")
});



$('#fidFriendly_button').click(function(e) {
  const fid = $('#fidFriendlyInput').val();
  if (!fid) {
    e.preventDefault();
    return;
  }

  const pattern = /^[0-9,]*$/g;
  if (fid.match(pattern)) {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    return;
  } else {
    if (!$.isNumeric($('#fidEnemyInput').val())) {
      e.preventDefault();
    } else {
      $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    }
  }
});

$('#FriendlyRefresh_button').click(function(e) {
  $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
});

$('#EnemyRefresh_button').click(function(e) {
  $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
});


$('ul > li > button.removeFriendlyFaction').click(function() {
    console.log($(this).parent('li').data("faction"));
    $('input#removeFriendlyInput').val($(this).parent('li').data("faction"));
    $('span#friendlyFactionSpan').html($(this).parent('li').data("name") + " [" + $(this).parent('li').data("faction") + "]")
});

});
