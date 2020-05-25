<?php
//##### GUEST & MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Welcome!'; //Add whatever title you wish here. This will be displayed in the tab of your browser
include('includes/header.php'); //required to include basic bootstrap and javascript files
?>



<?php
//determine if user is an admin, leadership, member, or guest and include appropriate navbar file
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
  include('includes/navbar-guest.php');
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

<?php
if (empty($_SESSION['factionid'])) {
  $_SESSION = array();
  $_SESSION['error'] = "You are not logged in.";
  header("Location: /index.php");
} else {

  $filename = __DIR__. '/../TornAPIs/' . $_SESSION['factionid'] . "/".$_SESSION['userid'].".json";
  if (file_exists($filename)) {
    $data = unserialize(file_get_contents($filename));
    $json = json_decode($data, true); // decode the JSON feed
    //print("<pre>".print_r($json,true)."</pre>");
  } else {
    $_SESSION = array();
    $_SESSION['error'] = "You are not logged in.";
    header("Location: /index.php");
  }
}

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
    echo '<div class="alert alert-success my-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4" role="alert">'.$_SESSION['success'].'</div>';
    unset($_SESSION['success']);
  }
  ?>
  <div class="container-fluid pt-2 no-gutters">

    <!-- Leaderboard Card -->
    <div class="pt-3 col col-md-10 offset-md-1 col-lg-8 offset-lg-2">
      <div class="card border border-dark shadow rounded">
        <h5 class="card-header">Warbirds Rank</h5>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>Rank #1</b>: Heasleys4hemp</li>
            <li class="list-group-item"><b>Rank #2</b>: Deca</li>
            <li class="list-group-item"><b>Rank #3</b>: Vulture</li>
          </ul>

        </div>
      </div>
    </div> <!-- col -->

    <div class="row">
      <!-- Battle Stats Card -->
      <div class="pt-3 col-sm-12 col-md-6 col-xl-4">
        <div class="card border border-dark shadow rounded h-100">
          <h5 class="card-header">Battle Stats</h5>
          <div class="card-body">

            <ul class="list-group list-group-flush">
              <li class="list-group-item"><b>Strength</b>: <?php echo number_format($json['strength']); ?></li>
              <li class="list-group-item"><b>Defense</b>: <?php echo number_format($json['defense']); ?></li>
              <li class="list-group-item"><b>Speed</b>: <?php echo number_format($json['speed']); ?></li>
              <li class="list-group-item"><b>Dexterity</b>: <?php echo number_format($json['dexterity']); ?></li>
              <li class="list-group-item"><b>Total</b>: <?php echo number_format($json['total']); ?></li>
            </ul>

          </div>
        </div>
      </div> <!-- col -->
      <!-- Networth Card -->
      <div class="pt-3 col-sm-12 col-md-6 col-xl-4">
        <div class="card border border-dark shadow rounded h-100">
          <h5 class="card-header">Networth: $<?php echo number_format($json["personalstats"]["networth"]); ?></h5>
          <div class="card-body">

            <div id="networthchart" style="height: 100%;"></div>

          </div>
        </div>
      </div> <!-- col -->

       <!-- Report Card Card -->
      <div class="pt-3 col-sm-12 col-md-6 col-xl-4">
        <div class="card border border-dark shadow rounded h-100">
          <h5 class="card-header">Report Card</h5>
          <div class="card-body">

            <span>Coming soon...</span>

          </div>
        </div>
      </div> <!-- col -->

    </div>


    <!-- div class="col pt-3">
      <div class="card border border-dark shadow rounded">
        <h5 class="card-header">Test</h5>
        <div class="card-body">

          <div id="sizer">
            <div class="d-block d-sm-none d-md-none d-lg-none d-xl-none" data-size="xs">xs</div>
            <div class="d-none d-sm-block d-md-none d-lg-none d-xl-none" data-size="sm">sm</div>
            <div class="d-none d-sm-none d-md-block d-lg-none d-xl-none" data-size="md">md</div>
            <div class="d-none d-sm-none d-md-none d-lg-block d-xl-none" data-size="lg">lg</div>
            <div class="d-none d-sm-none d-md-none d-lg-none d-xl-block" data-size="xl">xl</div>
          </div>

        </div>
      </div>
    </div --> <!-- col -->

  </div> <!-- container-fluid -->
</div> <!-- content -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

  var data = google.visualization.arrayToDataTable([
    ['Networth', 'Value'],
    ['Pending: $<?php echo number_format($json["personalstats"]["networthpending"]); ?>', <?php echo (int)$json["personalstats"]["networthpending"] ?>],
    ['Wallet: $<?php echo number_format($json["personalstats"]["networthwallet"]); ?>', <?php echo (int)$json["personalstats"]["networthwallet"] ?>],
    ['Bank: $<?php echo number_format($json["personalstats"]["networthbank"]); ?>', <?php echo (int)$json["personalstats"]["networthbank"] ?>],
    ['Points: $<?php echo number_format($json["personalstats"]["networthpoints"]); ?>', <?php echo (int)$json["personalstats"]["networthpoints"] ?>],
    ['Cayman Islands: $<?php echo number_format($json["personalstats"]["networthcayman"]); ?>', <?php echo (int)$json["personalstats"]["networthcayman"] ?>],
    ['Vault: $<?php echo number_format($json["personalstats"]["networthvault"]); ?>', <?php echo (int)$json["personalstats"]["networthvault"] ?>],
    ['Piggy Bank: $<?php echo number_format($json["personalstats"]["networthpiggybank"]); ?>', <?php echo (int)$json["personalstats"]["networthpiggybank"] ?>],
    ['Items: $<?php echo number_format($json["personalstats"]["networthitems"]); ?>', <?php echo (int)$json["personalstats"]["networthitems"] ?>],
    ['Display Case: $<?php echo number_format($json["personalstats"]["networthdisplaycase"]); ?>', <?php echo (int)$json["personalstats"]["networthdisplaycase"] ?>],
    ['Bazaar: $<?php echo number_format($json["personalstats"]["networthbazaar"]); ?>', <?php echo (int)$json["personalstats"]["networthbazaar"] ?>],
    ['Properties: $<?php echo number_format($json["personalstats"]["networthproperties"]); ?>', <?php echo (int)$json["personalstats"]["networthproperties"] ?>],
    ['Stock Market: $<?php echo number_format($json["personalstats"]["networthstockmarket"]); ?>', <?php echo (int)$json["personalstats"]["networthstockmarket"] ?>],
    ['Auction House: $<?php echo number_format($json["personalstats"]["networthauctionhouse"]); ?>', <?php echo (int)$json["personalstats"]["networthauctionhouse"] ?>],
    ['Company: $<?php echo number_format($json["personalstats"]["networthcompany"]); ?>', <?php echo (int)$json["personalstats"]["networthcompany"] ?>],
    ['Bookie: $<?php echo number_format($json["personalstats"]["networthbookie"]); ?>', <?php echo (int)$json["personalstats"]["networthbookie"] ?>]
  ]);

  var formatter = new google.visualization.NumberFormat({pattern:'$###,###'});
  formatter.format(data,1);

  var options = {
    legend: {position: 'right', alignment: 'center'},
    width: '100%',
    chartArea:{width:'100%',height:'100%'},
    titleTextStyle: {fontSize: 16},
    reverseCategories: true
  };

  var chart = new google.visualization.PieChart(document.getElementById('networthchart'));
  data.sort([{column: 1}]);
  chart.draw(data, options);

  //create trigger to resizeEnd event
  $(window).resize(function() {
      if(this.resizeTO) clearTimeout(this.resizeTO);
      this.resizeTO = setTimeout(function() {
          $(this).trigger('resizeEnd');
      }, 100);
  });

  //redraw graph when window resize is completed
  $(window).on('resizeEnd', function() {
      drawChart(data);
  });
}



</script>
<?php
include('includes/footer.php');
?>
