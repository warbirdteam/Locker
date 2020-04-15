$(function () {



  $('#fidlookup_button').click(function(e) {
    if ( !$('#fidlookup_input').val() || !$.isNumeric($('#fidlookup_input').val())) {
      e.preventDefault();
    } else {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    $("#fidlookup_warning").prop("hidden", false);
    }
  });


  });
