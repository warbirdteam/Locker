<?php
//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Faction Members';
include('includes/header.php');
?>



<?php
include('includes/navbar-logged.php');
?>

<?php
if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}

if ($_SESSION['roleValue'] <= 1) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}
?>

<div class="container">

	<div class="row">
		<div class="col pt-3 mx-auto">
			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Faction Members</h5>
				<div class="card-body">

					<ul class="nav nav-tabs" id="memberTabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="nest-members-tab" data-toggle="tab" href="#faction-35507" role="tab">Nest</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="wb-members-tab" data-toggle="tab" href="#faction-13784" role="tab">Warbirds</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="wbng-members-tab" data-toggle="tab" href="#faction-30085" role="tab">WBNG</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="fm-members-tab" data-toggle="tab" href="#faction-37132" role="tab">Fowl Med</a>
						</li>
					</ul>
					<div class="tab-content" id="memberTabsContent">
						<br>

						<?php
						$factions = array( "35507", "13784", "30085", "37132");
						$db_request = new db_request();

						foreach ($factions as $faction) {

							$rows = $db_request->getFactionMembersByFaction($faction);
							$count = $db_request->row_count;
							?>

							<div class="tab-pane fade show<?php if ($faction == "35507") {echo " active";}?>" id="faction-<?php echo $faction;?>" role="tabpanel">
								<div class="table-responsive">
									<table class="faction_member_table table table-hover table-striped table-dark" border=1>
										<thead class="thead-dark">
											<tr>
												<th scope="col" class="text-truncate sorter-false">#</th>
												<th scope="col" class="text-truncate">Name</th>
												<th scope="col" class="text-truncate" data-toggle="tooltip" data-placement="top" title="Days in Faction">DiF</th>
												<th scope="col" class="text-truncate">Last Action</th>
												<th scope="col" class="text-truncate">Status</th>
											</tr>
										</thead>
										<tbody>

											<?php
											if ($count > 0) {
												foreach ($rows as $tornID=>$row){
													$class = ($row['last_action'] <= strtotime('-24 hours')) ? 'class="bg-danger"' : '';
													$title = round((time() - $row['last_action'])/60/60);
													$title .= ' hours ago';
													if (strpos($row['status_details'], 'Resting in Peace') !== false) {$class = 'class="bg-info"';}
													echo '<tr ' . $class . '><td></td><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $tornID . '" target="_blank">' . $row['tornName'] . ' [' . $tornID . ']</a></td><td>'  . $row['days_in_faction'] . '</td><td data-toggle="tooltip" data-placement="left" title="'.$title.'">'. date('m-d-Y H:i:s',$row["last_action"]) . '</td><td>' . $row['status_desc'] . ' ' . $row['status_details'] . '</td></tr>';
												}
											} else {
												echo '<td><td colspan=4 align=center>No members found...</td></td>';
											}
											?>

										</tbody>
										<tfoot>
											<tr>
												<td colspan=5 align=center>Total: <?php echo $count; ?></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>

						<?php } ?>


					</div>
				</div>



			</div>

		</div> <!-- col -->
	</div> <!-- row -->


</div> <!-- container -->

<?php
include('includes/footer.php');
?>
