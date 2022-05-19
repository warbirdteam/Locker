<?php
//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Faction Members';
include('includes/header.php');
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>

<?php
include('includes/navbar-logged.php');

if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership' || $_SESSION['role'] == 'member') {
	//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
	exit;
}
?>

<div class="container">

	<div class="row">
		<div class="col pt-3 mx-auto">
			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Faction</h5>
				<div class="card-body">

					<ul class="nav nav-tabs" id="memberTabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="nest-members-tab" data-bs-toggle="tab" href="#faction-35507" role="tab">Nest</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="wb-members-tab" data-bs-toggle="tab" href="#faction-13784" role="tab">Warbirds</a>
						</li>
					</ul>
					<div class="tab-content" id="memberTabsContent">
						<br>

						<?php
						$db_request = new db_request();
						$factions = $db_request->getAllFactionIDs();

						foreach ($factions as $faction) {

							$rows = $db_request->getFactionMembersByFaction($faction);
							$count = $db_request->row_count;
							?>
							<div class="tab-pane fade show<?php if ($faction == "35507") {echo " active";}?>" id="faction-<?php echo $faction;?>" role="tabpanel">

							<div class="col-12 col-md-10 col-lg-10 col-xl-8 mx-auto mb-4">
								<div class="card border border-dark shadow rounded mt-4">
									<div class="card-body">
										<select class="custom-select faction_graphs_select" data-factionid="<?php echo $faction;?>">
											<option value="respect">Respect</option>
											<option value="territoryrespect">Respect from Territories</option>
											<option value="gymenergy">Gym Energy Trained</option>
											<option value="gymstrength">Strength Energy Trained</option>
											<option value="gymspeed">Speed Energy Trained</option>
											<option value="gymdefense">Defense Energy Trained</option>
											<option value="gymdexterity">Dexterity Energy Trained</option>
											<option value="drugsused">Drugs Used</option>
											<option value="drugoverdoses">Overdoses</option>
											<option value="attackswon">Attacks Won</option>
											<option value="attackslost">Attacks Lost</option>
											<option value="criminaloffences">Criminal Offences</option>
											<option value="organisedcrimemoney">OC Profit</option>
										</select>
										<div class="card-box mx-3">
													<div class="faction_graphs" data-factionid="<?php echo $faction;?>"></div>
										</div>

									</div> <!-- card-body -->
								</div> <!-- card -->
							</div> <!-- col -->

								<div class="table-responsive">
									<table class="faction_member_table table table-hover table-dark" border=1>
										<thead class="thead-dark">
											<tr>
												<th scope="col" class="text-truncate sorter-false">#</th>
												<th scope="col" class="text-truncate">Name</th>
												<th scope="col" class="text-truncate" data-bs-toggle="tooltip" data-placement="top" title="Days in Faction">DiF</th>
												<th scope="col" class="text-truncate">Last Action</th>
												<th scope="col" class="text-truncate">Status</th>
											</tr>
										</thead>
										<tbody>

											<?php
											if ($count > 0) {
												foreach ($rows as $tornID=>$row){
													$class = "";
													$laclass = ($row['last_action'] <= strtotime('-24 hours')) ? 'class="table-danger"' : '';
													$title = round((time() - $row['last_action'])/60/60);
													$title .= ' hours ago';
													if (strpos($row['status_desc'], 'In federal jail') !== false) {$class = 'class="table-danger"';}
													if (strpos($row['status_details'], 'Resting in Peace') !== false) {$class = 'class="table-info"';$row['status_desc'] = "";}
													echo '<tr ' . $class . '><td></td><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $tornID . '" target="_blank">' . $row['tornName'] . ' [' . $tornID . ']</a></td><td>'  . $row['days_in_faction'] . '</td><td '.$laclass.' data-bs-toggle="tooltip" data-placement="left" title="'.$title.'">'. date('m-d-Y H:i:s',$row["last_action"]) . '</td><td>' . $row['status_desc'] . ' ' . $row['status_details'] . '</td></tr>';
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

<script type="text/javascript">

document.addEventListener('DOMContentLoaded', function () {

  Highcharts.theme = {
    "colors": ["#3366cc", "#dc3912", "#ff9900", "#109618", "#990099", "#0099c6", "#dd4477" ,"#66aa00", "#b82e2e", "#316395", "#994499", "#22aa99", "#aaaa11", "#6633cc", "#e67300"],
  };


  Highcharts.setOptions(Highcharts.theme);

	var options = {
	    lang: {
	      decimalPoint: '.',
	      thousandsSep: ',',
				noData: "No data available for your faction"
	    },
			credits: {
				enabled: false
			},
			title: {
	        text: 'Total Respect'
	    },
			tooltip: {
					pointFormat: '<b>{series.name}:</b> {point.y:,.0f}',
					xDateFormat: '%d %b %Y',
					shared: true
			},
			xAxis: {
						type: 'datetime',
						labels: {
							formatter: function() {
								return Highcharts.dateFormat("%d %b %Y", this.value);
							},
							step: 3
						},
			},
			yAxis: {
					title: {
							text: null
					},
					labels: {
						formatter: function() {
							return (this.value / 1000000).toFixed(2) + 'M';
						}
					}
			},
			noData: {
					style: {
							fontWeight: 'bold',
							fontSize: '15px',
							color: '#303030'
					}
			}
	}


	$('.faction_graphs').each(function(index) {
		var factionid = $(this).data('factionid');
		Highcharts.chart($(this)[0], options);
	});

$('.faction_graphs_select').change(function() {
	var chartsId = $(this).next('.card-box').find('.faction_graphs').find('.highcharts-container').attr("id");
	let faction_chart = Highcharts.charts.find(c => c.container.id == chartsId);

	var type = $(this).val();
	var factionid = $(this).data('factionid');
	var name = $(this).find("option:selected").text();

	const types  = ["respect","criminaloffences","gymtrains","gymstrength","gymdefense","gymspeed","gymdexterity","attacksdamagehits","attacksdamage","hosps","attackslost","hosptimereceived","rehabs","traveltime","hosptimegiven","attacksmug","attackswon","alcoholused","drugsused","attacksrunaway","traveltimes","medicalitemsused","medicalcooldownused","jails","attacksdamaging","attacksleave","medicalitemrecovery","energydrinkused","busts", "drugoverdoses", "attackshosp", "candyused", "hunting", "organisedcrimerespect", "organisedcrimemoney", "organisedcrimesuccess", "organisedcrimefail", "revives", "territoryrespect", "caymaninterest", "highestterritories", "bestchain","gymenergy"];
	const found = types.find(element => element == type);



	if (found != undefined) {

		$.ajax({
			method: "POST",
			url: "process/getFactionStats.php",
			data: { type: found, factionid: factionid }
		})

		.done(function( data ) {
			if (data.includes('Error')) {
				faction_chart.update({
					title: {
			        text: 'Error'
			    },
					series: [{
			        name: "Error",
			        data: NULL
			    }]
	    	}, true, true);
			} else {
				var dd = JSON.parse(data);

				faction_chart.update({
					title: {
			        text: 'Total ' + name
			    },
					series: [{
			        name: name,
			        data: dd
			    }]
	    	}, true, true);

				if (dd[0]["y"] < 1000) {
					faction_chart.update({
						yAxis: {
							labels: {
				        formatter: function() {
				          return this.value;
				        }
				      }
						}
					});
				}

				if (dd[0]["y"] > 1000 && dd[0]["y"] < 1000000) {
					faction_chart.update({
						yAxis: {
							labels: {
				        formatter: function() {
				          return (this.value / 1000).toFixed(2) + 'K';
				        }
				      }
						}
					});
				}

				if (dd[0]["y"] > 1000000 && dd[0]["y"] < 1000000000) {
					faction_chart.update({
						yAxis: {
							labels: {
				        formatter: function() {
				          return (this.value / 1000000).toFixed(2) + 'M';
				        }
				      }
						}
					});
				}

				if (dd[0]["y"] > 1000000000 && dd[0]["y"] < 1000000000000) {
					faction_chart.update({
						yAxis: {
							labels: {
				        formatter: function() {
				          return (this.value / 1000000000).toFixed(2) + 'B';
				        }
				      }
						}
					});
				}

				if (dd[0]["y"] > 1000000000000 && dd[0]["y"] < 1000000000000000) {
					faction_chart.update({
						yAxis: {
							labels: {
				        formatter: function() {
				          return (this.value / 1000000000000).toFixed(2) + 'T';
				        }
				      }
						}
					});
				}

			} //else
		});
	}

	});

	$('.faction_graphs_select').each(function(index) {
		$(this).val('respect');
		$(this).trigger('change');
	});
});



</script>

<?php
include('includes/footer.php');
?>
