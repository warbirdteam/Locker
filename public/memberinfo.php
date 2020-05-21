<?php
//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Member Information';
include('includes/header.php');
?>



<?php
	switch ($_SESSION['role']) {
	    case 'admin':
	        include('includes/navbar-admin.php');
	        break;
	    case 'leadership':
	        include('includes/navbar-leadership.php');
	        break;
	    case 'member':
	        include('includes/navbar-member.php');
	        break;
	    case 'guest':
          $_SESSION['error'] = "You do not have access to that area.";
	        header("Location: /welcome.php");
	        break;
    default:
        $_SESSION = array();
        $_SESSION['error'] = "You are no longer logged in.";
        header("Location: /index.php");
        break;
	}

// Load classes
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
    				<a class="nav-link active" id="nest-members-week-tab" data-toggle="tab" href="#week-35507" role="tab">Nest: 7 Days</a>
    				</li>
            <li class="nav-item">
    				<a class="nav-link" id="nest-members-month-tab" data-toggle="tab" href="#month-35507" role="tab">Nest: 30 Days</a>
    				</li>
    				<li class="nav-item">
    				<a class="nav-link" id="wb-members-week-tab" data-toggle="tab" href="#week-13784" role="tab">Warbirds: 7 Days</a>
    				</li>
            <li class="nav-item">
    				<a class="nav-link" id="wb-members-month-tab" data-toggle="tab" href="#month-13784" role="tab">Warbirds: 30 Days</a>
    				</li>
    				<li class="nav-item">
    				<a class="nav-link" id="wbng-members-week-tab" data-toggle="tab" href="#week-30085" role="tab">WBNG: 7 Days</a>
    				</li>
            <li class="nav-item">
    				<a class="nav-link" id="wbng-members-month-tab" data-toggle="tab" href="#month-30085" role="tab">WBNG: 30 Days</a>
    				</li>
    			</ul>
	<div class="tab-content" id="memberTabsContent">
<?php

$factions = array( "35507", "13784", "30085" );

foreach ($factions as $faction) { ?>


		<div class="tab-pane fade<?php if($faction == '35507'){echo ' show active';}?>" id="week-<?php echo $faction;?>" role="tabpanel">
      <div class="table-responsive">
			<table class="table table-hover table-striped table-dark table-fit table-sm" border=1>
        <thead class="thead-dark">
					<tr>
						<th scope="col" class="text-truncate">Name</th>
						<th scope="col" class="text-truncate">Donator</th>
						<th scope="col" class="text-truncate">Property</th>
						<th scope="col" class="text-truncate">Last Action</th>
            <th scope="col" class="text-truncate">XanScore<i class="far fa-copyright"></i></th>
						<th scope="col" class="text-truncate">Xanax</th>
						<th scope="col" class="text-truncate">ODs</th>
						<th scope="col" class="text-truncate">Energy Rx</th>
						<th scope="col" class="text-truncate">Nerve Rx</th>
						<th scope="col" class="text-truncate">Boosters</th>
						<th scope="col" class="text-truncate">Cans</th>
						<th scope="col" class="text-truncate">SEs</th>
						<th scope="col" class="text-truncate">Travels</th>
						<th scope="col" class="text-truncate">Dump</th>
					</tr>
				</thead>
			<tbody>
<?php
			$db_member_list = new DB_request();
			$rows = $db_member_list->getFactionMembersByFaction($faction);
			$count = $db_member_list->row_count;

			if($count > 0){
				$counter = 0;
				foreach ($rows as $row){



					$db_memberinfo = new DB_request();
					$data = $db_memberinfo->getMemberInfoByIDWeek($row['userid']);
					$membercount = $db_memberinfo->row_count;

          if ($membercount > 0){
							$counter++;
							$lastactionclass = ($row['last_action'] <= strtotime('-24 hours')) ? 'class="fit bg-danger"' : 'class="fit"';
							$title = round((time() - $row['last_action'])/60/60);
							$title .= ' hours ago';

							$propertyclass = strpos($data[0]["property"],'Private Island') !== false ? 'class="fit"' : 'class="fit bg-danger"';

							$donatorclass = $data[0]['donator'] == 0 ? 'class="fit bg-danger"' : 'class="fit"';

							echo '<tr><td class="fit"><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $data[0]["userid"] . '" target="_blank">' . $row["name"] . ' [' . $data[0]["userid"] . ']</a></td><td ' . $donatorclass . '>'  . $data[0]["donator"] . '</td><td ' . $propertyclass . '>'. $data[0]["property"] . '</td><td data-toggle="tooltip" data-placement="left" title="'.$title.'" '. $lastactionclass .'>'. date('m-d-Y H:i:s',$row["last_action"]) . '</td><td class="fit">'.number_format((float)$data[0]["xanscore"], 2, '.', '').'</dt><td class="fit">'.$data[0]["xanaxweek"].'</td><td class="fit">'.$data[0]["overdosedweek"].'</td><td class="fit">'.$data[0]["refill_energyweek"].'</td><td class="fit">'.$data[0]["refill_nerveweek"].'</td><td class="fit">'.$data[0]["boostersusedweek"].'</td><td class="fit">'.$data[0]["energydrinkusedweek"].'</td><td class="fit">'.$data[0]["statenhancersusedweek"].'</td><td class="fit">'.$data[0]["travelweek"].'</td><td class="fit">'.$data[0]["dumpsearchesweek"].'</td></tr>';
					}
				}
			} else {
				echo '<tr><td colspan=14 align=center>No members found...</td></tr>';
			}
?>
			</tbody>
				<tfoot>
					<tr>
						<td colspan=14 align=center>Total: <?php echo $counter . '/' . $count;?> </td>
					</tr>
				</tfoot>
			</table>
		  </div>

		</div>


		<div class="tab-pane fade" id="month-<?php echo $faction;?>" role="tabpanel">
			<div class="table-responsive">
			<table class="table table-hover table-striped table-dark table-fit table-sm" border=1>
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="text-truncate">Name</th>
						<th scope="col" class="text-truncate">Donator</th>
						<th scope="col" class="text-truncate">Property</th>
						<th scope="col" class="text-truncate">Last Action</th>
            <th scope="col" class="text-truncate">XanScore<i class="far fa-copyright"></i></th>
						<th scope="col" class="text-truncate">Xanax</th>
						<th scope="col" class="text-truncate">ODs</th>
						<th scope="col" class="text-truncate">Energy Rx</th>
						<th scope="col" class="text-truncate">Nerve Rx</th>
						<th scope="col" class="text-truncate">Boosters</th>
						<th scope="col" class="text-truncate">Cans</th>
						<th scope="col" class="text-truncate">SEs</th>
						<th scope="col" class="text-truncate">Travels</th>
						<th scope="col" class="text-truncate">Dump</th>
					</tr>
				</thead>
			<tbody>
<?php
			$db_member_list = new DB_request();
			$rows = $db_member_list->getFactionMembersByFaction($faction);
			$count = $db_member_list->row_count;

			if($count > 0){
				$counter = 0;
				foreach ($rows as $row){



					$db_memberinfo = new DB_request();
					$data = $db_memberinfo->getMemberInfoByIDMonth($row['userid']);
					$membercount = $db_memberinfo->row_count;

          if ($membercount > 0){
							$counter++;
							$lastactionclass = ($row['last_action'] <= strtotime('-24 hours')) ? 'class="fit bg-danger"' : 'class="fit"';
							$title = round((time() - $row['last_action'])/60/60);
							$title .= ' hours ago';

							$propertyclass = strpos($data[0]["property"],'Private Island') !== false ? 'class="fit"' : 'class="fit bg-danger"';

							$donatorclass = $data[0]['donator'] == 0 ? 'class="fit bg-danger"' : 'class="fit"';

							echo '<tr><td class="fit"><a class="text-reset" href="https://www.torn.com/profiles.php?XID=' . $data[0]["userid"] . '" target="_blank">' . $row["name"] . ' [' . $data[0]["userid"] . ']</a></td><td ' . $donatorclass . '>'  . $data[0]["donator"] . '</td><td ' . $propertyclass . '>'. $data[0]["property"] . '</td><td data-toggle="tooltip" data-placement="left" title="'.$title.'" '. $lastactionclass .'>'. date('m-d-Y H:i:s',$row["last_action"]) . '</td><td class="fit">'.number_format((float)$data[0]["xanscore"], 2, '.', '').'</dt><td class="fit">'.$data[0]["xanaxweek"].'</td><td class="fit">'.$data[0]["overdosedweek"].'</td><td class="fit">'.$data[0]["refill_energyweek"].'</td><td class="fit">'.$data[0]["refill_nerveweek"].'</td><td class="fit">'.$data[0]["boostersusedweek"].'</td><td class="fit">'.$data[0]["energydrinkusedweek"].'</td><td class="fit">'.$data[0]["statenhancersusedweek"].'</td><td class="fit">'.$data[0]["travelweek"].'</td><td class="fit">'.$data[0]["dumpsearchesweek"].'</td></tr>';
					}
				}
			} else {
				echo '<tr><td colspan=14 align=center>No members found...</td></tr>';
			}
?>
			</tbody>
				<tfoot>
					<tr>
						<td colspan=14 align=center>Total: <?php echo $counter . '/' . $count;?></td>
					</tr>
				</tfoot>
			</table>
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

  <?php
  include('includes/footer.php');
  ?>
