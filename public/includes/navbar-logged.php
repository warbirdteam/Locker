<?php
if(!isset($_SESSION['userid'])){
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}
// Load classes
include_once(__DIR__ . "/../../includes/autoloader.inc.php");

$db_request = new db_request();
$torn = $db_request->getTornUserByTornID($_SESSION['userid']);
$site = $db_request->getSiteUserBySiteID($torn['siteID']);

if (empty($site['siteRole'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}


$roleValue = 0;

switch ($site['siteRole']) {
	case 'admin':
	$roleValue = 4;
	break;
	case 'leadership':
	$roleValue = 3;
	break;
	case 'member':
	$roleValue = 2;
	break;
	case 'guest':
	$roleValue = 1;
	break;
	case 'register':
	$roleValue = 1;
	break;
	default:
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	break;
}

$_SESSION['roleValue'] = $roleValue;
$_SESSION['role'] = $site['siteRole'];
?>


</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
		<a class="navbar-brand pl-5" href="welcome.php">Warbirds</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMobileDropdown" aria-controls="navMobileDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>


		<div class="collapse navbar-collapse" id="navMobileDropdown">

			<div class="container d-flex justify-content-lg-end pr-5">
				<ul class="navbar-nav pr-3">
					<li class="nav-item active">
						<a class="nav-item nav-link" href="welcome.php">Home</a>
					</li>
					<?php
					if ($_SESSION['roleValue'] >= 4) {
						?>
						<li class="nav-item active dropdown">
							<a class="nav-link dropdown-toggle" href="#navAdm" id="navAdminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Admin
							</a>
							<div class="dropdown-menu" aria-labelledby="navAdminDropdown">
								<a class="dropdown-item" href="#"><i class="fas fa-list-alt"></i></i> <s>Userlist</s></a>
							</div>
						</li>
						<?php
					}
					if ($_SESSION['roleValue'] >= 3) { ?>
						<li class="nav-item active dropdown">
							<a class="nav-link dropdown-toggle" href="#navTools" id="navToolsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Tools
							</a>
							<div class="dropdown-menu" aria-labelledby="navToolsDropdown">
								<a class="dropdown-item" href="faction-lookup.php"><i class="fas fa-search"></i> Faction Lookup</a>
								<a class="dropdown-item" href="#"><i class="fas fa-file-code"></i> <s>Energy Reports</s></a>
								<a class="dropdown-item" href="https://www.heasleys.org/fs/"><i class="fas fa-calculator"></i> Respect Simulator</a>
							</div>
						</li>
						<?php
					}
					if ($_SESSION['roleValue'] >= 2) {
						?>
						<li class="nav-item active dropdown">
							<a class="nav-link dropdown-toggle" href="#navFac" id="navFactionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Faction
							</a>
							<div class="dropdown-menu" aria-labelledby="navFactionDropdown">
								<a class="dropdown-item" href="faction.php"><i class="fas fa-users"></i> Faction</a>
								<a class="dropdown-item" href="leaderboards.php"><i class="fas fa-crown"></i> Leaderboards</a>
								<a class="dropdown-item" href="memberstats.php"><i class="fas fa-archive"></i> Member Stats</a>
								<a class="dropdown-item" href="#"><i class="fas fa-link"></i><s> Chain History</s></a>
								<?php
								if ($_SESSION['roleValue'] >= 3) {
									?>
									<a class="dropdown-item" href="#"><i class="fas fa-battery-three-quarters"></i> <s>Members Energy</s></a>
									<?php
								}
								?>
							</div>
						</li>
						<?php
					}
					?>
					<li class="nav-item active dropdown">
						<a class="nav-link dropdown-toggle" href="#navPro" id="navProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php echo $_SESSION['username']; ?>
						</a>
						<div class="dropdown-menu" aria-labelledby="navProfileDropdown">
							<a class="dropdown-item" href="#"><i class="fas fa-user"></i> View Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="process/logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
						</div>
					</li>
				</ul>
			</div>

		</div>

	</nav>
