<?php
include('navbar.php');
?>

<script> 
$('.custom-file-input').on('change',function(){
  var fileName = $(this).val();
  console.log(fileName);
  $(this).next('.custom-file-label').html(fileName);
  console.log($(this).next('.custom-file-label').html());
});
</script>

<div class="content">

  <div class="container-fluid mt-3">




    	<div class="row pb-3">

    		 <div class="col-lg-4 col-md-6 pt-3 mx-auto">
    			<div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Energy Contributions</h5>
    			  <div class="card-body">

    			   <h5 class="title">Energy Reports: Start of Chain</h5>
        <form action="" method="post" enctype="multipart/form-data">

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="strengthCSV_start" name="strengthCSV_start">
                <label class="custom-file-label" for="strengthCSV_start">Strength CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="speedCSV_start" name="speedCSV_start">
                <label class="custom-file-label" for="speedCSV_start">Speed CSV</label>
             </div>

             <div class="custom-file  mb-2">
                <input type="file" class="custom-file-input" id="defenseCSV_start" name="defenseCSV_start">
                <label class="custom-file-label" for="defenseCSV_start">Defense CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="dexterityCSV_start" name="dexterityCSV_start">
                <label class="custom-file-label" for="dexterityCSV_start">Dexterity CSV</label>
             </div>

         </form>

             <br/><hr/><br/>


             <h5 class="title">Energy Reports: End of Chain</h5>
         <form action="" method="post" enctype="multipart/form-data">

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="strengthCSV_end" name="strengthCSV_end">
                <label class="custom-file-label" for="strengthCSV_end">Strength CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="speedCSV_end" name="speedCSV_end">
                <label class="custom-file-label" for="speedCSV_end">Speed CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="defenseCSV_end" name="defenseCSV_end">
                <label class="custom-file-label" for="defenseCSV_end">Defense CSV</label>
             </div>

             <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="dexterityCSV_end" name="dexterityCSV_end">
                <label class="custom-file-label" for="dexterityCSV_end">Dexterity CSV</label>
             </div>

         </form>
             <button type="submit" class="btn btn-primary mt-3" id="importSubmit" name="importSubmit" value="IMPORT">Submit</button>
    			  </div>
    			</div>
    		 </div> <!-- col -->
      </div> <!-- row -->

      <div class="row">
        <div class="col-lg-6 col-md-6 pt-3 mx-auto">
          <div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Results</h5>
    			  <div class="card-body">

              <p class="card-text" id="results"></p>

            </div>
         </div>
        </div> <!-- col -->
      </div> <!-- row -->


  </div> <!--container fluid -->


</div> <!--content -->





<?php
include('footer.php');
?>
