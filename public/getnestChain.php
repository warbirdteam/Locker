<?php
session_start();
if ($_SESSION['role'] == 'admin') {include('navbar-admin.php');} else {include('navbar.php');}
include_once("../misc/db_connect.php");


$apikey = 'AuSfpjzFPNZ07Yaw';


        $url = "https://api.torn.com/faction/?selections=chains&key=" . $apikey;

        $data = file_get_contents($url);

	$chains = json_decode($data);

?>
<!DOCTYPE html><html><head><title>Nest Chain History</title></head><body>

<?php
if (count($chains->chains)) {
	echo "<center><table border=1>";
	echo "<thead><tr><td colspan=5 align=center><h3>Nest Chain History</h3></td></tr></thead><tbody>";
	echo "<tr><th style=\"text-align:center\">Date</th><th style=\"text-align:center\">Chain Length</th><th style=\"text-align:center\">Respect Gained</th><th style=\"text-align:center\">Duration</th><th style=\"text-align:center\">Report</th></tr>";

	 foreach($chains->chains as $idx => $chains) {
	  if($chains->chain >= 10) {
		echo "<tr>";
		echo "<td>". date('m/d/Y H:i:s', $chains->end) . "</td>";
		echo "<td align=center>$chains->chain</td>";
		echo "<td>$chains->respect</td>";
		echo "<td>" . dateDiff($chains->end, $chains->start) . "</td>";
		echo "<td><a href=\"https://www.torn.com/war.php?step=chainreport&chainID=" . $idx . "\" target=\"_blank\">Report</a></td>";
		echo "</tr>";
	}
	}
	echo "</tbody></table></center>";
  }



function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();

    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Create temp time from time1 and interval
      $ttime = strtotime('+1 ' . $interval, $time1);
      // Set initial values
      $add = 1;
      $looped = 0;
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        // Create new temp time from time1 and interval
        $add++;
        $ttime = strtotime("+" . $add . " " . $interval, $time1);
        $looped++;
      }
 
      $time1 = strtotime("+" . $looped . " " . $interval, $time1);
      $diffs[$interval] = $looped;
    }
    
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
        break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
        // Add s if value is not 1
        if ($value != 1) {
          $interval .= "s";
        }
        // Add value and interval to times array
        $times[] = $value . " " . $interval;
        $count++;
      }
    }

    // Return string with times
    return implode(", ", $times);
  }


?>
