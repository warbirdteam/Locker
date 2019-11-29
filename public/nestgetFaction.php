<?php
session_start();
$_SESSION['title'] = 'Faction Members';

if($_SESSION['role'] == 'admin') {
	include('navbar-admin.php');
} else {
	include('navbar.php');
}


	 $fid = '35507';
   $url = 'https://api.torn.com/faction/'. $fid .'?selections=timestamp,basic&key=' . $_SESSION['key']; // url to api json
   $data = file_get_contents($url);

   $factions = json_decode($data, true); // decode the JSON feed

   $members = $factions['members'];
?>

<div class="container">
  <div class="row">
   <div class="col border border-dark shadow pt-4 mt-4 rounded">
		 <h3 align=center><?php echo $factions['name']; ?></h3>
			<table class="table table-hover table-striped table-dark" border=1>
				<thead class="thead-dark">
					<tr>
						<th scope="col">Name</th>
						<th scope="col">Days in Faction</th>
						<th scope="col">Last Action</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
			<tbody>

			<?php
			$count=0;
			while ($member = current($members)) {
				$userid = key($members);
				if ( strpos( $member['last_action']['relative'], 'day ago' ) !== false || strpos( $member['last_action']['relative'], 'days ago' ) !== false) {
					$class = 'class="bg-danger"';
				} else {$class = '';}
				echo '<tr ' . $class . '><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $userid . '" target="_blank">' . $member['name'] . ' [' . $userid . ']</a></td><td>'  . $member['days_in_faction'] . '</td><td>'. $member['last_action'] . '</td><td>' . $member['status'][0] . ' ' .  $member['status'][1] . '</td></tr>';
				$count++;
			next($members);
			}
			?>

			</tbody>
				<tfoot>
					<tr>
						<td colspan=4 align=center>Total: <?php echo $count; ?></td>
					</tr>
				</tfoot>
			</table>

			</div> <!-- col -->
		</div> <!-- row -->
	</div> <!-- container -->

<?php
include('footer.php');
?>
