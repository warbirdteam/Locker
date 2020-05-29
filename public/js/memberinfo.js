$(function () {

  $('a.nav-link').click(function() {

    let faction = $(this).data("fid");
    let time = $(this).data("timeline");

    if ($("#table_" + faction + '_'  + time).length) {

    }
    else {

      $.ajax({
        method: "POST",
        url: "process/getMemberInfo.php",
        data: { fid: $(this).data("fid"), timeline: $(this).data("timeline") }
      })

      .done(function( data ) {
        $('#' + time + '-' + faction + ' > div.table-responsive').html(data);
        $('[data-toggle="tooltip"]').tooltip();


        $("table").tablesorter({
          theme: 'bootstrap',
          sortInitialOrder: "desc",
          widthFixed: false,
          emptyTo: 'top',
          sortList: [
            [4, 1]
          ],
          widgets : ["columns", "indexFirstColumn"],

          widgetOptions : {
            columns: [ "primary", "secondary", "tertiary" ],
          }
        });


      });

    }

  });


});
