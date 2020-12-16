<?php
//##### GUEST & MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Welcome'; //Add whatever title you wish here. This will be displayed in the tab of your browser
include('includes/header.php'); //required to include basic bootstrap and javascript files
?>

<script src="js/highcharts.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<?php
include('includes/navbar-logged.php');
?>

<?php
if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}

if ($_SESSION['roleValue'] <= 0) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}
?>

<?php
if (empty($_SESSION['factionid'])) {
  $_SESSION = array();
  $_SESSION['error'] = "You are no longer logged in.";
  header("Location: /index.php");
}


$filename = __DIR__. '/../TornAPIs/' . $_SESSION['factionid'] . "/".$_SESSION['userid'].".json";
if (!file_exists($filename)) {
  $_SESSION = array();
  $_SESSION['error'] = "You are no longer logged in.";
  header("Location: /index.php");
}

$data = unserialize(file_get_contents($filename));
$json = json_decode($data, true); // decode the JSON feed
?>



<div class="content">
  <?php
  if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
  }
  ?>
  <?php
  if (isset($_SESSION['success'])) {
		echo '<div class="alert alert-success alert-dismissible fade show my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['success'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    unset($_SESSION['success']);
  }
  ?>
  <div class="container-fluid pt-2 no-gutters">

    <div class="row justify-content-lg-center justify-content-md-center m">


      <!-- Networth Card -->
      <div class="pt-3 col-sm-12 col-md-6 col-lg-6 col-xl-4 pl-xl-1">
        <div class="card border border-dark shadow rounded h-100">
          <h5 class="card-header">Networth: $<?php echo number_format($json["personalstats"]["networth"]); ?></h5>
          <div class="card-body p-0">

            <div id="networth"></div>

          </div>
        </div>
      </div> <!-- col -->

			<!-- Report Card Card -->
			<div class="pt-3 col-sm-12 col-md-6 col-lg-6 col-xl-4 pl-xl-0 pl-lg-0 pl-md-0">
				<div class="card border border-dark shadow rounded h-100">
					<h5 class="card-header">Report Card (beta)</h5>
					<div class="card-body">
						<p class='text-center'><b><?php echo $_SESSION['username'] . ' [' . $_SESSION['userid'] . ']'; ?></b></p><hr>
						<?php
						$rp_request = new db_request();

						$memberInfo = $rp_request->getMemberInfoByTornID($_SESSION['userid']);

						$memberStatsWeek = $rp_request->getMemberStatsByIDWeek($_SESSION['userid']);
						$memberStatsMonth = $rp_request->getMemberStatsByIDMonth($_SESSION['userid']);

						if ($memberInfo) {

							if ($memberInfo['property'] == 'Private Island') {
								$property = 'Private Island<span class="text-success"> <i class="fas fa-check"></i></span>';
							} else {
								$property = $memberInfo["property"].'<span class="text-danger"> <i class="fas fa-times"></i></span>';
							}

							if ($memberInfo['donator'] == 1) {
								$donator = 'Yes<span class="text-success"> <i class="fas fa-check"></i></span>';
							} else {
								$donator = 'No<span class="text-danger"> <i class="fas fa-times"></i></span>';
							}

							?>
							<span><b>Property:</b> <?php echo $property;?></span><br>
							<span><b>Donator Status:</b> <?php echo $donator;?></span><br><br>
							<?php
						}

						if ($memberStatsWeek && $memberStatsMonth) {

							if ($memberStatsWeek['xanScore'] >= 2) {
								$xanscoreWeek = '<span class="text-success">' . $memberStatsWeek['xanScore'] . '</span>';
								$xanaxWeek = '<span class="text-success">' . $memberStatsWeek['xanax'] . "/21" . '</span>';
							} else {
								$xanscoreWeek = '<span class="text-danger">' . $memberStatsWeek['xanScore'] . '</span>';
								$xanaxWeek = '<span class="text-danger">' . $memberStatsWeek['xanax'] . "/21" . '</span>';
							}

							if ($memberStatsMonth['xanScore'] >= 2) {
								$xanscoreMonth = '<span class="text-success">' . $memberStatsMonth['xanScore'] . '</span>';
								$xanaxMonth = '<span class="text-success">' . $memberStatsMonth['xanax'] . "/93" . '</span>';
							} else {
								$xanscoreMonth = '<span class="text-danger">' . $memberStatsMonth['xanScore'] . '</span>';
								$xanaxMonth = '<span class="text-danger">' . $memberStatsMonth['xanax'] . "/93" . '</span>';
							}


							?>

							<span><b>Weekly XanScore:</b> <?php echo $xanscoreWeek;?></span><br>
							<span><b>Monthly XanScore:</b> <?php echo $xanscoreMonth;?></span><br><br>
							<span><b>Weekly Xanax:</b> <?php echo $xanaxWeek;?></span><br>
							<span><b>Monthly Xanax:</b> <?php echo $xanaxMonth;?></span><br>

							<?php
						}

							?>

							<hr><p class="text-center"><b>Battle Stats:</b></p>
							<span><b>Strength:</b> <?php echo number_format($json['strength']); ?></span><br>
							<span><b>Defense:</b> <?php echo number_format($json['defense']); ?></span><br>
							<span><b>Speed:</b> <?php echo number_format($json['speed']); ?></span><br>
							<span><b>Dexterity:</b> <?php echo number_format($json['dexterity']); ?></span><br>
							<span><b>Total:</b> <?php echo number_format($json['total']); ?></span>


					</div>
				</div>
			</div> <!-- col -->


			<div class="pt-3 col-sm-12 col-md-8 col-lg-8 col-xl-4 pl-xl-0 pr-xl-1">
				<div class="card border border-dark shadow rounded h-100">
					<h5 class="card-header">Warbirds Family Leaderboards</h5>
					<div class="card-body p-2">


						<ul class="nav nav-tabs mb-1" role="tablist">
							<li class="nav-item" role="presentation">
							<a class="nav-link active" id="networth-tab" data-toggle="tab" href="#networth-leaderboard" role="tab" aria-controls="networth" aria-selected="true">Networth</a>
							</li>
							<li class="nav-item" role="presentation">
							<a class="nav-link" id="awards-tab" data-toggle="tab" href="#awards" role="tab" aria-controls="awards" aria-selected="false">Awards</a>
							</li>
							<li class="nav-item" role="presentation">
							<a class="nav-link" id="level-tab" data-toggle="tab" href="#level" role="tab" aria-controls="level" aria-selected="false">Level</a>
							</li>
						</ul>

						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active h-100" id="networth-leaderboard" role="tabpanel" aria-labelledby="networth-tab">

								<div class="table-responsive">
									<table id="networth_table" class="table table-sm compact leaderboard_table border border-dark" style="width:100%;">
										<thead class="thead-dark">
											<tr>
												<th scope="col">#</th>
												<th scope="col">Name</th>
												<th scope="col">Faction</th>
												<th scope="col">Networth</th>
											</tr>
										</thead>
										<tbody>


											<?php
											$db_request = new db_request();
											$rows = $db_request->getAllMemberInfoOrderBy('networth');
											$i = 1;
											foreach ($rows as $row) {

												$member = $db_request->getMemberByTornID($row['tornID']);

												?>
												<tr<?php if ($_SESSION['userid'] == $row['tornID']) {echo " style='background-color: #c3ebc9;' ";} ?>>
													<td><?php echo $i;?></td>
													<td><a href="https://www.torn.com/profiles.php?XID=<?php echo $row['tornID'];?>" target="_blank"><?php echo $member['tornName'];?></a></td>
													<td><a href="https://www.torn.com/factions.php?step=profile&ID=<?php echo $member['factionID'];?>"target="_blank"><?php
													switch ($member['factionID']) {
														case '13784':
														echo "Warbirds";
														break;
														case '30085':
														echo "WBNG";
														break;
														case '35507':
														echo "The Nest";
														break;
														case '37132':
														echo "Fowl Med";
														break;
														default:
														echo "N/A";
														break;
													}?></a></td>
													<td>$<?php echo number_format($row['networth']);?></td>
												</tr>
												<?php
												$i++;
											}

											?>


										</tbody>
									</table>
								</div>

							</div>
							<div class="tab-pane fade" id="awards" role="tabpanel" aria-labelledby="awards-tab">

								<div class="table-responsive">
									<table id="awards_table" class="table table-sm compact leaderboard_table border border-dark" style="width:100%">
										<thead class="thead-dark">
											<tr>
												<th scope="col">#</th>
												<th scope="col">Name</th>
												<th scope="col">Faction</th>
												<th scope="col">Awards</th>
											</tr>
										</thead>
										<tbody>


											<?php
											$db_request = new db_request();
											$rows = $db_request->getAllMemberInfoOrderBy('awards');
											$i = 1;
											foreach ($rows as $row) {

												$member = $db_request->getMemberByTornID($row['tornID']);

												?>
												<tr<?php if ($_SESSION['userid'] == $row['tornID']) {echo " style='background-color: #c3ebc9;' ";} ?>>
													<td><?php echo $i;?></td>
													<td><a href="https://www.torn.com/profiles.php?XID=<?php echo $row['tornID'];?>" target="_blank"><?php echo $member['tornName'];?></a></td>
													<td><a href="https://www.torn.com/factions.php?step=profile&ID=<?php echo $member['factionID'];?>"target="_blank"><?php
													switch ($member['factionID']) {
														case '13784':
														echo "Warbirds";
														break;
														case '30085':
														echo "WBNG";
														break;
														case '35507':
														echo "The Nest";
														break;
														case '37132':
														echo "Fowl Med";
														break;
														default:
														echo "N/A";
														break;
													}?></a></td>
													<td><?php echo number_format($row['awards']);?></td>
												</tr>
												<?php
												$i++;
											}

											?>


										</tbody>
									</table>
								</div>

							</div>
							<div class="tab-pane fade" id="level" role="tabpanel" aria-labelledby="level-tab">

								<div class="table-responsive">
									<table id="Level_table" class="table table-sm compact leaderboard_table border border-dark" style="width:100%">
										<thead class="thead-dark">
											<tr>
												<th scope="col">#</th>
												<th scope="col">Name</th>
												<th scope="col">Faction</th>
												<th scope="col">Level</th>
											</tr>
										</thead>
										<tbody>


											<?php
											$db_request = new db_request();
											$rows = $db_request->getAllMemberInfoOrderBy('level');
											$i = 1;
											if (!empty($rows)) {
												foreach ($rows as $row) {

													$member = $db_request->getMemberByTornID($row['tornID']);

													?>
																										<tr<?php if ($_SESSION['userid'] == $row['tornID']) {echo " style='background-color: #c3ebc9;' ";} ?>>
														<td><?php echo $i;?></td>
														<td><a href="https://www.torn.com/profiles.php?XID=<?php echo $row['tornID'];?>" target="_blank"><?php echo $member['tornName'];?></a></td>
														<td><a href="https://www.torn.com/factions.php?step=profile&ID=<?php echo $member['factionID'];?>"target="_blank"><?php
														switch ($member['factionID']) {
															case '13784':
															echo "Warbirds";
															break;
															case '30085':
															echo "WBNG";
															break;
															case '35507':
															echo "The Nest";
															break;
															case '37132':
															echo "Fowl Med";
															break;
															default:
															echo "N/A";
															break;
														}?></a></td>
														<td><?php echo $row['level'];?></td>
													</tr>
													<?php
													$i++;
												}
											}
											?>


										</tbody>
									</table>
								</div>

							</div>
						</div>



					</div>
				</div>
			</div>

    </div>

		<div class="row">
			<div class="container-fluid">

				<div class="row">
					<div class="col pt-3 mx-auto">
						<div class="card border border-dark shadow rounded mt-4">
							<h5 class="card-header">Member Stats</h5>
							<div class="card-body">

								<?php
								$db_request_faction = new db_request();
								$faction = $db_request_faction->getFactionByFactionID($_SESSION['factionid']);

								if ($faction) {
									$factionName = $faction['factionName'];
								}

								?>

								<ul class="nav nav-pills nav-justified flex-column flex-md-row my-2" id="memberTabs" role="tablist">
									<li class="nav-item mx-2 mb-2">
										<a class="flex-md-fill nav-link border border-dark" id="week-tab" data-fid="<?php echo $_SESSION['factionid']; ?>" data-timeline="week" data-toggle="tab" href="#week-<?php echo $_SESSION['factionid']; ?>" role="tab"><?php echo $factionName; ?>: 7 Days</a>
									</li>
									<li class="nav-item  mx-2 mb-2">
										<a class="flex-md-fill nav-link border border-dark" id="month-tab" data-fid="<?php echo $_SESSION['factionid']; ?>" data-timeline="month" data-toggle="tab" href="#month-<?php echo $_SESSION['factionid']; ?>" role="tab"><?php echo $factionName; ?>: 30 Days</a>
									</li>
								</ul>
								<div class="tab-content" id="memberTabsContent">
									<?php
									$faction = $_SESSION['factionid'];
									?>


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



								</div>

							</div> <!-- card-body -->
						</div> <!-- card -->
					</div> <!-- col -->
				</div> <!-- row -->


			</div> <!-- container -->
		</div>

</div> <!-- container-fluid -->
</div> <!-- content -->

<script type="text/javascript">

document.addEventListener('DOMContentLoaded', function () {

  Highcharts.theme = {
    "colors": ["#3366cc", "#dc3912", "#ff9900", "#109618", "#990099", "#0099c6", "#dd4477" ,"#66aa00", "#b82e2e", "#316395", "#994499", "#22aa99", "#aaaa11", "#6633cc", "#e67300"],
  };

  Highcharts.setOptions({
    lang: {
      decimalPoint: '.',
      thousandsSep: ','
    }
  });

  Highcharts.setOptions(Highcharts.theme);


  var chartdata = [{
    name: 'Pending',
    y: <?php echo (int)$json["personalstats"]["networthpending"] ?>
  }, {
    name: 'Wallet',
    y: <?php echo (int)$json["personalstats"]["networthwallet"] ?>
  }, {
    name: 'Bank',
    y: <?php echo (int)$json["personalstats"]["networthbank"] ?>
  }, {
    name: 'Points',
    y: <?php echo (int)$json["personalstats"]["networthpoints"] ?>
  }, {
    name: 'Cayman Islands',
    y: <?php echo (int)$json["personalstats"]["networthcayman"] ?>
  }, {
    name: 'Vault',
    y: <?php echo (int)$json["personalstats"]["networthvault"] ?>
  }, {
    name: 'Piggy Bank',
    y: <?php echo (int)$json["personalstats"]["networthpiggybank"] ?>
  }, {
    name: 'Items',
    y: <?php echo (int)$json["personalstats"]["networthitems"] ?>
  }, {
    name: 'Display Case',
    y: <?php echo (int)$json["personalstats"]["networthdisplaycase"] ?>
  }, {
    name: 'Bazaar',
    y: <?php echo (int)$json["personalstats"]["networthbazaar"] ?>
  }, {
    name: 'Properties',
    y: <?php echo (int)$json["personalstats"]["networthproperties"] ?>
  }, {
    name: 'Stock Market',
    y: <?php echo (int)$json["personalstats"]["networthstockmarket"] ?>
  }, {
    name: 'Auction House',
    y: <?php echo (int)$json["personalstats"]["networthauctionhouse"] ?>
  }, {
    name: 'Company',
    y: <?php echo (int)$json["personalstats"]["networthcompany"] ?>
  }, {
    name: 'Bookie',
    y: <?php echo (int)$json["personalstats"]["networthbookie"] ?>
  }];

  chartdata.forEach(function(element, index) {
    if (element.y === 0) {
      chartdata.splice(index, 1);
    }
  });

  var myChart = Highcharts.chart('networth', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: ''
    },
    tooltip: {
      headerFormat: '<small>{point.key}: {point.percentage:.1f}%</small><br>',
      pointFormat: '<b>${point.y:,.0f}</b>',
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: false
        },
        showInLegend: true,
      }
    },
    legend: {
      align: 'center',
      verticalAlign: 'bottom',
      layout: 'horizontal',
    },
    series: [{
      name: 'Networth',
      colorByPoint: true,
      dataSorting: {
        enabled: true
      },
      data: chartdata
    }],
    credits: {
      enabled: false
    }
  });

  myChart.series[0].data.sort(function(a, b) {
    return b.y - a.y;
  });

  var newData = {};

  for (var i = 0; i < myChart.series[0].data.length; i++) {
    newData.x = i;
    newData.y = myChart.series[0].data[i].y;
    newData.color = Highcharts.getOptions().colors[i];

    myChart.series[0].data[i].update(newData, false);

    // Workaround:
    myChart.legend.colorizeItem(myChart.series[0].data[i], myChart.series[0].data[i].visible);
  }

  myChart.redraw({ duration: 100 });
});
</script>
<script type="text/javascript" src="js/memberstats.js"></script>
<script>
$(document).ready(function() {
  $('.leaderboard_table').DataTable( {
    "paging":   true,
    "ordering": false,
    "info":     false,
    "pagingType": "numbers",
    "lengthChange": false,
		"pageLength": 10
  } );

	$('#week-tab').click();
} );
</script>
<?php
include('includes/footer.php');
?>
