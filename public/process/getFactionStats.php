<?php
session_start();


if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}

if ($_SESSION['roleValue'] < 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	exit("Error: You do not have access to that area.");
	header("Location: /welcome.php");
}


include_once(__DIR__ . "/../../includes/autoloader.inc.php");

if (isset($_POST["type"])) {

    $db_request_faction_data = new db_request();
    $graph_data = $db_request_faction_data->getFactionStatsByFactionIDAndType($_SESSION['factionid'], $_POST["type"]);

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
