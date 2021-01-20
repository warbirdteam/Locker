<?php
//##### GUEST & MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'War'; //Add whatever title you wish here. This will be displayed in the tab of your browser
include('includes/header.php'); //required to include basic bootstrap and javascript files
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

if (empty($_SESSION['siteID'])) {
  $_SESSION = array();
  $_SESSION['error'] = "You are no longer logged in.";
  header("Location: /index.php");
}

$db_request = new db_request();
$revivesToggle = $db_request->getToggleStatusByName('revives');
$assistsToggle = $db_request->getToggleStatusByName('assists');

$db_request_enemy_factions = new db_request();
$factions = $db_request_enemy_factions->getAllEnemyFactions();
?>

<?php
if (isset($_SESSION['error'])) {
	echo '<div class="alert alert-danger my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['error'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	unset($_SESSION['error']);
}
?>
<?php
if (isset($_SESSION['success'])) {
	echo '<div class="alert alert-success alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['success'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	unset($_SESSION['success']);
}
?>

<div class="container" id="maincontainer">

  <div class="row">
    <div class="col-xl-10 col-lg-10 col-md-12 pt-3 mx-auto">
      <div class="card border border-dark shadow rounded mt-4">
        <h5 class="card-header">War Settings</h5>
        <div class="card-body">
					<div class="row ml-3">
	          <form id="toggleSettings">
	            <div class="custom-control custom-switch">
	              <input type="checkbox" class="custom-control-input toggles" id="assistsToggle" name="assists" <?php if ($assistsToggle && $assistsToggle == 1) {echo ' value="1" checked';} else { echo ' value="0"';};?>>
	              <label class="custom-control-label" for="assistsToggle">Assist Bot</label> <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Enable this to enable the assist bot/script. Used for acts of war."></i>
	            </div>

              <div class="custom-control custom-switch">
	              <input type="checkbox" class="custom-control-input toggles" id="revivesToggle" name="revives" <?php if ($revivesToggle && $revivesToggle == 1) {echo ' value="1" checked';} else { echo ' value="0"';};?>>
	              <label class="custom-control-label" for="revivesToggle">Revive Bot</label> <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Enable this to enable the revive bot/script."></i>
	            </div>
	          </form>
					</div>
					<div class="row">
						<div class="col-12 text-center mt-4">
							<button class="btn btn-primary" id="saveSettingsButton">Save Settings</button>
						</div>
					</div>
        </div>
      </div>
    </div> <!-- col -->
  </div> <!-- row -->

  <div class="row">
    <div class="col-xl-10 col-lg-10 col-md-12 pt-3 mx-auto">
      <div class="card border border-dark shadow rounded mt-4">
        <h5 class="card-header">Enemy Factions</h5>
        <div class="card-body">
          <p>The members in these factions are the only ones allowed to be pingable for assists. Add or delete factions below.</p>
          <ul class="list-group">
            <?php

            foreach($factions as $faction) {
              echo '<li data-faction="'. $faction['factionID'] .'" data-name="' . $faction['factionName'] . '" class="list-group-item"><a href="https://www.torn.com/factions.php?step=profile&ID='. $faction['factionID'] . '#/" target="_blank">'. $faction['factionName'] .' ['. $faction['factionID'] .']</a><button type="button" class="close removeFaction" data-toggle="modal" data-target="#removeFactionModal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>';
            }

            ?>
          </ul>
          <br>
          <label><u>Add an enemy faction:</u></label>
          <form method="post" id="fidEnemy-form" action="process/addEnemyFaction.php">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Faction ID:</span>
              </div>
              <input type="text" class="form-control col-md-3 col-xl-2" id="fidEnemyInput" name="fidEnemy" required>
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="fidEnemy_button"><i class="fas fa-skull-crossbones"></i> Add Faction</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div> <!-- col -->
  </div> <!-- row -->

  <!-- Modal -->
<div class="modal fade" id="removeFactionModal" tabindex="-1" aria-labelledby="removeFactionModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="removeFactionModalLabel">Remove Enemy Faction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        You are about to remove the faction <b><span id="enemyFactionSpan">NULL</span></b> from the enemy list.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<form method="post" id="removeEnemy-form" action="process/removeEnemyFaction.php">
					<input type="text" id="removeEnemyInput" name="enemyRemove" value="" required hidden>
        	<button class="btn btn-primary" type="submit" id="removeEnemy_button">Remove Enemy Faction</button>
				</form>
      </div>
    </div>
  </div>
</div>



</div> <!-- container -->


<script type="text/javascript" src="js/war.js"></script>
<?php
include('includes/footer.php');
?>
