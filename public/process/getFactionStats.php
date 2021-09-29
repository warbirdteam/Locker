<?php
//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
//start the session array
session_start();
//If cannot find site ID, empty session array and send to login page with error message
if(!isset($_SESSION['siteID'])){
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	exit;
}
if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership' || $_SESSION['role'] == 'member') {
	//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
	//load classes files in classes folder
	include_once(__DIR__ . "/../../includes/autoloader.inc.php");
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: ../welcome.php");
	exit;
}


if (isset($_POST["type"]) && isset($_POST["factionid"])) {

    $db_request_faction_data = new db_request();
    $graph_data = $db_request_faction_data->getFactionStatsByFactionIDAndType($_POST["factionid"], $_POST["type"]);

    if (!empty($graph_data)) {
      $chartData = '[';

      foreach ($graph_data as $row) {
        $datetime = ((int)strtotime($row["timestamp"]) * 1000);
        $value = $row['data'];
        $chartData .= '{"x": ' . $datetime . ', "y": ' . $value . '},';
      }
      $string = rtrim($chartData, ',');
      $string .= ']';

      header('Content-Type: application/json');
      echo json_encode($string);
    }
    else {
      echo 'Error';
    }

} else {
  echo 'Error';
}
  exit;
?>
