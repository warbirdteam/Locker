<?php
//##### LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Faction Lookup';
include('includes/header.php');
?>



<?php
include('includes/navbar-logged.php');
?>

<?php
if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}

if ($_SESSION['roleValue'] <= 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}
?>

<?php
if (isset($_SESSION['error'])) {
	echo '<div class="alert alert-danger my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['error'].'</div>';
	unset($_SESSION['error']);
}
?>
<?php
if (isset($_SESSION['success'])) {
	echo '<div class="alert alert-success alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['success'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
	unset($_SESSION['success']);
}
?>
<div class="container-fluid">

	<div class="row">
		<div class="col pt-3 mx-auto">
			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Faction Lookup</h5>
				<div class="card-body">

          <div class="card-box mx-3">
                <h4 class="header-title mb-3">Faction Lookup History</h4>


                            <div class="accordion" id="factionLookupAccordion">
                              <?php
                              $db_faction_lookups = new db_request();
                        			$rows = $db_faction_lookups->getAllFactionLookups();
                        			$count = $db_faction_lookups->row_count;

                              $uniquefactions = array();
                              foreach ($rows as $lookups) {

                                if (array_key_exists($lookups['faction_id'], $uniquefactions)) {
                                  $uniquefactions[$lookups['faction_id']]['lookups'][$lookups['lookup_id']] = $lookups;
                                } else {
                                  $uniquefactions[$lookups['faction_id']]['faction_id'] = $lookups['faction_id'];
                                  $uniquefactions[$lookups['faction_id']]['faction_name'] = $lookups['faction_name'];
                                  $uniquefactions[$lookups['faction_id']]['respect'] = $lookups['respect'];
                                  $uniquefactions[$lookups['faction_id']]['lookups'][$lookups['lookup_id']] = $lookups;
                                }

                              }
                              foreach ($uniquefactions as $fid => $lookup) {
                              ?>
                              <div class="card mb-2 border-bottom">
                                <a class="list-group-item list-group-item-action border-0 bg-secondary-light" data-bs-toggle="collapse" data-target="#fid_<?php echo $fid;?>">
                                  <?php echo $lookup['faction_name'] . " [" . $lookup['faction_id'] . "]";?>
                                  </a>
                                  <div id="fid_<?php echo $fid;?>" class="collapse" data-parent="#factionLookupAccordion">
                                    <ul class="list-group">

                                      <?php
                                        foreach ($lookup['lookups'] as $lookup_id => $lookup_info) {
                                      ?>

                                      <li class="list-group-item border-left-0 border-right-0 rounded-0"><a href="" class="float-left" data-bs-toggle="collapse" data-target="#lookup_id_<?php echo $lookup_id;?>"><?php echo "Report: [" . $lookup_id . "] - " . $lookup_info['timestamp'];?></a><a class="float-right" data-bs-toggle="collapse" data-target="#lookup_id_<?php echo $lookup_id;?>"><i class="fas fa-chevron-down"></i></a></li>

                                      <div class="card-body collapse" id="lookup_id_<?php echo $lookup_id;?>">

                                        <ul class="list-group list-group-horizontal-sm mb-2">
                                          <li class="list-group-item"><span><b><a href="https://www.torn.com/factions.php?step=profile&ID=<?php echo $lookup_info['faction_id'];?>" target="_blank"><?php echo $lookup['faction_name'];?></a></b></span></li>
                                          <li class="list-group-item"><span>Respect: <b><?php echo number_format($lookup_info['respect']); ?></b></span></li>
                                          <li class="list-group-item"><span>Leader: <b><a href="https://www.torn.com/profiles.php?XID=<?php echo $lookup_info['leader']; ?>" target="_blank"><?php echo $lookup_info['leader']; ?></a></b></span></li>
                                          <li class="list-group-item"><span>Co-Leader: <b><a href="https://www.torn.com/profiles.php?XID=<?php echo $lookup_info['co_leader']; ?>" target="_blank"><?php echo $lookup_info['co_leader']; ?></a></b></span></li>
                                          <li class="list-group-item"><span>Total Members: <b><?php echo number_format($lookup_info['total_members']); ?></b></span></li>
                                          <li class="list-group-item"><span>Age: <b><?php echo number_format($lookup_info['age']); ?></b></span></li>
                                          <li class="list-group-item"><span>Best Chain: <b><?php echo number_format($lookup_info['best_chain']); ?></b></span></li>
                                        </ul>







                                        <div class="table-responsive">
                                        <table class="faction_lookup_table table table-hover table-striped table-fit table-sm" border=1>

                                          <thead class="thead-dark">
                                            <tr>
                                              <th scope="col" class="text-truncate">Name</th>
                                              <th scope="col" class="text-truncate">Level</th>
                                              <th scope="col" class="text-truncate" data-bs-toggle="tooltip" data-placement="top" title="Days in current faction">DiF</th>
                                              <th scope="col" class="text-truncate">Donator</th>
                                              <th scope="col" class="text-truncate">Xanax</th>
                                              <th scope="col" class="text-truncate">Attacks Won</th>
                                              <th scope="col" class="text-truncate">Defends Won</th>
                                              <th scope="col" class="text-truncate">Property</th>
                                              <th scope="col" class="text-truncate">Energy Rx</th>
                                              <th scope="col" class="text-truncate">Nerve Rx</th>
                                              <th scope="col" class="text-truncate">Boosters</th>
                                              <th scope="col" class="text-truncate">Cans</th>
                                              <th scope="col" class="text-truncate">SEs</th>
                                              <th scope="col" class="text-truncate">Enemies</th>
                                              <th scope="col" class="text-truncate">Last Action</th>
                                            </tr>
                                          </thead>

                                        <tbody>

                                          <?php

                                          $db_user_in_lookup = new db_request();
                                    			$rows = $db_user_in_lookup->getUsersInLookup($lookup_id);
                                    			$count = $db_user_in_lookup->row_count;

                                          if ($count > 0) {
                                            foreach ($rows as $key => $member) {
                                              $title = round((time() - $member['last_action'])/60/60);
                                							$title .= ' hours ago';

                                              echo '<tr role="row"><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $member['userid'] . '" target="_blank">' . $member['username'] . ' [' . $member['userid'] . ']</a></td><td>' . $member['level'] . '</td><td>' . $member['days_in_faction'] . '</td><td>' . $member['donator_status'] . '</td><td>' . $member['xanax'] . '</td><td>' . $member['attackswon'] . '</td><td>' . $member['defendswon'] . '</td><td>' . $member['property'] . '</td><td>' . $member['energy_refills'] . '</td><td>' . $member['nerve_refills'] . '</td><td>' . $member['boosters'] . '</td><td>' . $member['cans'] . '</td><td>' . $member['stat_enhancers'] . '</td><td>' . $member['enemies'] . '</td><td data-bs-toggle="tooltip" data-placement="left" title="'.$title.'">' . date('m-d-Y H:i:s',$member['last_action']) . '</td>';

                                            }

                                          } else {
                                    				echo '<tr><td colspan=15 align=center>No members found...</td></tr>';
                                    			}
                                          ?>
                                        </tbody>

                                       </table>
                                       </div>


                                      </div>

                                      <?php } ?>


                                    </ul>

                                  </div>
                                  </div> <!-- card -->
                              <?php
                            } //foreach unique
                              ?>



                            </div> <!-- accordion -->







      </div>








</div> <!-- card-body -->
</div> <!-- card -->

<div class="card border border-dark shadow rounded mt-4">
  <div class="card-body">

    <label for="flookup"><u>Lookup information on faction:</u></label>
    <form method="post" id="lookup-form" action="process/lookup.php">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">Faction ID:</span>
        </div>
        <input type="text" class="form-control col-md-3 col-xl-2" id="fidlookup_input" name="fidlookup" required>
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit" id="fidlookup_button"><i class="fas fa-search"></i> Lookup</button>
        </div>
      </div>
      <span id="fidlookup_warning" hidden><b>Please wait, this may take several minutes...</b></span>
    </form>

  </div>
</div>


</div> <!-- col -->
</div> <!-- row -->


</div> <!-- container -->
<script src="js/faction-lookup.js"></script>
<?php
include('includes/footer.php');
?>
