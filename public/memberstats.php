<?php
//##### LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Member Stats';
include('includes/header.php');
include('includes/navbar-logged.php');


if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
	//##### LEADERSHIP & ADMIN ONLY PAGE
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
	exit;
}
?>

<div class="container-fluid">

	<div class="row">
		<div class="col pt-3 mx-auto">
			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Member Stats</h5>
				<div class="card-body">

					<ul class="nav nav-pills nav-justified flex-column flex-md-row my-2" id="memberTabs" role="tablist">
						<li class="nav-item mx-2 mb-2">
							<a class="flex-md-fill nav-link border border-dark" id="nest-members-week-tab" data-fid="35507" data-timeline="week" data-bs-toggle="tab" href="#week-35507" role="tab">Nest: 7 Days</a>
						</li>
						<li class="nav-item  mx-2 mb-2">
							<a class="flex-md-fill nav-link border border-dark" id="nest-members-month-tab" data-fid="35507" data-timeline="month" data-bs-toggle="tab" href="#month-35507" role="tab">Nest: 30 Days</a>
						</li>
						<li class="nav-item  mx-2 mb-2">
							<a class="flex-md-fill nav-link border border-dark" id="wb-members-week-tab" data-fid="13784" data-timeline="week" data-bs-toggle="tab" href="#week-13784" role="tab">Warbirds: 7 Days</a>
						</li>
						<li class="nav-item  mx-2 mb-2">
							<a class="flex-md-fill nav-link border border-dark" id="wb-members-month-tab" data-fid="13784" data-timeline="month" data-bs-toggle="tab" href="#month-13784" role="tab">Warbirds: 30 Days</a>
						</li>
						<li class="nav-item  mx-2 mb-2">
							<a class="flex-md-fill nav-link border border-dark" id="fowl-members-week-tab" data-fid="37132" data-timeline="week" data-bs-toggle="tab" href="#week-37132" role="tab">Fowl: 7 Days</a>
						</li>
						<li class="nav-item  mx-2 mb-2">
							<a class="flex-md-fill nav-link border border-dark" id="fowl-members-month-tab" data-fid="37132" data-timeline="month" data-bs-toggle="tab" href="#month-37132" role="tab">Fowl: 30 Days</a>
						</li>
					</ul>
					<div class="tab-content" id="memberTabsContent">
						<?php

						$factions = array( "35507", "13784", "37132" );

						foreach ($factions as $faction) { ?>


							<div class="tab-pane fade" id="week-<?php echo $faction;?>" role="tabpanel">
								<div class="table-responsive">

									<div class="d-flex justify-content-center mt-2">
										<div class="spinner-grow spinner-grow-sm" role="status">
											<span class="sr-only">Loading...</span>
										</div>
										<div class="spinner-grow spinner-grow-sm" role="status">
										</div>
										<div class="spinner-grow spinner-grow-sm" role="status">
										</div>
										<div class="spinner-grow spinner-grow-sm" role="status">
										</div>
										<div class="spinner-grow spinner-grow-sm" role="status">
										</div>
									</div>

								</div>

							</div>


							<div class="tab-pane fade" id="month-<?php echo $faction;?>" role="tabpanel">
								<div class="table-responsive">

									<div class="d-flex justify-content-center mt-2">
										<div class="spinner-grow spinner-grow-sm" role="status">
											<span class="sr-only">Loading...</span>
										</div>
										<div class="spinner-grow spinner-grow-sm" role="status">
										</div>
										<div class="spinner-grow spinner-grow-sm" role="status">
										</div>
										<div class="spinner-grow spinner-grow-sm" role="status">
										</div>
										<div class="spinner-grow spinner-grow-sm" role="status">
										</div>
									</div>

								</div>

							</div>
							<?php
						}//foreach faction
						?>






					</div>

				</div> <!-- card-body -->
			</div> <!-- card -->
		</div> <!-- col -->
	</div> <!-- row -->


</div> <!-- container -->
<script type="text/javascript" src="js/memberstats.js"></script>
<?php
include('includes/footer.php');
?>
