$(function () {

  if (localStorage.chkbox && localStorage.chkbox != '') {
      $('#apichkbox').attr('checked', 'checked');
      $('#apikey').val(localStorage.apikey);
  } else {
      $('#apichkbox').removeAttr('checked');
      $('#apikey').val('');
  }

  $('#apichkbox').click(function () {

      if ($('#apichkbox').is(':checked')) {
          localStorage.apikey = $('#apikey').val();
          localStorage.chkbox = $('#apichkbox').val();
      } else {
          localStorage.apikey = '';
          localStorage.chkbox = '';
      }
  });
});
