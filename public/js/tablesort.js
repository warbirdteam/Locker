$(function() {

  $.tablesorter.addWidget({
    // give the widget a id
    id: "indexFirstColumn",
    // format is called when the on init and when a sorting has finished
    format: function(table) {
        // loop all tr elements and set the value for the first column
        for(var i=0; i < table.tBodies[0].rows.length; i++) {
            $("tbody tr:eq(" + i + ") td:first",table).html(i+1);
        }
    }
});


  $("table.faction_lookup_table").tablesorter({
    theme: 'bootstrap',
    sortInitialOrder: "asc",
    widthFixed: false,
    emptyTo: 'top',
    sortList: [
      [4, 1]
    ],
    widgets : ["columns"],
    widgetOptions : {
      columns: [ "primary", "secondary", "tertiary" ],
    }
  });

  $("table.member_info_table").tablesorter({
    theme: 'bootstrap',
    sortInitialOrder: "asc",
    widthFixed: false,
    emptyTo: 'top',
    sortList: [
      [5, 1]
    ],
    widgets : ["columns", "indexFirstColumn"],
    widgetOptions : {
      columns: [ "primary", "secondary", "tertiary" ],
    }
  });

  $("table.faction_member_table").tablesorter({
    theme: 'bootstrap',
    sortInitialOrder: "asc",
    widthFixed: false,
    emptyTo: 'top',
    sortList: [
      [3, 0]
    ],
    widgets : ["columns", "indexFirstColumn"],
    widgetOptions : {
      columns: [ "primary", "secondary", "tertiary" ],
    }
  });

});
