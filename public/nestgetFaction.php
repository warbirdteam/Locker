<?php
session_start();

if($_SESSION['role'] == 'admin') {
	include('navbar-admin.php');
} else {
	include('navbar.php');
}



   $url = 'https://api.torn.com/faction/35507?selections=timestamp,basic,upgrades,stats&key=AuSfpjzFPNZ07Yaw'; // url to api json
   $data = file_get_contents($url);

   $factions = json_decode($data, true); // decode the JSON feed

   $members = $factions['members'];

echo '<!DOCTYPE html><html><head><title>Nest Members</title></head><body>';
echo '<center><table border=1>';
echo '<thead><tr><td colspan=4 align=center><h3>The Nest</h3></td></tr>';
echo '<tr><th>Name</th><th>Days in Faction</th><th>Last Action</th><th>Status</th></tr></thead><tbody>';
$count=0;

foreach($members as $member) {
	echo '<tr><td>' . $member['name'] . '</td><td>'  . $member['days_in_faction'] . '</td><td>' , $member['last_action'] . '</td><td>' . $member['status'][0] . ' ' .  $member[status][1] . '</td></tr>';
	$count++;

}

echo '</tbody><tfoot><tr><td colspan=2 align=right>Total:</td><td colspan=2 align=center> ' . $count . '</td></tr></tfoot></table></center>';

echo '</body></html>';
?>
