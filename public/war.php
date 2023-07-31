<?php
//##### GUEST & MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'War'; //Add whatever title you wish here. This will be displayed in the tab of your browser
include('includes/header.php'); //required to include basic bootstrap and javascript files
include('includes/navbar-logged.php');

if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
	//##### LEADERSHIP & ADMIN ONLY PAGE
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
	exit;
}


$db_request = new db_request();
$revivesToggle = $db_request->getToggleStatusByName('revives');
$assistsToggle = $db_request->getToggleStatusByName('assists');
$akwarsToggle = $db_request->getToggleStatusByName('akwars');
$assist_apiToggle = $db_request->getToggleStatusByName('assist_api');

$db_request_enemy_factions = new db_request();
$factions = $db_request_enemy_factions->getAllEnemyFactions();

$db_request_friendly_factions = new db_request();
$friendlyFactions = $db_request_friendly_factions->getAllFriendlyFactions();
?>

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
        <h5 class="card-header">War Settings</h5>
        <div class="card-body">
					<div class="row ml-3">
	          <form id="toggleSettings">
	            <div class="form-check form-switch">
	              <input type="checkbox" class="form-check-input toggles" id="assistsToggle" name="assists" <?php if ($assistsToggle && $assistsToggle == 1) {echo ' value="1" checked';} else { echo ' value="0"';};?>>
	              <label class="form-check-label" for="assistsToggle" data-bs-toggle="tooltip" data-bs-placement="right" title="Enable this to enable the assist bot/script. Used for acts of war.">Assist Bot</label>
	            </div>

              <div class="form-check form-switch">
	              <input type="checkbox" class="form-check-input toggles" id="revivesToggle" name="revives" <?php if ($revivesToggle && $revivesToggle == 1) {echo ' value="1" checked';} else { echo ' value="0"';};?>>
	              <label class="form-check-label" for="revivesToggle" data-bs-toggle="tooltip" data-bs-placement="right" title="Enable this to enable the revive bot/script.">Revive Bot</label>
	            </div>

							<div class="form-check form-switch">
								<input type="checkbox" class="form-check-input toggles" id="akwarsToggle" name="akwars" <?php if ($akwarsToggle && $akwarsToggle == 1) {echo ' value="1" checked';} else { echo ' value="0"';};?>>
								<label class="form-check-label" for="akwarsToggle" data-bs-toggle="tooltip" data-bs-placement="right" title="Enable this to set war status to teamed war. Allows Allies to use war scripts.">Team War</label>
							</div>
		<div class="form-check form-switch">
	              <input type="checkbox" class="form-check-input toggles" id="assist_apiToggle" name="assist_api" <?php if ($assist_apiToggle && $assist_apiToggle == 1) {echo ' value="1" checked';} else { echo ' value="0"';};?>>
	              <label class="form-check-label" for="assist_apiToggle" data-bs-toggle="tooltip" data-bs-placement="right" title="Require API authentication for the assist/revive script.">API Verify</label>
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

            foreach((array) $factions as $faction) {
              echo '<li data-faction="'. $faction['factionID'] .'" data-name="' . $faction['factionName'] . '" class="list-group-item"><a href="https://www.torn.com/factions.php?step=profile&ID='. $faction['factionID'] . '#/" target="_blank">'. $faction['factionName'] .' ['. $faction['factionID'] .']</a><button type="button" class="btn-close removeFaction" data-bs-toggle="modal" data-bs-target="#removeFactionModal" aria-label="Close"></button></li>';
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
		  <form method="post" id="fidFriendly-form" action="process/refreshEnemies.php">
						<button class="btn btn-outline-secondary" type="submit" id="EnemyRefresh_button"><i class="fas fa-sync-alt"></i> Refresh Enemies</button>
		  </form>
        </div>
      </div>
    </div> <!-- col -->
  </div> <!-- row -->

	<div class="row">
		<div class="col-xl-10 col-lg-10 col-md-12 pt-3 mx-auto">
			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Friendly Factions</h5>
				<div class="card-body">
					<p>The members in these factions are allowed to use the war script. Add or delete factions below.</p>
					<ul class="list-group">
						<?php

						foreach((array) $friendlyFactions as $friendlyfaction) {
								echo '<li data-faction="'. $friendlyfaction['factionID'] .'" data-name="' . $friendlyfaction['factionName'] . '" class="list-group-item"><a href="https://www.torn.com/factions.php?step=profile&ID='. $friendlyfaction['factionID'] . '#/" target="_blank">'. $friendlyfaction['factionName'] .' ['. $friendlyfaction['factionID'] .']</a><button type="button" class="btn-close removeFriendlyFaction" data-bs-toggle="modal" data-bs-target="#removeFriendlyFactionModal" aria-label="Close"></button></li>';
						}

						?>
					</ul>
					<br>
					<label><u>Add a friendly faction:</u></label>
					<form method="post" id="fidFriendly-form" action="process/addFriendlyFaction.php">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Faction ID:</span>
							</div>
							<input type="text" class="form-control col-md-3 col-xl-2" id="fidFriendlyInput" name="fidFriendly" required>
							<div class="input-group-append">
								<button class="btn btn-outline-secondary" type="submit" id="fidFriendly_button"><i class="fas fa-peace"></i> Add Faction</button>
							</div>
						</div>
					</form>
					<form method="post" id="fidFriendly-form" action="process/refreshFriendlies.php">
						<button class="btn btn-outline-secondary" type="submit" id="FriendlyRefresh_button"><i class="fas fa-sync-alt"></i> Refresh Friends</button>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        You are about to remove the faction <b><span id="enemyFactionSpan">NULL</span></b> from the enemy list.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<form method="post" id="removeEnemy-form" action="process/removeEnemyFaction.php">
					<input type="text" id="removeEnemyInput" name="enemyRemove" value="" required hidden>
        	<button class="btn btn-primary" type="submit" id="removeEnemy_button">Remove Enemy Faction</button>
				</form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="removeFriendlyFactionModal" tabindex="-1" aria-labelledby="removeFriendlyFactionModal" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="removeFriendlyFactionModalLabel">Remove Friendly Faction</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			You are about to remove the faction <b><span id="friendlyFactionSpan">NULL</span></b> from the friendly list.
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<form method="post" id="removeFriendly-form" action="process/removeFriendlyFaction.php">
				<input type="text" id="removeFriendlyInput" name="friendlyRemove" value="" required hidden>
				<button class="btn btn-primary" type="submit" id="removeFriendly_button">Remove Friendly Faction</button>
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
