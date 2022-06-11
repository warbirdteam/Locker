$(document).ready(function() {
  var collapsedGroups = {};

      var table = $('.paTable').DataTable({
        pageLength: 30,
        order: [[1, 'desc']],
        rowGroup: {
          // Uses the 'row group' plugin
          dataSrc: 1,
          startRender: function (rows, group) {
              var collapsed = !!collapsedGroups[group];

              rows.nodes().each(function (r) {
                  r.style.display = collapsed ? 'none' : '';
              });    

              // Add category name to the <tr>. NOTE: Hardcoded colspan
              return $('<tr/>')
                  .append('<td colspan="6">' + group + ' (' + rows.count() + ')</td>')
                  .attr('data-name', group)
                  .toggleClass('collapsed', collapsed);
                  
          }
        }
      });

    $('.paTable tbody').on('click', 'tr.dtrg-group.dtrg-start', function () {
          var name = $(this).data('name');
          collapsedGroups[name] = !collapsedGroups[name];
          table.draw(false);
      });  
    
    $('.paCheckbox').change(function() {
      if ($(".paTable input.paCheckbox:checkbox:checked").length > 0) {
        $('#pa-container').removeClass('d-none').addClass('d-block');
      }
      else {
        $('#pa-container').addClass('d-none').removeClass('d-block');
      }
    });


    $('#pasettingsSave').click(function() {
      if ($("#pa1").val() != undefined && $("#pa2").val() != undefined && $("#pa3").val() != undefined && $("#pa4").val() != undefined && $("#pa5").val() != undefined) {
        
          let gets = 'pa1=' + encodeURIComponent($("#pa1").val()) + '&pa2=' + encodeURIComponent($("#pa2").val()) + '&pa3=' + encodeURIComponent($("#pa3").val()) + '&pa4=' + encodeURIComponent($("#pa4").val()) + '&pa5=' + encodeURIComponent($("#pa5").val());
          console.log(gets);
          $.ajax({
            method: "POST",
            url: "process/ocs.php",
            data: gets
            })
            .done(function() {
              window.location.reload();
            });  
  
      }
  });


  $(document).on('change', 'td.pay_scale input[type="radio"]', function() {
    let parent = $(this).closest('tr');
    let pay = parseInt($(this).val());
    let bal = parseInt(parent.find('td.new_bal').attr('data-bal'));

    parent.find('td.new_bal').text((bal + pay).toLocaleString());
  });

  });