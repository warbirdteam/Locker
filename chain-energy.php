<?php
include('header.php');
include('navbar.php');
?>

<div class="content">

  <div class="container-fluid mt-3">




    	<div class="row pb-3">

    		 <div class="col-lg-8 col-md-6 pt-3">
    			<div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Energy Contributions</h5>
    			  <div class="card-body">

    			   <p class="card-text"> Add Energy reports for each category.</p>

             <div class="custom-file">
                <input type="file" class="custom-file-input" id="strengthSVG_first">
                <label class="custom-file-label" for="strengthSVG_first">Choose file</label>

                <input type="file" class="custom-file-input" id="speedSVG_first">
                <label class="custom-file-label" for="speedSVG_first">Choose file</label>

                <input type="file" class="custom-file-input" id="defenseSVG_first">
                <label class="custom-file-label" for="defenseSVG_first">Choose file</label>

                <input type="file" class="custom-file-input" id="dexteritySVG_first">
                <label class="custom-file-label" for="dexteritySVG_first">Choose file</label>
             </div>

             <div class="custom-file">
                <input type="file" class="custom-file-input" id="strengthSVG_last">
                <label class="custom-file-label" for="strengthSVG_last">Choose file</label>

                <input type="file" class="custom-file-input" id="speedSVG_last">
                <label class="custom-file-label" for="speedSVG_last">Choose file</label>

                <input type="file" class="custom-file-input" id="defenseSVG_last">
                <label class="custom-file-label" for="defenseSVG_last">Choose file</label>

                <input type="file" class="custom-file-input" id="dexteritySVG_last">
                <label class="custom-file-label" for="dexteritySVG_last">Choose file</label>
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
