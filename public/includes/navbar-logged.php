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
if (empty($torn)) { $error = new Error_Message("You are no longer logged in.","../index.php"); }
$site = $db_request->getSiteUserBySiteID($torn['siteID']);
if (empty($site)) { $error = new Error_Message("You are no longer logged in.","../index.php"); }


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
		<a class="navbar-brand ml-5" href="welcome.php">Warbirds</a>
		<button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navMobileDropdown" aria-controls="navMobileDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>


		<div class="collapse navbar-collapse justify-content-end" id="navMobileDropdown">

				<ul class="navbar-nav float-right mr-3">
					<?php
					switch ($roleValue) {
						case 4:
						include('includes/navbar-admin.php');
						break;
						case 3:
						include('includes/navbar-leadership.php');
						break;
						case 2:
						include('includes/navbar-member.php');
						break;
						case 1:
						include('includes/navbar-guest.php');
						break;
						default:
						$_SESSION = array();
						$_SESSION['error'] = "You are no longer logged in.";
						header("Location: /index.php");
						break;
					}
					 ?>
				</ul>


		</div>

	</nav>
