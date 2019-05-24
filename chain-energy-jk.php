<?php
include('navbar.php');

include_once("../../../db_connect_stats.php");

if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Members data has been imported successfully.';
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
        <form action="importdata.php" method="post" enctype="multipart/form-data">

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="strengthCSV_start" name="file1">
                <label class="custom-file-label" for="strengthCSV_start">Strength CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="speedCSV_start" name="file2">
                <label class="custom-file-label" for="speedCSV_start">Speed CSV</label>
             </div>

             <div class="custom-file  mb-2">
                <input type="file" class="custom-file-input" id="defenseCSV_start" name="file3">
                <label class="custom-file-label" for="defenseCSV_start">Defense CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="dexterityCSV_start" name="file4">
                <label class="custom-file-label" for="dexterityCSV_start">Dexterity CSV</label>
             </div>

         

             <br/><hr/><br/>


             <h5 class="title">Energy Reports: End of Chain</h5>
         

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="strengthCSV_end" name="file5">
                <label class="custom-file-label" for="strengthCSV_end">Strength CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="speedCSV_end" name="file6">
                <label class="custom-file-label" for="speedCSV_end">Speed CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="defenseCSV_end" name="file7">
                <label class="custom-file-label" for="defenseCSV_end">Defense CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="dexterityCSV_end" name="file8">
                <label class="custom-file-label" for="dexterityCSV_end">Dexterity CSV</label>
             </div>
			
			<button type="submit" class="btn btn-primary mt-3" id="importSubmit" name="importSubmit" value="IMPORT">Submit</button>
         </form>
             
    			  </div>
    			</div>
    		 </div> <!-- col -->
      </div> <!-- row -->

      <div class="row">
        <div class="col-lg-6 col-md-6 pt-3 mx-auto">
          <div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Results</h5>
    			  <div class="card-body">
					<p class="card-text font-weight-bold text-info">Currently this is only 'strb4' table, but we can change it to the post calculation tables later.</p>
                  <table class="table table-striped table-bordered">
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
         </div>
        </div> <!-- col -->
      </div> <!-- row -->


  </div> <!--container fluid -->


</div> <!--content -->





<?php
include('footer.php');
?>
