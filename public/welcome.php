<?php
session_start();
$_SESSION['title'] = 'Welcome!'; //Add whatever title you wish here. This will be displayed in the tab of your browser
include('includes/header.php'); //required to include basic bootstrap and javascript files
//Add extra scripts/css below this. This could be tablesorter javascript files or custom css files
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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

?>


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

<div class="container-fluid col-4 pt-2">
	<div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
		Hello <?php echo $_SESSION['username'] ?>,<br>Welcome to the members page.<br>
    </div>
</div>

<div class="container-fluid mt-3">

	<div class="row pb-3">

		 <div class="col-lg-9 col-md-6 pt-3">
			<div class="card border border-dark shadow rounded">
			  <h5 class="card-header">Networth: $</h5>
			  <div class="card-body">

			   <div id="chart_div"></div>

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
