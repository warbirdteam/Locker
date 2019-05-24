<?php
include('header.php');
include('navbar.php');
?>

<div class="content">

  <div class="container-fluid mt-3">




    	<div class="row pb-3">

    		 <div class="col-lg-6 col-md-6 pt-3">
    			<div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Energy Contributions</h5>
    			  <div class="card-body">

    			   <h5 class="title">Energy Reports: Start of Chain</h5>

             <div class="custom-file">
                <input type="file" class="custom-file-input" id="strengthSVG_start">
                <label class="custom-file-label" for="strengthSVG_start">Choose file</label>
             </div>
             <div class="custom-file">
                <input type="file" class="custom-file-input" id="speedSVG_start">
                <label class="custom-file-label" for="speedSVG_start">Choose file</label>
             </div>
             <div class="custom-file">
                <input type="file" class="custom-file-input" id="defenseSVG_start">
                <label class="custom-file-label" for="defenseSVG_start">Choose file</label>
             </div>
             <div class="custom-file">
                <input type="file" class="custom-file-input" id="dexteritySVG_start">
                <label class="custom-file-label" for="dexteritySVG_start">Choose file</label>
             </div>
             <hr/>
             <h5 class="title">Energy Reports: End of Chain</h5>

             <div class="custom-file">
                <input type="file" class="custom-file-input" id="strengthSVG_end">
                <label class="custom-file-label" for="strengthSVG_end">Choose file</label>
             </div>
             <div class="custom-file">
                <input type="file" class="custom-file-input" id="speedSVG_end">
                <label class="custom-file-label" for="speedSVG_end">Choose file</label>
             </div>
             <div class="custom-file">
                <input type="file" class="custom-file-input" id="defenseSVG_end">
                <label class="custom-file-label" for="defenseSVG_end">Choose file</label>
             </div>
             <div class="custom-file">
                <input type="file" class="custom-file-input" id="dexteritySVG_end">
                <label class="custom-file-label" for="dexteritySVG_end">Choose file</label>
             </div>

    			  </div>
    			</div>
    		 </div> <!-- col -->
      </div> <!-- row -->

      <div class="row">
        <div class="col-lg-8 col-md-6 pt-3">
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
