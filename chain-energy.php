<?php
include('header.php');
include('navbar.php');
?>

<div class="content">

  <div class="container-fluid mt-3">




    	<div class="row pb-3">

    		 <div class="col-lg-4 col-md-6 pt-3">
    			<div class="card border border-dark shadow rounded">
    			  <h5 class="card-header">Energy Contributions</h5>
    			  <div class="card-body">

    			   <h5 class="title">Energy Reports: Start of Chain</h5>
        <form action="" method="post" enctype="multipart/form-data">

             <div class="pb-2">
             <div class="custom-file pb-2">
                <input type="file" class="custom-file-input" name="strengthSVG_start">
                <label class="custom-file-label" for="strengthSVG_start">Strength SVG</label>
             </div>
             </div>

             <div class="pb-2">
             <div class="custom-file pb-2">
                <input type="file" class="custom-file-input" name="speedSVG_start">
                <label class="custom-file-label" for="speedSVG_start">Speed SVG</label>
             </div>
             </div>

             <div class="pb-2">
             <div class="custom-file">
                <input type="file" class="custom-file-input" name="defenseSVG_start">
                <label class="custom-file-label" for="defenseSVG_start">Defense SVG</label>
             </div>
             </div>

             <div class="pb-2">
             <div class="custom-file pb-2">
                <input type="file" class="custom-file-input" name="dexteritySVG_start">
                <label class="custom-file-label" for="dexteritySVG_start">Dexterity SVG</label>
             </div>
             </div>

         </form>
             <br/><hr/><br/>
             <h5 class="title">Energy Reports: End of Chain</h5>
         <form action="" method="post" enctype="multipart/form-data">

             <div class="pb-2">
             <div class="custom-file pb-2">
                <input type="file" class="custom-file-input" name="strengthSVG_end">
                <label class="custom-file-label" for="strengthSVG_end">Strength SVG</label>
             </div>
             </div>

             <div class="pb-2">
             <div class="custom-file pb-2">
                <input type="file" class="custom-file-input" name="speedSVG_end">
                <label class="custom-file-label" for="speedSVG_end">Speed SVG</label>
             </div>
             </div>

             <div class="pb-2">
             <div class="custom-file pb-2">
                <input type="file" class="custom-file-input" name="defenseSVG_end">
                <label class="custom-file-label" for="defenseSVG_end">Defense SVG</label>
             </div>
             </div>

             <div class="pb-2">
             <div class="custom-file pb-2">
                <input type="file" class="custom-file-input" name="dexteritySVG_end">
                <label class="custom-file-label" for="dexteritySVG_end">Dexterity SVG</label>
             </div>
             </div>


         </form>
             <button type="submit" class="btn btn-primary pt-3" name="importSubmit" value="IMPORT">Submit</button>
    			  </div>
    			</div>
    		 </div> <!-- col -->
      </div> <!-- row -->

      <div class="row">
        <div class="col-lg-6 col-md-6 pt-3">
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
