<?php
//##### GUEST & MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Preferences'; //Add whatever title you wish here. This will be displayed in the tab of your browser
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

if ($_SESSION['roleValue'] <= 0) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}

if (empty($_SESSION['siteID'])) {
  $_SESSION = array();
  $_SESSION['error'] = "You are no longer logged in.";
  header("Location: /index.php");
}

$db_request = new db_request();
$siteUserPreferences = $db_request->getSiteUserPreferencesBySiteID($_SESSION['siteID']);

?>


<div class="container" id="maincontainer">

  <div class="row">
    <div class="col-xl-10 col-lg-10 col-md-12 pt-3 mx-auto">
      <div class="card border border-dark shadow rounded mt-4">
        <h5 class="card-header">Profile Preferences</h5>
        <div class="card-body">
					<div class="row ml-3">
	          <form>
	            <div class="custom-control custom-switch">
	              <input type="checkbox" class="custom-control-input" id="shareAPIswitch" name="share_api" <?php if ($siteUserPreferences['share_api'] && $siteUserPreferences['share_api'] == 1) {echo ' value="1" checked';} else { echo ' value="0"';};?>>
	              <label class="custom-control-label" for="shareAPIswitch">Share API key?</label> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Your API key will be used to help with faction functions such as collecting data for this website. All API keys are encrypted."></i>
	            </div>
	          </form>
					</div>
					<div class="row">
						<div class="col-12 text-center mt-4">
							<button class="btn btn-primary" id="savePreferencesButton">Save Preferences</button>
						</div>
					</div>
        </div>
      </div>
    </div> <!-- col -->
  </div> <!-- row -->



</div> <!-- container -->


<script type="text/javascript" src="js/preferences.js"></script>
<?php
include('includes/footer.php');
?>
