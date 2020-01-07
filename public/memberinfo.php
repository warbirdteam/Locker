<?php
session_start();
$_SESSION['title'] = 'Member Information';
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

<div class="container-fluid">

	<div class="row">
		<div class="col pt-3 mx-auto">
			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Member Information</h5>
				<div class="card-body">

          <ul class="nav nav-tabs" id="memberTabs" role="tablist">
    				<li class="nav-item">
    				<a class="nav-link active" id="nest-members-week-tab" data-toggle="tab" href="#nest-members-week" role="tab">Nest Members: 7 Days</a>
    				</li>
            <li class="nav-item">
    				<a class="nav-link" id="nest-members-month-tab" data-toggle="tab" href="#nest-members-month" role="tab">Nest Members: 30 Days</a>
    				</li>
    				<li class="nav-item">
    				<a class="nav-link" id="wb-members-week-tab" data-toggle="tab" href="#wb-members-week" role="tab">Warbirds Members: 7 Days</a>
    				</li>
            <li class="nav-item">
    				<a class="nav-link" id="wb-members-month-tab" data-toggle="tab" href="#wb-members-month" role="tab">Warbirds Members: 30 Days</a>
    				</li>
    				<li class="nav-item">
    				<a class="nav-link" id="wbng-members-week-tab" data-toggle="tab" href="#wbng-members-week" role="tab">WBNG Members: 7 Days</a>
    				</li>
            <li class="nav-item">
    				<a class="nav-link" id="wbng-members-month-tab" data-toggle="tab" href="#wbng-members-month" role="tab">WBNG Members: 30 Days</a>
    				</li>
    			</ul>

          <div class="tab-content" id="memberTabsContent">

            <div class="tab-pane fade active show" id="nest-members-week" role="tabpanel">

    					<table class="table table-hover table-striped table-dark" border=1>
    						<thead class="thead-dark">
    							<tr>
    								<th scope="col">Name</th>
    								<th scope="col">Donator</th>
                    <th scope="col">Property</th>
    								<th scope="col">Last Action</th>
    								<th scope="col">Xanax</th>
                    <th scope="col">Overdoses</th>
                    <th scope="col">Energy Refills</th>
                    <th scope="col">Nerve Refills</th>
                    <th scope="col">Consumables Used</th>
                    <th scope="col">Energy Drinks Used</th>
                    <th scope="col">Stat Enhancers Used</th>
                    <th scope="col">Times Travelled</th>
                    <th scope="col">Dump Searches</th>
    							</tr>
    						</thead>
    					<tbody>

    					<?php
    					$db_member_list = new DB_request();
    					$rows = $db_member_list->getFactionMembersByFaction('35507');
    					$count = $db_member_list->row_count;

    					if($count > 0){
    						foreach ($rows as $row){



                  $db_memberinfo = new DB_request();
                  $data = $db_memberinfo->getMemberInfoByIDWeek($row['userid']);
                  $membercount = $db_memberinfo->row_count;

                  if ($membercount > 0){
        							$lastactionclass = strpos( $row['last_action'], 'day ago' ) !== false || strpos( $row['last_action'], 'days ago' ) !== false ? 'class="bg-danger"' : '';

                      $propertyclass = strpos($data[0]["property"],'Private Island') !== false ? '' : 'class="bg-danger"';

        							echo '<tr><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $data[0]["userid"] . '" target="_blank">' . $row["name"] . ' [' . $data[0]["userid"] . ']</a></td><td>'  . $data[0]["donator"] . '</td><td ' . $propertyclass . '>'. $data[0]["property"] . '</td><td ' . $lastactionclass . '>'. $row["last_action"] . '</td><td>'.$data[0]["xanaxweek"].'</td><td>'.$data[0]["overdosedweek"].'</td><td>'.$data[0]["refill_energyweek"].'</td><td>'.$data[0]["refill_nerveweek"].'</td><td>'.$data[0]["consumablesusedweek"].'</td><td>'.$data[0]["energydrinkusedweek"].'</td><td>'.$data[0]["statenhancersusedweek"].'</td><td>'.$data[0]["travelweek"].'</td><td>'.$data[0]["dumpsearchesweek"].'</td></tr>';
                  } else {
                    echo '<tr><td colspan=13 align=center>No member data found...</td></tr>';
                  }
                }
    					} else {
                echo '<tr><td colspan=13 align=center>No members found...</td></tr>';
              }
    					?>

    					</tbody>
    						<tfoot>
    							<tr>
    								<td colspan=13 align=center>Total: <?php echo $count; ?></td>
    							</tr>
    						</tfoot>
    					</table>

    				</div>


            <div class="tab-pane fade" id="nest-members-month" role="tabpanel">

    					<table class="table table-hover table-striped table-dark" border=1>
    						<thead class="thead-dark">
    							<tr>
    								<th scope="col">Name</th>
    								<th scope="col">Donator</th>
                    <th scope="col">Property</th>
    								<th scope="col">Last Action</th>
    								<th scope="col">Xanax</th>
                    <th scope="col">Overdoses</th>
                    <th scope="col">Energy Refills</th>
                    <th scope="col">Nerve Refills</th>
                    <th scope="col">Consumables Used</th>
                    <th scope="col">Energy Drinks Used</th>
                    <th scope="col">Stat Enhancers Used</th>
                    <th scope="col">Times Travelled</th>
                    <th scope="col">Dump Searches</th>
    							</tr>
    						</thead>
    					<tbody>

    					<?php
    					$db_member_list = new DB_request();
    					$rows = $db_member_list->getFactionMembersByFaction('35507');
    					$count = $db_member_list->row_count;

    					if($count > 0){
    						foreach ($rows as $row){



                  $db_memberinfo = new DB_request();
                  $data = $db_memberinfo->getMemberInfoByIDMonth($row['userid']);
                  $membercount = $db_memberinfo->row_count;

                  if ($membercount > 0){
        							$lastactionclass = strpos( $row['last_action'], 'day ago' ) !== false || strpos( $row['last_action'], 'days ago' ) !== false ? 'class="bg-danger"' : '';

                      $propertyclass = strpos($data[0]["property"],'Private Island') !== false ? '' : 'class="bg-danger"';

        							echo '<tr><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $data[0]["userid"] . '" target="_blank">' . $row["name"] . ' [' . $data[0]["userid"] . ']</a></td><td>'  . $data[0]["donator"] . '</td><td ' . $propertyclass . '>'. $data[0]["property"] . '</td><td ' . $lastactionclass . '>'. $row["last_action"] . '</td><td>'.$data[0]["xanaxweek"].'</td><td>'.$data[0]["overdosedweek"].'</td><td>'.$data[0]["refill_energyweek"].'</td><td>'.$data[0]["refill_nerveweek"].'</td><td>'.$data[0]["consumablesusedweek"].'</td><td>'.$data[0]["energydrinkusedweek"].'</td><td>'.$data[0]["statenhancersusedweek"].'</td><td>'.$data[0]["travelweek"].'</td><td>'.$data[0]["dumpsearchesweek"].'</td></tr>';
                  } else {
                    echo '<tr><td colspan=13 align=center>No member data found...</td></tr>';
                  }
                }
    					} else {
                echo '<tr><td colspan=13 align=center>No members found...</td></tr>';
              }
    					?>

    					</tbody>
    						<tfoot>
    							<tr>
    								<td colspan=13 align=center>Total: <?php echo $count; ?></td>
    							</tr>
    						</tfoot>
    					</table>

    				</div>

            <div class="tab-pane fade" id="wb-members-week" role="tabpanel">

    					<table class="table table-hover table-striped table-dark" border=1>
    						<thead class="thead-dark">
    							<tr>
    								<th scope="col">Name</th>
    								<th scope="col">Donator</th>
                    <th scope="col">Property</th>
    								<th scope="col">Last Action</th>
    								<th scope="col">Xanax</th>
                    <th scope="col">Overdoses</th>
                    <th scope="col">Energy Refills</th>
                    <th scope="col">Nerve Refills</th>
                    <th scope="col">Consumables Used</th>
                    <th scope="col">Energy Drinks Used</th>
                    <th scope="col">Stat Enhancers Used</th>
                    <th scope="col">Times Travelled</th>
                    <th scope="col">Dump Searches</th>
    							</tr>
    						</thead>
    					<tbody>

    					<?php
    					$db_member_list = new DB_request();
    					$rows = $db_member_list->getFactionMembersByFaction('13784');
    					$count = $db_member_list->row_count;

    					if($count > 0){
    						foreach ($rows as $row){



                  $db_memberinfo = new DB_request();
                  $data = $db_memberinfo->getMemberInfoByIDWeek($row['userid']);
                  $membercount = $db_memberinfo->row_count;

                  if ($membercount > 0){
        							$lastactionclass = strpos( $row['last_action'], 'day ago' ) !== false || strpos( $row['last_action'], 'days ago' ) !== false ? 'class="bg-danger"' : '';

                      $propertyclass = strpos($data[0]["property"],'Private Island') !== false ? '' : 'class="bg-danger"';

        							echo '<tr><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $data[0]["userid"] . '" target="_blank">' . $row["name"] . ' [' . $data[0]["userid"] . ']</a></td><td>'  . $data[0]["donator"] . '</td><td ' . $propertyclass . '>'. $data[0]["property"] . '</td><td ' . $lastactionclass . '>'. $row["last_action"] . '</td><td>'.$data[0]["xanaxweek"].'</td><td>'.$data[0]["overdosedweek"].'</td><td>'.$data[0]["refill_energyweek"].'</td><td>'.$data[0]["refill_nerveweek"].'</td><td>'.$data[0]["consumablesusedweek"].'</td><td>'.$data[0]["energydrinkusedweek"].'</td><td>'.$data[0]["statenhancersusedweek"].'</td><td>'.$data[0]["travelweek"].'</td><td>'.$data[0]["dumpsearchesweek"].'</td></tr>';
                  } else {
                    echo '<tr><td colspan=13 align=center>No member data found...</td></tr>';
                  }
                }
    					} else {
                echo '<tr><td colspan=13 align=center>No members found...</td></tr>';
              }
    					?>

    					</tbody>
    						<tfoot>
    							<tr>
    								<td colspan=13 align=center>Total: <?php echo $count; ?></td>
    							</tr>
    						</tfoot>
    					</table>

    				</div>

            <div class="tab-pane fade" id="wb-members-month" role="tabpanel">

    					<table class="table table-hover table-striped table-dark" border=1>
    						<thead class="thead-dark">
    							<tr>
    								<th scope="col">Name</th>
    								<th scope="col">Donator</th>
                    <th scope="col">Property</th>
    								<th scope="col">Last Action</th>
    								<th scope="col">Xanax</th>
                    <th scope="col">Overdoses</th>
                    <th scope="col">Energy Refills</th>
                    <th scope="col">Nerve Refills</th>
                    <th scope="col">Consumables Used</th>
                    <th scope="col">Energy Drinks Used</th>
                    <th scope="col">Stat Enhancers Used</th>
                    <th scope="col">Times Travelled</th>
                    <th scope="col">Dump Searches</th>
    							</tr>
    						</thead>
    					<tbody>

    					<?php
    					$db_member_list = new DB_request();
    					$rows = $db_member_list->getFactionMembersByFaction('13784');
    					$count = $db_member_list->row_count;

    					if($count > 0){
    						foreach ($rows as $row){



                  $db_memberinfo = new DB_request();
                  $data = $db_memberinfo->getMemberInfoByIDMonth($row['userid']);
                  $membercount = $db_memberinfo->row_count;

                  if ($membercount > 0){
                      $lastactionclass = strpos( $row['last_action'], 'day ago' ) !== false || strpos( $row['last_action'], 'days ago' ) !== false ? 'class="bg-danger"' : '';

                      $propertyclass = strpos($data[0]["property"],'Private Island') !== false ? '' : 'class="bg-danger"';

        							echo '<tr><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $data[0]["userid"] . '" target="_blank">' . $row["name"] . ' [' . $data[0]["userid"] . ']</a></td><td>'  . $data[0]["donator"] . '</td><td ' . $propertyclass . '>'. $data[0]["property"] . '</td><td ' . $lastactionclass . '>'. $row["last_action"] . '</td><td>'.$data[0]["xanaxweek"].'</td><td>'.$data[0]["overdosedweek"].'</td><td>'.$data[0]["refill_energyweek"].'</td><td>'.$data[0]["refill_nerveweek"].'</td><td>'.$data[0]["consumablesusedweek"].'</td><td>'.$data[0]["energydrinkusedweek"].'</td><td>'.$data[0]["statenhancersusedweek"].'</td><td>'.$data[0]["travelweek"].'</td><td>'.$data[0]["dumpsearchesweek"].'</td></tr>';
                  } else {
                    echo '<tr><td colspan=13 align=center>No member data found...</td></tr>';
                  }
                }
    					} else {
                echo '<tr><td colspan=13 align=center>No members found...</td></tr>';
              }
    					?>

    					</tbody>
    						<tfoot>
    							<tr>
    								<td colspan=13 align=center>Total: <?php echo $count; ?></td>
    							</tr>
    						</tfoot>
    					</table>

    				</div>

            <div class="tab-pane fade" id="wbng-members-week" role="tabpanel">

    					<table class="table table-hover table-striped table-dark" border=1>
    						<thead class="thead-dark">
    							<tr>
    								<th scope="col">Name</th>
    								<th scope="col">Donator</th>
                    <th scope="col">Property</th>
    								<th scope="col">Last Action</th>
    								<th scope="col">Xanax</th>
                    <th scope="col">Overdoses</th>
                    <th scope="col">Energy Refills</th>
                    <th scope="col">Nerve Refills</th>
                    <th scope="col">Consumables Used</th>
                    <th scope="col">Energy Drinks Used</th>
                    <th scope="col">Stat Enhancers Used</th>
                    <th scope="col">Times Travelled</th>
                    <th scope="col">Dump Searches</th>
    							</tr>
    						</thead>
    					<tbody>

    					<?php
    					$db_member_list = new DB_request();
    					$rows = $db_member_list->getFactionMembersByFaction('30085');
    					$count = $db_member_list->row_count;

    					if($count > 0){
    						foreach ($rows as $row){



                  $db_memberinfo = new DB_request();
                  $data = $db_memberinfo->getMemberInfoByIDWeek($row['userid']);
                  $membercount = $db_memberinfo->row_count;

                  if ($membercount > 0){
        							$lastactionclass = strpos( $row['last_action'], 'day ago' ) !== false || strpos( $row['last_action'], 'days ago' ) !== false ? 'class="bg-danger"' : '';

                      $propertyclass = strpos($data[0]["property"],'Private Island') !== false ? '' : 'class="bg-danger"';

        							echo '<tr><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $data[0]["userid"] . '" target="_blank">' . $row["name"] . ' [' . $data[0]["userid"] . ']</a></td><td>'  . $data[0]["donator"] . '</td><td ' . $propertyclass . '>'. $data[0]["property"] . '</td><td ' . $lastactionclass . '>'. $row["last_action"] . '</td><td>'.$data[0]["xanaxweek"].'</td><td>'.$data[0]["overdosedweek"].'</td><td>'.$data[0]["refill_energyweek"].'</td><td>'.$data[0]["refill_nerveweek"].'</td><td>'.$data[0]["consumablesusedweek"].'</td><td>'.$data[0]["energydrinkusedweek"].'</td><td>'.$data[0]["statenhancersusedweek"].'</td><td>'.$data[0]["travelweek"].'</td><td>'.$data[0]["dumpsearchesweek"].'</td></tr>';
                  } else {
                    echo '<tr><td colspan=13 align=center>No member data found...</td></tr>';
                  }
                }
    					} else {
                echo '<tr><td colspan=13 align=center>No members found...</td></tr>';
              }
    					?>

    					</tbody>
    						<tfoot>
    							<tr>
    								<td colspan=13 align=center>Total: <?php echo $count; ?></td>
    							</tr>
    						</tfoot>
    					</table>

    				</div>

            <div class="tab-pane fade" id="wbng-members-month" role="tabpanel">

    					<table class="table table-hover table-striped table-dark" border=1>
    						<thead class="thead-dark">
    							<tr>
    								<th scope="col">Name</th>
    								<th scope="col">Donator</th>
                    <th scope="col">Property</th>
    								<th scope="col">Last Action</th>
    								<th scope="col">Xanax</th>
                    <th scope="col">Overdoses</th>
                    <th scope="col">Energy Refills</th>
                    <th scope="col">Nerve Refills</th>
                    <th scope="col">Consumables Used</th>
                    <th scope="col">Energy Drinks Used</th>
                    <th scope="col">Stat Enhancers Used</th>
                    <th scope="col">Times Travelled</th>
                    <th scope="col">Dump Searches</th>
    							</tr>
    						</thead>
    					<tbody>

    					<?php
    					$db_member_list = new DB_request();
    					$rows = $db_member_list->getFactionMembersByFaction('30085');
    					$count = $db_member_list->row_count;

    					if($count > 0){
    						foreach ($rows as $row){



                  $db_memberinfo = new DB_request();
                  $data = $db_memberinfo->getMemberInfoByIDMonth($row['userid']);
                  $membercount = $db_memberinfo->row_count;

                  if ($membercount > 0){
        							$lastactionclass = strpos( $row['last_action'], 'day ago' ) !== false || strpos( $row['last_action'], 'days ago' ) !== false ? 'class="bg-danger"' : '';

                      $propertyclass = strpos($data[0]["property"],'Private Island') !== false ? '' : 'class="bg-danger"';

        							echo '<tr><td><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $data[0]["userid"] . '" target="_blank">' . $row["name"] . ' [' . $data[0]["userid"] . ']</a></td><td>'  . $data[0]["donator"] . '</td><td ' . $propertyclass . '>'. $data[0]["property"] . '</td><td ' . $lastactionclass . '>'. $row["last_action"] . '</td><td>'.$data[0]["xanaxweek"].'</td><td>'.$data[0]["overdosedweek"].'</td><td>'.$data[0]["refill_energyweek"].'</td><td>'.$data[0]["refill_nerveweek"].'</td><td>'.$data[0]["consumablesusedweek"].'</td><td>'.$data[0]["energydrinkusedweek"].'</td><td>'.$data[0]["statenhancersusedweek"].'</td><td>'.$data[0]["travelweek"].'</td><td>'.$data[0]["dumpsearchesweek"].'</td></tr>';
                  } else {
                    echo '<tr><td colspan=13 align=center>No member data found...</td></tr>';
                  }
                }
    					} else {
                echo '<tr><td colspan=13 align=center>No members found...</td></tr>';
              }
    					?>

    					</tbody>
    						<tfoot>
    							<tr>
    								<td colspan=13 align=center>Total: <?php echo $count; ?></td>
    							</tr>
    						</tfoot>
    					</table>

    				</div>


          </div>

        </div> <!-- card-body -->
       </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->


  </div> <!-- container -->
