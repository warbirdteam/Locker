<?php
session_start();
if ($_SESSION['role'] == 'admin') {include('navbar-admin.php');} else {header("Location: welcome.php");}

include_once("../../../../db_connect_stats.php");

if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Data has been imported successfully.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}
?>
<link rel="stylesheet" href="css/chain-energy.css">
<script type="text/javascript">
$(document).ready(function(){
	$('.custom-file-input').on('change',function(){
	  var fileName = $(this).val().replace('C:\\fakepath\\', "");
	  $(this).next('.custom-file-label').html(fileName);
	});

	//$( "#importForm" ).submit(function( event ) {
		//alert( "Handler for .submit() called." );


		//for (var i = 0; i <=7; i++) {
		//if ($('.custom-file-input').get(i).files.length === 0) {
		//alert( "No files selected for input #" + i + '.' );

		//}
		//}
		//event.preventDefault();
		//event.stopPropagation();
		//$(this).classList.add('was-validated');
	//});


});
</script>

<div class="content">

<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
    <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>

  <div class="container-fluid mt-3">




    	<div class="row pb-3">

    		 <div class="col-xl-4 col-lg-5 col-md-6 pt-3 mx-auto">
    			<div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Energy Contributions</h5>
    			  <div class="card-body">

    			   <h5 class="title">Energy Reports: Start of Chain</h5>
        <form class="needs-validation" action="importdata.php" method="post" enctype="multipart/form-data" id="importForm">

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="strengthCSV_start" name="file1" required>
                <label class="custom-file-label" for="strengthCSV_start">Strength CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="speedCSV_start" name="file2" required>
                <label class="custom-file-label" for="speedCSV_start">Speed CSV</label>
             </div>

             <div class="custom-file  mb-2">
                <input type="file" class="custom-file-input" id="defenseCSV_start" name="file3" required>
                <label class="custom-file-label" for="defenseCSV_start">Defense CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="dexterityCSV_start" name="file4" required>
                <label class="custom-file-label" for="dexterityCSV_start">Dexterity CSV</label>
             </div>



             <br/><hr/><br/>


             <h5 class="title">Energy Reports: End of Chain</h5>


             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="strengthCSV_end" name="file5" required>
                <label class="custom-file-label" for="strengthCSV_end">Strength CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="speedCSV_end" name="file6" required>
                <label class="custom-file-label" for="speedCSV_end">Speed CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="defenseCSV_end" name="file7" required>
                <label class="custom-file-label" for="defenseCSV_end">Defense CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="dexterityCSV_end" name="file8" required>
                <label class="custom-file-label" for="dexterityCSV_end">Dexterity CSV</label>
             </div>

			<button type="submit" class="btn btn-primary mt-3" id="importSubmit" name="importSubmit">Submit</button>
         </form>

    			  </div>
    			</div>
    		 </div> <!-- col -->
      </div> <!-- row -->

      <div class="row">
        <div class="col-xl-8 col-lg-10 col-md-12 pt-3 mx-auto">
          <div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Results</h5>
    			  <div class="card-body">

					<ul class="nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item">
						<a class="nav-link" id="strength-result-tab" data-toggle="tab" href="#strength-result" role="tab">Strength results</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="speed-result-tab" data-toggle="tab" href="#speed-result" role="tab">Speed results</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="defense-result-tab" data-toggle="tab" href="#defense-result" role="tab">Defense results</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="dexterity-result-tab" data-toggle="tab" href="#dexterity-result" role="tab">Dexterity results</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link active" id="total-result-tab" data-toggle="tab" href="#total-result" role="tab">Total</a>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">
					  <div class="tab-pane fade" id="strength-result" role="tabpanel">

							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Energy used</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("select strb4.Player,strb4.URL, strpost.Contribution-strb4.Contribution AS Difference from strb4, strpost where strb4.Player=strpost.Player HAVING Difference > 0 ORDER BY Difference DESC");

								if($result === false)
								{
								   user_error("Query failed: ".$statconn->error."\n$query");
								   return false;
								} else {

								if($result->num_rows > 0){
									while($row = $result->fetch_assoc()){
								?>
									<tr>
										<td><?php echo $row['Player']; ?></td>
										<td class="break"><a href="<?php echo $row['URL']; ?>" target="_blank"><?php echo $row['URL']; ?></a></td>
										<td><?php echo $row['Difference']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>

					  </div>
					  <div class="tab-pane fade" id="speed-result" role="tabpanel">

							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Energy used</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("select spdb4.Player,spdb4.URL, spdpost.Contribution-spdb4.Contribution AS Difference from spdb4, spdpost where spdb4.Player=spdpost.Player HAVING Difference > 0 ORDER BY Difference DESC");

								if($result === false)
								{
								   user_error("Query failed: ".$statconn->error."\n$query");
								   return false;
								} else {

								if($result->num_rows > 0){
									while($row = $result->fetch_assoc()){
								?>
									<tr>
										<td><?php echo $row['Player']; ?></td>
										<td class="break"><a href="<?php echo $row['URL']; ?>" target="_blank"><?php echo $row['URL']; ?></a></td>
										<td><?php echo $row['Difference']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>

					  </div>
					  <div class="tab-pane fade" id="defense-result" role="tabpanel">

							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Energy used</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("select defb4.Player,defb4.URL, defpost.Contribution-defb4.Contribution AS Difference from defb4, defpost where defb4.Player=defpost.Player HAVING Difference > 0 ORDER BY Difference DESC");

								if($result === false)
								{
								   user_error("Query failed: ".$statconn->error."\n$query");
								   return false;
								} else {

								if($result->num_rows > 0){
									while($row = $result->fetch_assoc()){
								?>
									<tr>
										<td><?php echo $row['Player']; ?></td>
										<td class="break"><a href="<?php echo $row['URL']; ?>" target="_blank"><?php echo $row['URL']; ?></a></td>
										<td><?php echo $row['Difference']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>

					  </div>
					  <div class="tab-pane fade" id="dexterity-result" role="tabpanel">

							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Energy used</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("select dexb4.Player,dexb4.URL, dexpost.Contribution-dexb4.Contribution AS Difference from dexb4, dexpost where dexb4.Player=dexpost.Player HAVING Difference > 0 ORDER BY Difference DESC");

								if($result === false)
								{
								   user_error("Query failed: ".$statconn->error."\n$query");
								   return false;
								} else {

								if($result->num_rows > 0){
									while($row = $result->fetch_assoc()){
								?>
									<tr>
										<td><?php echo $row['Player']; ?></td>
										<td class="break"><a href="<?php echo $row['URL']; ?>" target="_blank"><?php echo $row['URL']; ?></a></td>
										<td><?php echo $row['Difference']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>

					  </div>
					  <div class="tab-pane fade show active" id="total-result" role="tabpanel">

							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Energy used</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT Player, URL, sum(Difference) FROM ( SELECT strb4.Player,strb4.URL, strpost.Contribution-strb4.Contribution AS Difference FROM strb4, strpost WHERE strb4.Player=strpost.Player HAVING Difference > 0 UNION ALL SELECT spdb4.Player,spdb4.URL, spdpost.Contribution-spdb4.Contribution AS Difference FROM spdb4, spdpost WHERE spdb4.Player=spdpost.Player HAVING Difference > 0 UNION ALL SELECT defb4.Player,defb4.URL, defpost.Contribution-defb4.Contribution AS Difference FROM defb4, defpost WHERE defb4.Player=defpost.Player HAVING Difference > 0 UNION ALL SELECT dexb4.Player,dexb4.URL, dexpost.Contribution-dexb4.Contribution AS Difference FROM dexb4, dexpost WHERE dexb4.Player=dexpost.Player HAVING Difference > 0 ) x GROUP BY Player ORDER BY sum(Difference) DESC");

								if($result === false)
								{
								   user_error("Query failed: ".$statconn->error."\n$query");
								   return false;
								} else {

								if($result->num_rows > 0){
									while($row = $result->fetch_assoc()){
								?>
									<tr>
										<td><?php echo $row['Player']; ?></td>
										<td class="break"><a href="<?php echo $row['URL']; ?>" target="_blank"><?php echo $row['URL']; ?></a></td>
										<td><?php echo $row['sum(Difference)']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>

					  </div>



					  </div>
					</div>



            </div>
         </div>
        </div> <!-- col -->
      </div> <!-- row -->


  </div> <!--container fluid -->


</div> <!--content -->





<?php
include('footer.php');
?>
