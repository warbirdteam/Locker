<?php
//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();


if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}

if ($_SESSION['roleValue'] <= 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}


include_once(__DIR__ . "/../../includes/autoloader.inc.php");


if (isset($_POST["fid"])) {
  $fid = $_POST["fid"];
  if (isset($_POST["timeline"])) {
    $timeline = $_POST["timeline"];
  } else { $_SESSION['error'] = 'Something went wrong with member information lookup.'; exit("Error: Something went wrong with member information lookup.");}
} else { $_SESSION['error'] = 'Something went wrong with member information lookup.'; exit("Error: Something went wrong with member information lookup.");}

switch ($fid) {

  case '35507':
  memberInfo('35507', $timeline);
  break;
  case '13784':
  memberInfo('13784', $timeline);
  break;
  case '30085':
  memberInfo('30085', $timeline);
  break;

  default:
    $_SESSION['error'] = 'Something went wrong with member information lookup.'; exit("Error: Something went wrong with member information lookup.");
  break;
}

function memberInfo($faction, $timeline) {
  $tabledata = '';
  echo '<table class="member_info_table table table-hover table-striped table-dark table-sm" border=1 id="table_' . $faction . '_' . $timeline . '"><thead class="thead-dark">
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


        if ($memberName == 'Geometroid') {
          $fallenclass = ' class="bg-info"';
          $lastactionclass = 'class="bg-info"';
          $propertyclass = 'class="bg-info"';
          $donatorclass = 'class="bg-info"';
        } else {
          $fallenclass = '';

          $lastactionclass = ($lastaction <= strtotime('-24 hours')) ? 'class="bg-danger"' : '';
          $propertyclass = strpos($property,'Private Island') !== false ? '' : 'class="bg-danger"';
          $donatorclass = $donator == 0 ? 'class="bg-danger"' : '';

        }

        $tabledata .= '<tr'.$fallenclass.'><td></td><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $tornID . '" target="_blank">' . $memberName . ' [' . $tornID . ']</a></td><td ' . $donatorclass . '>'  . $donator . '</td><td ' . $propertyclass . '>'. $property . '</td><td data-toggle="tooltip" data-placement="left" title="'.$title.'" '. $lastactionclass .'>'. date('m-d-Y H:i:s',$lastaction) . '</td><td>'.number_format((float)$data[0]["xanscore"], 2, '.', '').'</dt><td>'.$data[0]["xanaxweek"].'</td><td>'.$data[0]["overdosedweek"].'</td><td>'.$data[0]["refill_energyweek"].'</td><td>'.$data[0]["refill_nerveweek"].'</td><td>'.$data[0]["boostersusedweek"].'</td><td>'.$data[0]["energydrinkusedweek"].'</td><td>'.$data[0]["statenhancersusedweek"].'</td><td>'.$data[0]["travelweek"].'</td><td>'.$data[0]["dumpsearchesweek"].'</td></tr>';
      }
    }

    echo $tabledata;
    echo '</tbody><tfoot><tr><td colspan=15 align=center>Total: ' . $counter . '/' . $count . '</td></tr></tfoot></table>';
  } else {
    echo '<tr><td colspan=15 align=center>No members found...</td></tr></table>';
  }

}