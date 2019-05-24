<?php
include('navbar.php');

include_once("../../../db_connect_stats.php");

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

    		 <div class="col-lg-4 col-md-6 pt-3 mx-auto">
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
        <div class="col-lg-8 col-md-6 pt-3 mx-auto">
          <div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Results</h5>
    			  <div class="card-body">
				  
					<ul class="nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item">
						<a class="nav-link active" id="strength-before-tab" data-toggle="tab" href="#strength-before" role="tab">Strength before</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="speed-before-tab" data-toggle="tab" href="#speed-before" role="tab">Speed before</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="defense-before-tab" data-toggle="tab" href="#defense-before" role="tab">Defense before</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="dexterity-before-tab" data-toggle="tab" href="#dexterity-before" role="tab">Dexterity before</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="strength-after-tab" data-toggle="tab" href="#strength-after" role="tab">Strength after</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="speed-after-tab" data-toggle="tab" href="#speed-after" role="tab">Speed after</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="defense-after-tab" data-toggle="tab" href="#defense-after" role="tab">Defense after</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" id="dexterity-after-tab" data-toggle="tab" href="#dexterity-after" role="tab">Dexterity after</a>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">
					  <div class="tab-pane fade show active" id="strength-before" role="tabpanel">

							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Contribution</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT * FROM strb4 ORDER BY Contribution DESC");
								
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
										<td><?php echo $row['URL']; ?></td>
										<td><?php echo $row['Contribution']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>
					  
					  </div>
					  <div class="tab-pane fade" id="speed-before" role="tabpanel">
					  
							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Contribution</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT * FROM spdb4 ORDER BY Contribution DESC");
								
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
										<td><?php echo $row['URL']; ?></td>
										<td><?php echo $row['Contribution']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>
					  
					  </div>
					  <div class="tab-pane fade" id="defense-before" role="tabpanel">
					  
							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Contribution</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT * FROM defb4 ORDER BY Contribution DESC");
								
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
										<td><?php echo $row['URL']; ?></td>
										<td><?php echo $row['Contribution']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>
					  
					  </div>
					  <div class="tab-pane fade" id="dexterity-before" role="tabpanel">
					  
							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Contribution</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT * FROM dexb4 ORDER BY Contribution DESC");
								
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
										<td><?php echo $row['URL']; ?></td>
										<td><?php echo $row['Contribution']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>
					  
					  </div>
					  <div class="tab-pane fade" id="strength-after" role="tabpanel">

							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Contribution</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT * FROM strpost ORDER BY Contribution DESC");
								
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
										<td><?php echo $row['URL']; ?></td>
										<td><?php echo $row['Contribution']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>
					  
					  </div>
					  <div class="tab-pane fade" id="speed-after" role="tabpanel">
					  
							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Contribution</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT * FROM spdpost ORDER BY Contribution DESC");
								
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
										<td><?php echo $row['URL']; ?></td>
										<td><?php echo $row['Contribution']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>
					  
					  </div>
					  <div class="tab-pane fade" id="defense-after" role="tabpanel">
					  
							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Contribution</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT * FROM defpost ORDER BY Contribution DESC");
								
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
										<td><?php echo $row['URL']; ?></td>
										<td><?php echo $row['Contribution']; ?></td>
									</tr>
								<?php } }else{ ?>
									<tr><td colspan="5">No information found...</td></tr>
								<?php } } ?>
								</tbody>
							</table>
					  
					  </div>
					  <div class="tab-pane fade" id="dexterity-after" role="tabpanel">
					  
							<table class="table table-striped table-bordered mt-3">
								<thead class="thead-dark">
									<tr>
										<th>Player</th>
										<th>URL</th>
										<th>Contribution</th>
									</tr>
								</thead>
								<tbody>
								<?php
								// Get member rows
								$result = $statconn->query("SELECT * FROM dexpost ORDER BY Contribution DESC");
								
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
										<td><?php echo $row['URL']; ?></td>
										<td><?php echo $row['Contribution']; ?></td>
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
        </div> <!-- col -->
      </div> <!-- row -->


  </div> <!--container fluid -->


</div> <!--content -->





<?php
include('footer.php');
?>
