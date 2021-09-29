<?php
//##### ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Userlist';
include('includes/header.php');
?>

<style>
td.border-left {
	border-left:1px solid #454d55 !important;
}

td > select.table_select {
	height: 49px;
	margin-top: -12px;
	margin-bottom: -12px;
	width: 100%;
	background-color: #343a40;
	border: none;
	color: white;
}
</style>

<?php
include('includes/navbar-logged.php');

if ($_SESSION['role'] == 'admin') {
	//##### ADMIN ONLY PAGE
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
	exit;
}
?>

<div class="container">
	<div class="row">
		<div class="col-xl-10 col-lg-10 col-md-12 pt-3 mx-auto">


			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Userlist</h5>
				<div class="card-body">

					<table class="table table-dark">
						<thead class="thead-dark">
							<tr>
								<th scope="col">User</th>
								<th scope="col">Faction</th>
								<th scope="col">Site Role</th>
							</tr>
						</thead>
						<tbody>
							<form>

								<?php
								// Get member rows

								$db_request = new db_request();
								$rows = $db_request->getAllSiteUsers();
								$count = $db_request->row_count;

								if($count > 0){

								foreach ($rows as $siteUser){

								$tornUser = $db_request->getTornUserBySiteID($siteUser['siteID']);

								$faction = $db_request->getFactionByFactionID($tornUser['tornFaction']);

								if ($_SESSION['siteID'] == $siteUser['siteID']) {
									$hover = ' data-bs-toggle="tooltip" data-placement="right" title="You cannot edit your own role."';
									$disabled = ' disabled';
								} else {
									$hover = '';
									$disabled = '';
								}

								switch ($siteUser['siteRole']) {
									case 'admin':
										$role_select = '<option value="admin" selected>ADMIN</option><option value="leadership">LEADERSHIP</option><option value="member">MEMBER</option><option value="guest">GUEST</option><option value="none">NONE</option>';
										break;
									case 'leadership':
										$role_select = '<option value="admin">ADMIN</option><option value="leadership" selected>LEADERSHIP</option><option value="member">MEMBER</option><option value="guest">GUEST</option><option value="none">NONE</option>';
										break;
									case 'member':
										$role_select = '<option value="admin">ADMIN</option><option value="leadership">LEADERSHIP</option><option value="member" selected>MEMBER</option><option value="guest">GUEST</option><option value="none">NONE</option>';
										break;
									case 'guest':
										$role_select = '<option value="admin">ADMIN</option><option value="leadership">LEADERSHIP</option><option value="member">MEMBER</option><option value="guest" selected>GUEST</option><option value="none">NONE</option>';
										break;
									case 'none':
										$role_select = '<option value="admin">ADMIN</option><option value="leadership">LEADERSHIP</option><option value="member">MEMBER</option><option value="guest">GUEST</option><option value="none" selected>NONE</option>';
										break;

									default:
										$role_select = '<option value="admin">ADMIN</option><option value="leadership">LEADERSHIP</option><option value="member">MEMBER</option><option value="guest">GUEST</option><option value="none" selected>NONE (error cannot find)</option>';
										break;
								}
								?>

								<tr data-siteid=<?php echo $siteUser['siteID']; ?>>
									<td class="border-left"><a class="text-reset" href="https://www.torn.com/profiles.php?XID=<?php echo $tornUser['tornID'] ?>"><?php echo $tornUser['tornName'] . " [" . $tornUser['tornID'] . "]"; ?></a></td>
									<td class="border-left"><a class="text-reset" href="https://www.torn.com/factions.php?step=profile&ID=<?php echo $faction['factionID'] ?>"><?php echo $faction['factionName'] ?></a></td>
									<td class="border-left" <?php echo $hover; ?>>
										<select class="table_select" <?php echo $disabled; ?>>
											<?php echo $role_select; ?>
								    </select>
									</td>
								</tr>

								<?php } }else{ ?>
								<tr><td class="border-left" colspan="3">No information found...</td></tr>
								<?php } ?>
							</form>
						</tbody>
					</table>
				</div>
			</div>


		</div> <!-- col -->
	</div> <!-- row -->
</div> <!-- container -->

<script type="text/javascript" src="js/userlist.js"></script>
<?php
include('includes/footer.php');
?>
