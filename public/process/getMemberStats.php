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


if (isset($_POST["fid"])) {
  $fid = $_POST["fid"];
  if (isset($_POST["timeline"])) {
    $timeline = $_POST["timeline"];
  } else { $_SESSION['error'] = 'Something went wrong with member information lookup.'; exit("Error: Something went wrong with member information lookup.");}
} else { $_SESSION['error'] = 'Something went wrong with member information lookup.'; exit("Error: Something went wrong with member information lookup.");}

if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
//#### LEADERSHIP & ADMIN ALLOWED TO SEE OTHER FACTION MEMBER STATS
} else {
	if ($_POST['fid'] != $_SESSION['factionid']) {
		$_SESSION['error'] = 'You do not have access to see that faction.'; exit("Error: You do not have access to see that faction.");
	}
}

switch ($fid) {

  case '35507':
  memberInfo('35507', $timeline);
  break;
  case '13784':
  memberInfo('13784', $timeline);
  break;
	case '37132':
	memberInfo('37132', $timeline);
	break;

  default:
    $_SESSION['error'] = 'Faction requested could not be found.'; exit("Error: Faction requested could not be found.");
  break;
}

function memberInfo($faction, $timeline) {
  $tabledata = '';
  echo '<table class="member_info_table table table-hover table-dark table-sm" border=1 id="table_' . $faction . '_' . $timeline . '"><thead class="thead-dark">
  <tr>
  <th scope="col" class="text-truncate sorter-false">#</th>
  <th scope="col" class="text-truncate">Name</th>
  <th scope="col" class="text-truncate">Donator</th>
  <th scope="col" class="text-truncate">Property</th>
  <th scope="col" class="text-truncate">Last Action</th>
  <th scope="col" class="text-truncate">XanScore<i class="far fa-copyright"></i></th>
  <th scope="col" class="text-truncate">Xanax</th>
  <th scope="col" class="text-truncate">ODs</th>
  <th scope="col" class="text-truncate">Energy Rx</th>
  <th scope="col" class="text-truncate">Nerve Rx</th>
  <th scope="col" class="text-truncate">Boosters</th>
  <th scope="col" class="text-truncate">Cans</th>
  <th scope="col" class="text-truncate">SEs</th>
  <th scope="col" class="text-truncate">Travels</th>
  <th scope="col" class="text-truncate">Dump</th>
	<th scope="col" class="text-truncate">Revives</th>
  </tr>
  </thead><tbody>';

  $db_member_list = new db_request();
  $rows = $db_member_list->getFactionMembersByFaction($faction);
  $count = $db_member_list->row_count;

  if($count > 0){
    $counter = 0;
		foreach ($rows as $tornID => $row){

			$memberInfo = $db_member_list->getMemberInfoByTornID($tornID);

			if (empty($row) || empty($memberInfo)) {continue;} //skip iteration

			if (isset($row['tornName'])) {$memberName = $row['tornName'];} else {continue;}
			if (isset($row['last_action'])) {$lastaction = $row['last_action'];} else {continue;}
			if (isset($memberInfo['donator'])) {$donator = $memberInfo['donator'];} else {continue;}
			if (isset($memberInfo['property'])) {$property = $memberInfo['property'];} else {continue;}







      $db_memberStats = new db_request();

      switch ($timeline) {

        case 'week':
        $data = $db_memberStats->getMemberStatsByIDWeek($tornID);
        break;
        case 'month':
        $data = $db_memberStats->getMemberStatsByIDMonth($tornID);
        break;

        default:
          $_SESSION['error'] = 'Something went wrong with member information lookup.';
          exit("Error: Something went wrong with member information lookup.");
        break;
      }

      $membercount = $db_memberStats->row_count;

      if ($membercount > 0){
        $counter++;

        $title = round((time() - $lastaction)/60/60);
        $title .= ' hours ago';

				if ($_SESSION['userid'] == $tornID) {
					$rowclass = ' style="background-color: rgba(101, 201, 0, 0.41);"';
				} else {
					$rowclass = '';
				}

				$lastactionclass = ($lastaction <= strtotime('-24 hours')) ? 'class="bg-danger"' : '';
				$propertyclass = strpos($property,'Private Island') !== false ? '' : 'class="bg-danger"';
				$donatorclass = $donator == 0 ? 'class="bg-danger"' : '';

				if ($row['status_details'] == 'Resting in Peace') {
					$rowclass = ' class="table-info"';
					$lastactionclass = 'class="table-info"';
					$propertyclass = 'class="table-info"';
					$donatorclass = 'class="table-info"';
				}

        $tabledata .= '<tr'.$rowclass.'><td></td><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $tornID . '" target="_blank">' . $memberName . ' [' . $tornID . ']</a></td><td ' . $donatorclass . '>'  . $donator . '</td><td ' . $propertyclass . '>'. $property . '</td><td data-bs-toggle="tooltip" data-placement="left" title="'.$title.'" '. $lastactionclass .'>'. date('m-d-Y H:i:s',$lastaction) . '</td><td>'.number_format((float)$data["xanScore"], 2, '.', '').'</dt><td>'.$data["xanax"].'</td><td>'.$data["overdosed"].'</td><td>'.$data["refill_energy"].'</td><td>'.$data["refill_nerve"].'</td><td>'.$data["boostersused"].'</td><td>'.$data["energydrinkused"].'</td><td>'.$data["statenhancersused"].'</td><td>'.$data["travel"].'</td><td>'.$data["dumpsearches"].'</td><td>'.$data["revives"].'</td></tr>';
      }
    }

    echo $tabledata;
		$updatedTimestamp = $db_member_list->getMemberStatsUpdateTime();
		$formatted = date("F j, Y - H:i",strtotime($updatedTimestamp));
    echo '</tbody><tfoot><tr><td colspan=16 align=center>Total: ' . $counter . '/' . $count . '</td></tr><tr><td colspan=16 align=center>Last Updated: ' . $formatted . ' TCT</td></tr></tfoot></table>';
  } else {
    echo '<tr><td colspan=16 align=center>No members found...</td></tr></table>';
  }

}
