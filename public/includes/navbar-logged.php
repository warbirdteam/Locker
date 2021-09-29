<?php
//If cannot find site ID, empty session array and send to login page with error message
if(!isset($_SESSION['siteID'])){
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	exit;
}
// Load classes
include_once(__DIR__ . "/../../includes/autoloader.inc.php");
//put site user info from database
$db_request = new db_request();
$site = $db_request->getSiteUserByTornID($_SESSION['userid']);
if (empty($site)) { $error = new Error_Message("You are no longer logged in.","../index.php"); exit; }

//if site user/siterole doesnt exist or is set to none, logout
if (empty($site['siteRole']) || $site['siteRole'] == "none") {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	exit;
} else {
	$_SESSION['role'] = $site['siteRole'];
}
?>


</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark d-flex">
		<div class="container-fluid mx-3">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMobileDropdown" aria-controls="navMobileDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<ul class="navbar-nav mr-auto d-none d-md-block">
				<li class="nav-item active">
					<a class="nav-item nav-link" href="welcome.php">Warbirds</a>
				</li>
			</ul>

			<div class="collapse navbar-collapse" id="navMobileDropdown">

					<ul class="navbar-nav mr-3">
						<?php
						switch ($_SESSION['role']) {
							case 'admin':
							include('includes/navbar-admin.php');
							break;
							case 'leadership':
							include('includes/navbar-leadership.php');
							break;
							case 'member':
							include('includes/navbar-member.php');
							break;
							case 'guest':
							include('includes/navbar-guest.php');
							break;
							default:
							$_SESSION = array();
							$_SESSION['error'] = "You are no longer logged in.";
							header("Location: /index.php");
							exit;
							break;
						}
						 ?>
					</ul>

			</div>
		</div>

	</nav>
