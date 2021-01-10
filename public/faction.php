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
?>

<?php
if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}

if ($_SESSION['roleValue'] <= 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}


$db_request = new db_request();
$faction = $db_request->getFactionByFactionID($_SESSION['factionid']);
if (empty($faction)) {
	$_SESSION['error'] = "There was an error accessing that page.";
	header("Location: /welcome.php");
}
?>
<div class="container">

	<div class="row">
		<div class="col pt-3 mx-auto">
			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header"><?php echo $faction['factionName']; ?></h5>
				<div class="card-body">
					<select class="custom-select" id="faction_graphs_select">
					  <option value="respect" selected>Respect</option>
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
                <div id="faction_graphs"></div>
      		</div>

				</div> <!-- card-body -->
			</div> <!-- card -->


</div> <!-- col -->
</div> <!-- row -->


</div> <!-- container -->

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
													if (strpos($row['status_desc'], 'In federal jail') !== false) {$class = 'class="bg-danger"';}
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
		$db_request_faction_data = new db_request();
		$graph_data = $db_request_faction_data->getFactionStatsByFactionIDAndType($_SESSION['factionid'], 'respect');
		print("<pre>".print_r($graph_data,true)."</pre>");
		$highchartData = "[";
		foreach ($graph_data as $row) {
			$highchartData .= '[new Date("'. $row["timestamp"] . '").getTime(), '. $row["data"] . '],';
		}

		$highchartData .= "]";

		echo $highchartData;

?>
<script type="text/javascript">

document.addEventListener('DOMContentLoaded', function () {

  Highcharts.theme = {
    "colors": ["#3366cc", "#dc3912", "#ff9900", "#109618", "#990099", "#0099c6", "#dd4477" ,"#66aa00", "#b82e2e", "#316395", "#994499", "#22aa99", "#aaaa11", "#6633cc", "#e67300"],
  };


  Highcharts.setOptions(Highcharts.theme);

	Highcharts.setOptions({
	    lang: {
	      decimalPoint: '.',
	      thousandsSep: ',',
				noData: "No data available for your faction"
	    }
	});

	var faction_chart = Highcharts.chart('faction_graphs', {
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
	    series: [{
	        name: 'Respect',
	        data: <?php echo $highchartData; ?>
	    }],
	    noData: {
	        style: {
	            fontWeight: 'bold',
	            fontSize: '15px',
	            color: '#303030'
	        }
	    }
	});

	$('#faction_graphs_select').change(function() {

	var type = $(this).val();
	var name = $( "#faction_graphs_select option:selected" ).text();

	const types  = ["respect","criminaloffences","gymtrains","gymstrength","gymdefense","gymspeed","gymdexterity","attacksdamagehits","attacksdamage","hosps","attackslost","hosptimereceived","rehabs","traveltime","hosptimegiven","attacksmug","attackswon","alcoholused","drugsused","attacksrunaway","traveltimes","medicalitemsused","medicalcooldownused","jails","attacksdamaging","attacksleave","medicalitemrecovery","energydrinkused","busts", "drugoverdoses", "attackshosp", "candyused", "hunting", "organisedcrimerespect", "organisedcrimemoney", "organisedcrimesuccess", "organisedcrimefail", "revives", "territoryrespect", "caymaninterest", "highestterritories", "bestchain","gymenergy"];
	const found = types.find(element => element == type);



	if (found != undefined) {

		$.ajax({
			method: "POST",
			url: "process/getFactionStats.php",
			data: { type: found }
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
});
</script>

<?php
include('includes/footer.php');
?>
