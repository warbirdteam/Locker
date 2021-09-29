<?php
//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Chain Reports';
include('includes/header.php');
include('includes/navbar-logged.php');


if ($_SESSION['role'] == 'admin') {
	//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
	//temporarily disabled
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
			<h5 class="card-header">Chain Reports</h5>
			<div class="card-body">

		<ul class="nav nav-tabs" id="chainTabs" role="tablist">
			<li class="nav-item">
			<a class="nav-link active" id="nest-chains-tab" data-bs-toggle="tab" href="#nest-chains" role="tab">Nest Chains</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="wb-chains-tab" data-bs-toggle="tab" href="#wb-chains" role="tab">Warbirds Chains</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="wbng-chains-tab" data-bs-toggle="tab" href="#wbng-chains" role="tab">WBNG Chains</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="fowl-chains-tab" data-bs-toggle="tab" href="#fowl-chains" role="tab">FowlMed Chains</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="other-chains-tab" data-bs-toggle="tab" href="#other-chains" role="tab">Other Chains</a>
			</li>
		</ul>
		<div class="tab-content" id="chainTabContent">

			<div class="tab-pane fade  show active" id="nest-chains" role="tabpanel">
				<div class="table-responsive">
				<table class="table table-hover table-striped table-dark py-4 mt-4">
					 <thead class="thead-dark">
						 <tr>
							 <th scope="col">Chain</th>
							 <th scope="col">Date</th>
							 <th scope="col">Hits</th>
							 <th scope="col">Respect</th>
							 <th scope="col">Duration</th>
						 </tr>
					 </thead>
					 <tbody>


						 <?php
						 // Get member rows
						 $nest_chains = new DB_request();
						 $rows = $nest_chains->getChainsByFactionID('35507');
						 $count = $nest_chains->row_count;

						 if($count > 0){

						 foreach ($rows as $row){
						 ?>

							<tr>
								<td><?php echo '<a class="text-reset" href="https://www.torn.com/war.php?step=chainreport&chainID=' . $row["ndx"] . '" target="_blank">' . $row["ndx"] . '</a>';?></td>
								<td><?php echo $row["date"]; ?></td>
								<td><?php echo $row["hits"]; ?></td>
								<td><?php echo $row["respect"]; ?></td>
								<td><?php echo $row["duration"]; ?></td>
							</tr>

						 <?php } }else{ ?>
							 <tr><td colspan="5">No information found...</td></tr>
						 <?php } ?>
					 </tbody>
				</table>
			</div>
			</div>

			<div class="tab-pane fade" id="wb-chains" role="tabpanel">
				<div class="table-responsive">
				<table class="table table-hover table-striped table-dark py-4 mt-4">
					 <thead class="thead-dark">
						 <tr>
							 <th scope="col">Chain</th>
							 <th scope="col">Date</th>
							 <th scope="col">Hits</th>
							 <th scope="col">Respect</th>
							 <th scope="col">Duration</th>
						 </tr>
					 </thead>
					 <tbody>


						 <?php
						 // Get member rows
						 $wb_chains = new DB_request();
						 $rows = $wb_chains->getChainsByFactionID('13784');
						 $count = $wb_chains->row_count;

						 if($count > 0){

						 foreach ($rows as $row){
						 ?>

							<tr>
								<td><?php echo '<a class="text-reset" href="https://www.torn.com/war.php?step=chainreport&chainID=' . $row["ndx"] . '" target="_blank">' . $row["ndx"] . '</a>';?></td>
								<td><?php echo $row["date"]; ?></td>
								<td><?php echo $row["hits"]; ?></td>
								<td><?php echo $row["respect"]; ?></td>
								<td><?php echo $row["duration"]; ?></td>
							</tr>

						 <?php } }else{ ?>
							 <tr><td colspan="5">No information found...</td></tr>
						 <?php } ?>
					 </tbody>
				</table>
			</div>
			</div>

			<div class="tab-pane fade" id="wbng-chains" role="tabpanel">
				<div class="table-responsive">
				<table class="table table-hover table-striped table-dark py-4 mt-4">
					 <thead class="thead-dark">
						 <tr>
							 <th scope="col">Chain</th>
							 <th scope="col">Date</th>
							 <th scope="col">Hits</th>
							 <th scope="col">Respect</th>
							 <th scope="col">Duration</th>
						 </tr>
					 </thead>
					 <tbody>


						 <?php
						 // Get member rows
						 $wbng_chains = new DB_request();
						 $rows = $wbng_chains->getChainsByFactionID('30085');
						 $count = $wbng_chains->row_count;

						 if($count > 0){

						 foreach ($rows as $row){
						 ?>

							<tr>
								<td><?php echo '<a class="text-reset" href="https://www.torn.com/war.php?step=chainreport&chainID=' . $row["ndx"] . '" target="_blank">' . $row["ndx"] . '</a>';?></td>
								<td><?php echo $row["date"]; ?></td>
								<td><?php echo $row["hits"]; ?></td>
								<td><?php echo $row["respect"]; ?></td>
								<td><?php echo $row["duration"]; ?></td>
							</tr>

						 <?php } }else{ ?>
							 <tr><td colspan="5">No information found...</td></tr>
						 <?php } ?>
					 </tbody>
				</table>
			</div>
			</div>


			<div class="tab-pane fade" id="fowl-chains" role="tabpanel">
				<div class="table-responsive">
				<table class="table table-hover table-striped table-dark py-4 mt-4">
					 <thead class="thead-dark">
						 <tr>
							 <th scope="col">Chain</th>
							 <th scope="col">Date</th>
							 <th scope="col">Hits</th>
							 <th scope="col">Respect</th>
							 <th scope="col">Duration</th>
						 </tr>
					 </thead>
					 <tbody>


						 <?php
						 // Get member rows
						 $fowl_chains = new DB_request();
						 $rows = $fowl_chains->getChainsByFactionID('37132');
						 $count = $fowl_chains->row_count;

						 if($count > 0){

						 foreach ($rows as $row){
						 ?>

							<tr>
								<td><?php echo '<a class="text-reset" href="https://www.torn.com/war.php?step=chainreport&chainID=' . $row["ndx"] . '" target="_blank">' . $row["ndx"] . '</a>';?></td>
								<td><?php echo $row["date"]; ?></td>
								<td><?php echo $row["hits"]; ?></td>
								<td><?php echo $row["respect"]; ?></td>
								<td><?php echo $row["duration"]; ?></td>
							</tr>

						 <?php } }else{ ?>
							 <tr><td colspan="5">No information found...</td></tr>
						 <?php } ?>
					 </tbody>
				</table>
			</div>
			</div>


			<div class="tab-pane fade" id="other-chains" role="tabpanel">
				<div class="table-responsive">
				<table class="table table-hover table-striped table-dark py-4 mt-4">
					 <thead class="thead-dark">
						 <tr>
							 <th scope="col">Faction</th>
							 <th scope="col">Chain</th>
						 </tr>
					 </thead>
					 <tbody>


						 <?php
						 // Get member rows
						 $other_chains = new DB_request();
						 $rows = $other_chains->getAllChainIDs();
						 $count = $other_chains->row_count;

						 if($count > 0){

						 foreach ($rows as $row){
						 ?>

							<tr>
								<td><?php echo '<a class="text-reset" href="https://www.torn.com/factions.php?step=profile&ID=' . $row["factionID"] . '" target="_blank">' . $row["factionID"] . '</a>';?></td>
								<td><?php echo '<a class="text-reset" href="https://www.torn.com/war.php?step=chainreport&chainID=' . $row["chainID"] . '" target="_blank">' . $row["chainID"] . '</a>';?></td>
							</tr>

						 <?php } }else{ ?>
							 <tr><td colspan="5">No information found...</td></tr>
						 <?php } ?>
					 </tbody>
				</table>
			</div>
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
