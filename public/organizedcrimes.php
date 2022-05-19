<?php
//##### LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Organized Crimes';
include('includes/header.php');
include('includes/navbar-logged.php');

if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
	//##### LEADERSHIP & ADMIN ONLY PAGE
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
	exit;
}
?>

<style>
span.names {font-size: 14px;}
</style>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/r-2.2.9/rg-1.1.4/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/r-2.2.9/rg-1.1.4/datatables.min.js"></script>

<?php
if (isset($_SESSION['error'])) {
	echo '<div class="alert alert-danger my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['error'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
	unset($_SESSION['error']);
}
?>
<?php
if (isset($_SESSION['success'])) {
	echo '<div class="alert alert-success alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['success'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
	unset($_SESSION['success']);
}
?>


<div class="container" id="maincontainer">

  <div class="row">
    <div class="col-xl-10 col-lg-10 col-md-12 pt-3 mx-auto">


      <div class="card border border-dark shadow rounded mt-4">
        <h5 class="card-header">Organized Crimes - PAs<a class="float-end" title="OC Settings" data-bs-toggle="modal" data-bs-target="#ocsettings"><i class="fas fa-cog"></i></a></h5>
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#f13784" type="button" role="tab" href>WarBirds</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#f35507" type="button" role="tab" href>Nest</button>
            </li>
          </ul>
        </div>
        <div class="tab-content text-center">
          <?php
          $db_request = new db_request();
          $factions = $db_request->getAllFactions();

          $pa1 = $db_request->getSiteVariableByName('pa1');
          $pa2 = $db_request->getSiteVariableByName('pa2');
          $pa3 = $db_request->getSiteVariableByName('pa3');
          $pa4 = $db_request->getSiteVariableByName('pa4');
          $pa5 = $db_request->getSiteVariableByName('pa5');

          foreach ($factions as $faction) {
            $factionCrimes = $db_request->getFactionCrimesByFactionIDAndCrimeTypeID($faction['factionID'], 8); //Get all PAs
          ?>
          <div class="tab-pane fade<?php if ($faction['factionID'] == 13784){echo " show active";} ?>" id="f<?php echo $faction['factionID']; ?>" role="tabpanel">
            <div class="card-body">
              <h5 class="card-title"><?php echo $faction['factionName']; ?></h5>
              <p class="card-text">List of Political Assassination teams</p>

              <table id="fid_<?php echo $faction['factionID'];?>_pas" data-fid="<?php echo $faction['factionID'];?>" class="paTable display" style="width:100%">
                <thead>
                    <tr>
                      <th>Select</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Team</th>
                      <th>Outcome</th>
                      <th>Money Gain</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                      if ($factionCrimes) {
                        foreach($factionCrimes as $crime) {
                          $success = "Success";
                          if ($crime['success'] == 0) {
                          $success = "Failed";
                          }
                          //Get team members for crime id
                          $crimeTeam = $db_request->getCrimeTeamByCrimeID($crime['crimeID']);
                          $teamStr = "";
                          foreach($crimeTeam as $user) {
                            //get each name or userid of team member
                            if ($user['tornName']) {
                              $teamStr .= "<span data-id='".$user['userID']."' data-pos='".$user['pos']."'>" . $user['tornName'] . "</span>, ";
                            } else {
                              $teamStr .= "[<span data-id='".$user['userID']."' data-pos='".$user['pos']."'>" . $user['userID'] . "</span>], ";
                            }
                            
                          }
                          $teamStr = rtrim($teamStr, ", ");
                  ?>
                    <tr> 
                        <td><input type="checkbox" class="paCheckbox"></td>
                        <td><?php echo date('m-d-Y', $crime['time_completed']); ?></td>
                        <td><?php echo date('H:i:s', $crime['time_completed']); ?></td>
                        <td class="team"><?php echo $teamStr; ?></td>
                        <td><?php echo $success; ?></td>
                        <td class="money" data-order="<?php echo $crime['money_gain']; ?>" data-money="<?php echo $crime['money_gain']; ?>">$<?php echo number_format($crime['money_gain']); ?></td>
                    </tr>
                  <?php
                      }
                    } else {
                      echo "<li class='list-group-item'>No Political Assassinations on file.</li>";
                    }
                  ?>
                  </tbody>
              </table> 
            </div>

            


          </div>

          <?php
          }
          ?>

        </div>


      </div>


    </div> <!-- col -->
  </div> <!-- row -->



</div> <!-- container -->

<!-- Modal settings -->
<div class="modal fade" id="ocsettings" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PA Pay Percentage</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-2">
          <span class="input-group-text">Team Lead:</span>
          <input type="text" class="form-control text-end" id="pa1" value="<?php echo $pa1; ?>">
          <span class="input-group-text">%</span>
        </div>
        <div class="input-group mb-2">
          <span class="input-group-text">#2:</span>
          <input type="text" class="form-control text-end" id="pa2" value="<?php echo $pa2; ?>">
          <span class="input-group-text">%</span>
        </div>
        <div class="input-group mb-2">
        <span class="input-group-text">#3:</span>
          <input type="text" class="form-control text-end" id="pa3" value="<?php echo $pa3; ?>">
          <span class="input-group-text">%</span>
        </div>
        <div class="input-group mb-2">
        <span class="input-group-text">#4:</span>
          <input type="text" class="form-control text-end" id="pa4" value="<?php echo $pa4; ?>">
          <span class="input-group-text">%</span>
        </div>
        <div class="input-group mb-2">
        <span class="input-group-text">Faction Cut:</span>
          <input type="text" class="form-control text-end" id="pa5" value="<?php echo $pa5; ?>">
          <span class="input-group-text">%</span>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="pasettingsSave" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="payModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Political Assassination Pay</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container d-none" id="pa-container">
  <nav class="navbar fixed-bottom navbar-expand-lg navbar-light bg-light border-top border-dark">
    <div class="container-fluid d-flex justify-content-center">
    <button id="paPayButton" type="button" class="btn btn-primary">Calculate Pay</button>
    </div>
  </nav>
</div>


<script>
    $('#paPayButton').click(function() {
      if ($(".paTable input.paCheckbox:checkbox:checked").length > 0) {

        var totPay = 0, tot1 = 0, tot2 = 0, tot3 = 0, tot4 = 0, tot5 = 0;
        var ones = {}, twos = {}, threes = {}, fours = {};
        ids = [];
        var fid;

        $(".paTable input.paCheckbox:checkbox:checked").each(function() {
          let parent = $(this).closest('tr');
          fid = parent.closest('table').attr('data-fid');
          let money = parseInt(parent.find('td.money').attr('data-money'));
          totPay += money;
          parent.find('.team span').each(function() {
            ids.push($(this).attr('data-id'));
          });

          ones[parent.find('td.team > span[data-pos="1"]').attr('data-id')] = parent.find('td.team > span[data-pos="1"]').text();
          twos[parent.find('td.team > span[data-pos="2"]').attr('data-id')] = parent.find('td.team > span[data-pos="2"]').text();
          threes[parent.find('td.team > span[data-pos="3"]').attr('data-id')] = parent.find('td.team > span[data-pos="3"]').text();
          fours[parent.find('td.team > span[data-pos="4"]').attr('data-id')] = parent.find('td.team > span[data-pos="4"]').text();
          
        });

        tot1 = totPay * (<?php echo $pa1;?> / 100);
        tot2 = totPay * (<?php echo $pa2;?> / 100);
        tot3 = totPay * (<?php echo $pa3;?> / 100);
        tot4 = totPay * (<?php echo $pa4;?> / 100);
        tot5 = totPay * (<?php echo $pa5;?> / 100);


        let gets = "fid=" + fid + '&ids=' + ids.toString();
          $.ajax({
            method: "POST",
            url: "process/ocs.php",
            data: gets
          })
          .done(function(response) {
            balances = JSON.parse(response);

            let tableStr = `<table class="table table-sm table-striped table-hover">
                  <thead>
                    <tr>
                      <th class="text-center" colspan="2">Total Pool: <b>$${totPay.toLocaleString()}</b></td>
                    </tr>
                    <tr>
                      <th scope="col">User</th>
                      <th scope="col">New Vault Balance</th>
                    </tr>
                </thead>
                <tbody>
                
                <tr>
                  <td class="text-center" colspan="2">Leads Owed: <b>$${Math.round(tot1/(Object.keys(ones).length)).toLocaleString()}</b></td>
                </tr>
                `;
                  for (const [id, name] of Object.entries(ones)) {
                    tableStr += `
                    <tr>
                      <td><a href="https://www.torn.com/profiles.php?XID=${id}" target="_blank">${name} [${id}]</a></td>
                      <td>$${(parseInt(balances[id]) + Math.round(tot1/(Object.keys(ones).length))).toLocaleString()}</td>
                    </tr>
                    `;
                  }

                  tableStr += `
                  <tr>
                  <td class="text-center" colspan="2">Twos Owed: <b>$${Math.round(tot2/(Object.keys(twos).length)).toLocaleString()}</b></td>
                  </tr>
                  `;
                  for (const [id, name] of Object.entries(twos)) {
                    tableStr += `
                    <tr>
                      <td><a href="https://www.torn.com/profiles.php?XID=${id}" target="_blank">${name} [${id}]</a></td>
                      <td>$${(parseInt(balances[id]) + Math.round(tot2/(Object.keys(twos).length))).toLocaleString()}</td>
                    </tr>
                    `;
                  }

                  tableStr += `
                  <tr>
                  <td class="text-center" colspan="2">Threes Owed: <b>$${Math.round(tot3/(Object.keys(threes).length)).toLocaleString()}</b></td>
                  </tr>
                  `;
                  for (const [id, name] of Object.entries(threes)) {
                    tableStr += `
                    <tr>
                      <td><a href="https://www.torn.com/profiles.php?XID=${id}" target="_blank">${name} [${id}]</a></td>
                      <td>$${(parseInt(balances[id]) + Math.round(tot3/(Object.keys(threes).length))).toLocaleString()}</td>
                    </tr>
                    `;
                  }

                  tableStr += `
                  <tr>
                  <td class="text-center" colspan="2">Fours Owed: <b>$${Math.round(tot4/(Object.keys(fours).length)).toLocaleString()}</b></td>
                  </tr>
                  `;
                  for (const [id, name] of Object.entries(fours)) {
                    tableStr += `
                    <tr>
                      <td><a href="https://www.torn.com/profiles.php?XID=${id}" target="_blank">${name} [${id}]</a></td>
                      <td>$${(parseInt(balances[id]) + Math.round(tot4/(Object.keys(fours).length))).toLocaleString()}</td>
                    </tr>
                    `;
                  }

                  tableStr += `</tbody></table>`;
                  
            
                  $('#payModal div.modal-body').html(tableStr);

              var payModal = new bootstrap.Modal(document.getElementById('payModal'));
              payModal.show();
          });  
      }
    });
</script>

<script type="text/javascript" src="js/ocs.js"></script>

<?php
include('includes/footer.php');
?>
