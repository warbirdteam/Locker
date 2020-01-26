<?php
session_start();
$_SESSION['title'] = 'Faction Members';
include('includes/header.php');
?>

<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script src="js/tablesort.js"></script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<?php
	switch ($_SESSION['role']) {
	    case 'admin':
	        include('includes/navbar-admin.php');
	        break;
	    case 'leadership':
	        include('includes/navbar-leadership.php');
	        break;
	    case 'guest':
	        header("Location: /welcome.php");
	        break;
	    case 'member':
	        include('includes/navbar-member.php');
	        break;
	    default:
					$_SESSION = array();
	        $_SESSION['error'] = "You are not logged in.";
	        header("Location: /index.php");
	        break;
	}
include_once(__DIR__ . "/../includes/autoloader.inc.php");
?>

<div class="container">

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 pt-3 mx-auto">
			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Faction Members</h5>
				<div class="card-body">

			<ul class="nav nav-tabs" id="memberTabs" role="tablist">
				<li class="nav-item">
				<a class="nav-link active" id="nest-members-tab" data-toggle="tab" href="#nest-members" role="tab">Nest Members</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" id="wb-members-tab" data-toggle="tab" href="#wb-members" role="tab">Warbirds Members</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" id="wbng-members-tab" data-toggle="tab" href="#wbng-members" role="tab">WBNG Members</a>
				</li>
			</ul>
			<div class="tab-content" id="memberTabsContent">

				<div class="tab-pane fade  show active" id="nest-members" role="tabpanel">
					<div class="table-responsive">
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
					$db_nest_members = new DB_request();
					$rows = $db_nest_members->getFactionMembersByFaction('35507');
					$count = $db_nest_members->row_count;

					if($count > 0){
						foreach ($rows as $row){
							$class = ($row['last_action'] <= strtotime('-24 hours')) ? 'class="bg-danger"' : '';
							$title = round((time() - $row['last_action'])/60/60);
							$title .= ' hours ago';
							echo '<tr ' . $class . '><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $row['userid'] . '" target="_blank">' . $row['name'] . ' [' . $row['userid'] . ']</a></td><td>'  . $row['days_in_faction'] . '</td><td data-toggle="tooltip" data-placement="left" title="'.$title.'">'. date('m-d-Y H:i:s',$row["last_action"]) . '</td><td>'. $row['status'] . '</td></tr>';
						}
					} else {
						echo '<tr><td colspan=4 align=center>No members found...</td></tr>';
					}
					?>

					</tbody>
						<tfoot>
							<tr>
								<td colspan=4 align=center>Total: <?php echo $count; ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
				</div>

				<div class="tab-pane fade" id="wb-members" role="tabpanel">
					<div class="table-responsive">
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
					$db_wb_members = new DB_request();
					$rows = $db_wb_members->getFactionMembersByFaction('13784');
					$count = $db_wb_members->row_count;

					if($count > 0){
						foreach ($rows as $row){
							$class = ($row['last_action'] <= strtotime('-24 hours')) ? 'class="bg-danger"' : '';
							$title = round((time() - $row['last_action'])/60/60);
							$title .= ' hours ago';
							echo '<tr ' . $class . '><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $row['userid'] . '" target="_blank">' . $row['name'] . ' [' . $row['userid'] . ']</a></td><td>'  . $row['days_in_faction'] . '</td><td data-toggle="tooltip" data-placement="left" title="'.$title.'">'. date('m-d-Y H:i:s',$row["last_action"]) . '</td><td>'. $row['status'] . '</td></tr>';
						}
					} else {
						echo '<tr><td colspan=4 align=center>No members found...</td></tr>';
					}
					?>

					</tbody>
						<tfoot>
							<tr>
								<td colspan=4 align=center>Total: <?php echo $count; ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
				</div>

				<div class="tab-pane fade" id="wbng-members" role="tabpanel">
					<div class="table-responsive">
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
					$db_wbng_members = new DB_request();
					$rows = $db_wbng_members->getFactionMembersByFaction('30085');
					$count = $db_wbng_members->row_count;

					if($count > 0){
						foreach ($rows as $row){
							$class = ($row['last_action'] <= strtotime('-24 hours')) ? 'class="bg-danger"' : '';
							$title = round((time() - $row['last_action'])/60/60);
							$title .= ' hours ago';
							echo '<tr ' . $class . '><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $row['userid'] . '" target="_blank">' . $row['name'] . ' [' . $row['userid'] . ']</a></td><td>'  . $row['days_in_faction'] . '</td><td data-toggle="tooltip" data-placement="left" title="'.$title.'">'. date('m-d-Y H:i:s',$row["last_action"]) . '</td><td>'. $row['status'] . '</td></tr>';
						}
					} else {
						echo '<tr><td colspan=4 align=center>No members found...</td></tr>';
					}
					?>

					</tbody>
						<tfoot>
							<tr>
								<td colspan=4 align=center>Total: <?php echo $count; ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
				</div>

				</div>
			</div>



				</div>

		</div> <!-- col -->
	</div> <!-- row -->


	</div> <!-- container -->

<?php
include('includes/footer.php');
?>
