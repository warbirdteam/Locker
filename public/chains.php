<?php
session_start();
$_SESSION['title'] = 'Chain Reports';
include('includes/header.php');
?>

<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script src="js/tablesort.js"></script>

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
	<div class="col-xl-10 col-lg-10 col-md-12 pt-3 mx-auto">
		<div class="card border border-dark shadow rounded mt-4">
			<h5 class="card-header">Chain Reports</h5>
			<div class="card-body">

		<ul class="nav nav-tabs" id="chainTabs" role="tablist">
			<li class="nav-item">
			<a class="nav-link active" id="nest-chains-tab" data-toggle="tab" href="#nest-chains" role="tab">Nest Chains</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="wb-chains-tab" data-toggle="tab" href="#wb-chains" role="tab">Warbirds Chains</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="wbng-chains-tab" data-toggle="tab" href="#wbng-chains" role="tab">WBNG Chains</a>
			</li>
		</ul>
		<div class="tab-content" id="chainTabContent">

			<div class="tab-pane fade  show active" id="nest-chains" role="tabpanel">

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
						 $rows = $nest_chains->getChainReports('35507','50');
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

			<div class="tab-pane fade" id="wb-chains" role="tabpanel">

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
						 $rows = $wb_chains->getChainReports('13784','100');
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

			<div class="tab-pane fade" id="wbng-chains" role="tabpanel">

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
						 $rows = $wbng_chains->getChainReports('30085','100');
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
		</div>



			</div>
	 </div>
	</div> <!-- col -->
</div> <!-- row -->



</div> <!-- container -->









<?php
include('includes/footer.php');
?>
