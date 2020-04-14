<?php
session_start();
$_SESSION['title'] = 'Welcome!'; //Add whatever title you wish here. This will be displayed in the tab of your browser
include('includes/header.php'); //required to include basic bootstrap and javascript files
//Add extra scripts/css below this. This could be tablesorter javascript files or custom css files
?>



<?php
//Add extra scripts/css before this.
//determine if user is an admin, leadership, member, or guest and include appropriate navbar file
switch ($_SESSION['role']) {
    case 'admin':
        include('includes/navbar-admin.php');
        break;
    case 'leadership':
        include('includes/navbar-leadership.php');
        break;
    case 'guest':
        include('includes/navbar-guest.php');
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Networth', 'Value'],
      ['Pending', <?php echo (int)$json["personalstats"]["networthpending"] ?>],
      ['Wallet', <?php echo (int)$json["personalstats"]["networthwallet"] ?>],
      ['Bank', <?php echo (int)$json["personalstats"]["networthbank"] ?>],
      ['Points', <?php echo (int)$json["personalstats"]["networthpoints"] ?>],
      ['Cayman Islands', <?php echo (int)$json["personalstats"]["networthcayman"] ?>],
      ['Vault', <?php echo (int)$json["personalstats"]["networthvault"] ?>],
      ['Piggy Bank', <?php echo (int)$json["personalstats"]["networthpiggybank"] ?>],
      ['Items', <?php echo (int)$json["personalstats"]["networthitems"] ?>],
      ['Display Case', <?php echo (int)$json["personalstats"]["networthdisplaycase"] ?>],
      ['Bazaar', <?php echo (int)$json["personalstats"]["networthbazaar"] ?>],
      ['Properties', <?php echo (int)$json["personalstats"]["networthproperties"] ?>],
      ['Stock Market', <?php echo (int)$json["personalstats"]["networthstockmarket"] ?>],
      ['Auction House', <?php echo (int)$json["personalstats"]["networthauctionhouse"] ?>],
      ['Company', <?php echo (int)$json["personalstats"]["networthcompany"] ?>],
      ['Bookie', <?php echo (int)$json["personalstats"]["networthbookie"] ?>]
    ]);

    var formatter = new google.visualization.NumberFormat({pattern:'$###,###'});
    formatter.format(data,1);

    var options = {
      title: 'Networth: $<?php echo number_format($json['networth']);?>',
      legend: {position: 'left', alignment: 'center'},
      width: '100%',
      chartArea:{width:'1000',height:'100%'},
      pieSliceText: 'none',
      titleTextStyle: {fontSize: 16}
    };

    var chart = new google.visualization.PieChart(document.getElementById('networthchart'));

    chart.draw(data, options);
  }
</script>

<?php
/*
<script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {
        callback: function () {
          drawChart();
          $(window).resize(drawChart);
        },
        packages:['corechart']
      });

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Type');
        data.addColumn('number', 'Money');
        data.addRows([
          ['Pending', <?php echo (int)$data["networth"]["pending"] ?>],
          ['Wallet', <?php echo (int)$data["networth"]["wallet"] ?>],
          ['Bank', <?php echo (int)$data["networth"]["bank"] ?>],
          ['Points', <?php echo (int)$data["networth"]["points"] ?>],
          ['Cayman Islands', <?php echo (int)$data["networth"]["cayman"] ?>],
          ['Vault', <?php echo (int)$data["networth"]["vault"] ?>],
          ['Piggy Bank', <?php echo (int)$data["networth"]["piggybank"] ?>],
          ['Items', <?php echo (int)$data["networth"]["items"] ?>],
          ['Display Case', <?php echo (int)$data["networth"]["displaycase"] ?>],
          ['Bazaar', <?php echo (int)$data["networth"]["bazaar"] ?>],
          ['Properties', <?php echo (int)$data["networth"]["properties"] ?>],
          ['Stock Market', <?php echo (int)$data["networth"]["stockmarket"] ?>],
          ['Auction House', <?php echo (int)$data["networth"]["auctionhouse"] ?>],
          ['Company', <?php echo (int)$data["networth"]["company"] ?>],
          ['Bookie', <?php echo (int)$data["networth"]["bookie"] ?>]
          //['Loan', <?php echo (int)$data["networth"]["loan"] ?>]
        ]);


        var formatter = new google.visualization.NumberFormat({pattern:'$###,###'});
        formatter.format(data,1);

        var options = {
          legend: {position: 'top'},
          height: 500
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data,options);
      }
    </script>

*/ ?>


<div class="content">

<div class="container-fluid pt-2">
  <div class="col pt-3">
   <div class="card border border-dark shadow rounded">
     <h5 class="card-header"><?php echo $_SESSION['username']; ?></h5>
     <div class="card-body">

       <div class="row">
  <div class="col-4">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-battlestats-list" data-toggle="list" href="#list-battlestats" role="tab" aria-controls="home">Battlestats</a>
      <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Networth</a>
    </div>
  </div>
  <div class="col-8">
    <div class="tab-content" id="nav-tabContent">

      <div class="tab-pane fade show active" id="list-battlestats" role="tabpanel" aria-labelledby="list-battlestats-list">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><b>Strength</b>: <?php echo number_format($json['strength']); ?></li>
          <li class="list-group-item"><b>Defense</b>: <?php echo number_format($json['defense']); ?></li>
          <li class="list-group-item"><b>Speed</b>: <?php echo number_format($json['speed']); ?></li>
          <li class="list-group-item"><b>Dexterity</b>: <?php echo number_format($json['dexterity']); ?></li>
          <li class="list-group-item"><b>Total</b>: <?php echo number_format($json['total']); ?></li>
        </ul>
      </div>

      <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
            <div id="networthchart"></div>
      </div>

    </div>
  </div>
</div>

     </div>
   </div>
  </div> <!-- col -->
</div>

<div class="container-fluid mt-3">

	<div class="row pb-3">

		 <div class="col-lg-9 col-md-6 pt-3" hidden>
			<div class="card border border-dark shadow rounded">
			  <h5 class="card-header">Networth: $</h5>
			  <div class="card-body">



			  </div>
			</div>
		 </div> <!-- col -->


		 <div class="col-lg-3 col-md-6 pt-3" hidden>
			<div class="card border border-dark shadow rounded">
			  <h5 class="card-header">Everything</h5>
			  <div class="card-body">



			  </div>
			</div>
		 </div> <!-- col -->

	</div>

</div> <!-- container -->

</div> <!-- content -->
<?php
include('includes/footer.php');
?>
