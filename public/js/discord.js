$(function () {

  $('#commands > li > input[type="checkbox"]').change(function() {
    let commandID = $(this).data('commandid');
    let enabled = 0;
    if (this.checked) {
      enabled = 1;
    }
    toggleCommand(commandID, enabled);
  });

  $('#nav-tabContent > .tab-pane').each(function() {
    let commandID = $(this).data('commandid');
    $(this).find('ul.roles > li > input[type="checkbox"]').change(function() {
      let roleID = $(this).val();
      let enabled = 0;
      if (this.checked) {
        enabled = 1;
      }
      toggleRole(commandID, roleID, enabled);
    });
  });

  $('#nav-tabContent > .tab-pane').each(function() {
    let commandID = $(this).data('commandid');
    $(this).find('ul.channels > li > input[type="checkbox"]').change(function() {
      let channelID = $(this).val();
      let enabled = 0;
      if (this.checked) {
        enabled = 1;
      }
      toggleChannel(commandID, channelID, enabled);
    });
  });

});

function toggleCommand(commandID, enabled) {
  var gets = 'commandID=' + encodeURIComponent(commandID) + '&enabled=' + encodeURIComponent(enabled);

  $.ajax({
  method: "POST",
  url: "process/discord.php",
  data: gets
  })
}

function toggleRole(commandID, roleID, enabled) {
  var gets = 'commandID=' + encodeURIComponent(commandID) + '&roleID=' + encodeURIComponent(roleID) + '&enabled=' + encodeURIComponent(enabled);

  $.ajax({
  method: "POST",
  url: "process/discord.php",
  data: gets
  })
}

function toggleChannel(commandID, channelID, enabled) {
  var gets = 'commandID=' + encodeURIComponent(commandID) + '&channelID=' + encodeURIComponent(channelID) + '&enabled=' + encodeURIComponent(enabled);

  $.ajax({
  method: "POST",
  url: "process/discord.php",
  data: gets
  })
}
