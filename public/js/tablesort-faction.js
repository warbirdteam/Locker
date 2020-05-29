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


  $("table").tablesorter({
    theme: 'bootstrap',
    sortInitialOrder: "asc",
    widthFixed: false,
    emptyTo: 'top',
    sortList: [
      [2, 0]
    ],

    // widget code contained in the jquery.tablesorter.widgets.js file
    // use the zebra stripe widget if you plan on hiding any rows (filter widget)
    // the uitheme widget is NOT REQUIRED!
    widgets : ["columns", "indexFirstColumn"],

    widgetOptions : {
      // using the default zebra striping class name, so it actually isn't included in the theme variable above
      // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden

      // class names added to columns when sorted
      columns: [ "primary", "secondary", "tertiary" ],


    }
  });

});
