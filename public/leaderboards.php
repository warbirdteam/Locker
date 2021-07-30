<?php
//##### MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Leaderboard';
include('includes/header.php');
?>

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

if ($_SESSION['roleValue'] <= 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
  $_SESSION['error'] = "You do not have access to that area.";
  header("Location: /welcome.php");
}
?>

<div class="container-fluid pt-2 no-gutters">

  <div class="row">
    <div class="col pt-3 mx-auto">
      <div class="card border border-dark shadow rounded mt-4">
        <h5 class="card-header">Warbirds Family Leaderboards</h5>
        <div class="card-body">

          <div class="row">



            <div class="pt-3 col-sm-12 col-lg-6 col-xl-4">
              <div class="card">
                <div class="card-body">


                  <ul class="nav nav-tabs mb-1" role="tablist">
                    <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="networth-tab" data-bs-toggle="tab" href="#networth" role="tab" aria-controls="networth" aria-selected="true">Networth</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a class="nav-link" id="awards-tab" data-bs-toggle="tab" href="#awards" role="tab" aria-controls="awards" aria-selected="false">Awards</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a class="nav-link" id="level-tab" data-bs-toggle="tab" href="#level" role="tab" aria-controls="level" aria-selected="false">Level</a>
                    </li>
                  </ul>

                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="networth" role="tabpanel" aria-labelledby="networth-tab">

                      <div class="table-responsive">
                        <table id="networth_table" class="table table-sm compact leaderboard_table border border-dark" style="width:100%">
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








          </div> <!-- row -->
        </div> <!-- card-body -->
      </div> <!-- card -->
    </div> <!-- col -->
  </div> <!-- row -->


</div> <!-- container -->
<script>
$(document).ready(function() {
  $('.leaderboard_table').DataTable( {
    "paging":   true,
    "ordering": true,
    "info":     false,
    "pagingType": "numbers",
    "lengthChange": false,
  } );
} );
</script>
<?php
include('includes/footer.php');
?>
