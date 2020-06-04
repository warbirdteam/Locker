<?php
//##### GUEST & MEMBER & LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Welcome'; //Add whatever title you wish here. This will be displayed in the tab of your browser
include('includes/header.php'); //required to include basic bootstrap and javascript files
?>

<script src="js/highcharts.js"></script>

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

    <div class="row">
      <!-- Battle Stats Card -->
      <div class="pt-3 col-sm-12 col-md-6 col-xl-4">
        <div class="card border border-dark shadow rounded h-100">
          <h5 class="card-header">Battle Stats</h5>
          <div class="card-body">
            <div class="row no-gutters">
              <div class="col">
                <ul class="list-group list-group-flush border-bottom">
                  <li class="list-group-item list-group-item-dark border border-dark"><b>Stats</b>:</li>
                  <li class="list-group-item border-right"><b>Strength</b>: <?php echo number_format($json['strength']); ?></li>
                  <li class="list-group-item border-right"><b>Defense</b>: <?php echo number_format($json['defense']); ?></li>
                  <li class="list-group-item border-right"><b>Speed</b>: <?php echo number_format($json['speed']); ?></li>
                  <li class="list-group-item border-right"><b>Dexterity</b>: <?php echo number_format($json['dexterity']); ?></li>
                  <li class="list-group-item border-right"><b>Total</b>: <?php echo number_format($json['total']); ?></li>
                </ul>
              </div>
              <div class="col">
                <ul class="list-group list-group-flush border-bottom">
                  <li class="list-group-item list-group-item-dark border border-dark border-left-0"><b>Effective</b>:</li>
                  <li class="list-group-item"><b>Strength</b>: <?php echo number_format( ($json['strength'] * (1 + ($json['strength_modifier'] / 100))) ); ?></li>
                  <li class="list-group-item"><b>Defense</b>: <?php echo number_format( ($json['defense'] * (1 + ($json['defense_modifier'] / 100))) ); ?></li>
                  <li class="list-group-item"><b>Speed</b>: <?php echo number_format( ($json['speed'] * (1 + ($json['speed_modifier'] / 100))) ); ?></li>
                  <li class="list-group-item"><b>Dexterity</b>: <?php echo number_format( ($json['dexterity'] * (1 + ($json['dexterity_modifier'] / 100))) ); ?></li>
                  <li class="list-group-item"><b>Total</b>: <?php echo number_format( (($json['strength'] * (1 + ($json['strength_modifier'] / 100))) + ($json['defense'] * (1 + ($json['defense_modifier'] / 100))) + ($json['speed'] * (1 + ($json['speed_modifier'] / 100))) + ($json['dexterity'] * (1 + ($json['dexterity_modifier'] / 100)))) ); ?></li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div> <!-- col -->


      <!-- Networth Card -->
      <div class="pt-3 col-sm-12 col-md-6 col-xl-4">
        <div class="card border border-dark shadow rounded h-100">
          <h5 class="card-header">Networth: $<?php echo number_format($json["personalstats"]["networth"]); ?></h5>
          <div class="card-body">

            <div id="networth"></div>

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
<?php
include('includes/footer.php');
?>
