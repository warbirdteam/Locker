<?php

$userID = isset($_GET["userID"]) && is_numeric($_GET["userID"]) && strlen($_GET["userID"]) <= 10 ? $_GET["userID"] : NULL;
$factionID = isset($_GET["factionID"]) && is_numeric($_GET["factionID"]) && strlen($_GET["factionID"]) <= 10 ? $_GET["factionID"] : NULL;
$chainID = isset($_GET["chainID"]) && is_numeric($_GET["chainID"]) && strlen($_GET["chainID"]) <= 10 ? $_GET["chainID"] : NULL;

if ($factionID == NULL OR $chainID == NULL OR $userID == NULL) {
  echo "failure to upload data";
  exit;
}

include_once("../../includes/autoloader.inc.php");

$db_upload_chain = new db_request();
$row = $db_upload_chain->getChainByChainID($chainID);
echo '<pre>'; print_r($row); echo '</pre>';
print("<pre>".print_r($row,true)."</pre>");
echo $chainID;

if ($db_upload_chain->row_count == 0) {
  $db_upload_chain->insertChainID($factionID,$chainID,$userID);
  echo "successfully uploaded chain " . $_GET["chainID"];
} else {
  echo " Chain " . $_GET["chainID"] . " already in database!";
}
exit;
 ?>
