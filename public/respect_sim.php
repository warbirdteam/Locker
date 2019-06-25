<?php
session_start();
if ($_SESSION['role'] == 'admin') {include('navbar-admin.php');} else {include('navbar.php');}

?>
<link rel="stylesheet" href="css/respect_sim.css">


<div class="container border border-light shadow pt-2 my-4 rounded" style="background-color: #d2dae2;">
	<div class="container mb-4" align="center">
<div class="container">

<h5>Click on a tab to edit.</h5>

  <div class="row">
      <div class="col-lg-4 col-md-6">


          <div class="card border border-dark shadow mb-3">
            <div class="card-header p-0"><button class="btn btn-link btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseCri">
            <div class="position-static">Criminality</div>
            </button></div><p class="pt-2">Criminality Respect: <span id="crimTot" class="font-weight-bold">0</span></p>
            <div class="mb-3"><span class="recommended badge shadow" hidden>Recommended Branch: <span id="base3r" class="font-weight-bold">N/A</span></span></div>
             <div id="collapseCri" class="collapse">
      <div class="card-body h-100 pt-0">

      <p class="mb-0">Branch Number:</p>
      <label class="radio-inline px-1"><input type="radio" name="base3" data-num="1" value="1" checked>1</label>
    <label class="radio-inline px-1"><input type="radio" name="base3" data-num="2" value="2">2</label>
    <label class="radio-inline px-1"><input type="radio" name="base3" data-num="3" value="4">3</label>
    <label class="radio-inline px-1"><input type="radio" name="base3" data-num="4" value="8">4</label>
    <label class="radio-inline px-1"><input type="radio" name="base3" data-num="5" value="16">5</label>
    <label class="radio-inline px-1"><input type="radio" name="base3" data-num="6" value="32">6</label>

      <div class="container">
    <div class="row">

       <div class="col-auto order-2">
         <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Nerve: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="13" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="40"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="13R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-1">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Crimes: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="14" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="25"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="14R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-3">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Jail Time: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="15" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="15"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="15R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-5">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Bust Nerve: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="16" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="3"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="16R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-4">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Bust Skill: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="17" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="17R">0</span></label>
       </div>
       </div>

      </div>
      </div>
            </div> <!-- card body -->
          </div>
              </div> <!-- card -->


      <div class="card border border-dark shadow mb-4">
                  <div class="card-header p-0"><button class="btn btn-link btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseFor">
             Fortitude
            </button></div><p class="pt-2">Fortitude Respect: <span id="fortTot" class="font-weight-bold">0</span></p>
            <div class="mb-3"><span class="recommended badge shadow" hidden>Recommended Branch: <span id="base4r" class="font-weight-bold">N/A</span></span></div>
            <div id="collapseFor" class="collapse">
            <div class="card-body h-100 pt-0">

      <p class="mb-0">Branch Number:</p>
      <label class="radio-inline px-1"><input type="radio" name="base4" data-num="1" value="1" checked>1</label>
    <label class="radio-inline px-1"><input type="radio" name="base4" data-num="2" value="2">2</label>
    <label class="radio-inline px-1"><input type="radio" name="base4" data-num="3" value="4">3</label>
    <label class="radio-inline px-1"><input type="radio" name="base4" data-num="4" value="8">4</label>
    <label class="radio-inline px-1"><input type="radio" name="base4" data-num="5" value="16">5</label>
    <label class="radio-inline px-1"><input type="radio" name="base4" data-num="6" value="32">6</label>



    <div class="container">
    <div class="row">

       <div class="col-auto order-2">
         <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Medical Cooldown: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="18" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="12"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="18R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-5">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Reviving: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="19" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="19R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-1">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Hospital Time: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="20" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="25"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="20R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-3">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Life Regeneration: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="21" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="21R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-4">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Medical Effectiveness: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="22" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="22R">0</span></label>
       </div>
       </div>

    </div>
    </div>
            </div> <!-- card body -->
            </div>
</div> <!-- card -->


<div class="card  border border-dark shadow mb-4">
    <div class="card-header p-0"><button class="btn btn-link btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseVor">
           Voracity
          </button></div><p class="pt-2">Voracity Respect: <span id="vorTot" class="font-weight-bold">0</span></p>
          <div class="mb-3"><span class="recommended badge shadow" hidden>Recommended Branch: <span id="base5r" class="font-weight-bold">N/A</span></span></div>
          <div id="collapseVor" class="collapse">
          <div class="card-body h-100 pt-0">

    <p class="mb-0">Branch Number:</p>
      <label class="radio-inline px-1"><input type="radio" name="base5" data-num="1" value="1" checked>1</label>
    <label class="radio-inline px-1"><input type="radio" name="base5" data-num="2" value="2">2</label>
    <label class="radio-inline px-1"><input type="radio" name="base5" data-num="3" value="4">3</label>
    <label class="radio-inline px-1"><input type="radio" name="base5" data-num="4" value="8">4</label>
    <label class="radio-inline px-1"><input type="radio" name="base5" data-num="5" value="16">5</label>
    <label class="radio-inline px-1"><input type="radio" name="base5" data-num="6" value="32">6</label>



    <div class="container">
    <div class="row">

    <div class="col-auto order-2">

      <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Candy Effect: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="23" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="23R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-4">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Energy Drink Effect: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="24" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="24R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-1">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Booster Cooldown: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="25" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="24"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="25R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-3">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Alcohol Effect: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="26" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="26R">0</span></label>
       </div>
       </div>

  </div>
  </div>
          </div> <!-- card body -->
          </div>
         </div> <!-- card -->


   <div class="card border border-dark shadow mb-4">
                <div class="card-header p-0"><button class="btn btn-link btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseTol">
           Toleration
          </button></div><p class="pt-2">Toleration Respect: <span id="tolTot" class="font-weight-bold">0</span></p>
          <div class="mb-3"><span class="recommended badge shadow" hidden>Recommended Branch: <span id="base6r" class="font-weight-bold">N/A</span></span></div>
          <div id="collapseTol" class="collapse">
          <div class="card-body h-100 pt-0">

      <p class="mb-0">Branch Number:</p>
      <label class="radio-inline px-1"><input type="radio" name="base6" data-num="1" value="1" checked>1</label>
    <label class="radio-inline px-1"><input type="radio" name="base6" data-num="2" value="2">2</label>
    <label class="radio-inline px-1"><input type="radio" name="base6" data-num="3" value="4">3</label>
    <label class="radio-inline px-1"><input type="radio" name="base6" data-num="4" value="8">4</label>
    <label class="radio-inline px-1"><input type="radio" name="base6" data-num="5" value="16">5</label>
    <label class="radio-inline px-1"><input type="radio" name="base6" data-num="6" value="32">6</label>



    <div class="container">
    <div class="row">

    <div class="col-auto order-2">
    <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Side Effect: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="27" data-reqid="29" data-reqnum="1" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="27R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-3">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Overdosing: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="28" data-reqid="29" data-reqnum="13" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="28R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-1">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Addiction: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="29" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="25"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="29R">0</span></label>
       </div>
       </div>


    </div> <!-- row -->
    </div>
            </div> <!-- card body -->
            </div>
           </div> <!-- card -->



   </div> <!-- col -->


      <div class="col-lg-4 col-md-6">

      <div class="card border border-dark shadow mb-4">
                <h5 class="card-header text-md-center bg-success text-white">Respect</h5>

          <div class="card-body h-100 px-0">

      <div class="container">

    <label class="radio-inline px-1"><input type="radio" name="fid" value="13784">Warbirds</label>
<label class="radio-inline px-1"><input type="radio" name="fid" value="35507">The Nest</label>
<label class="radio-inline px-1"><input type="radio" name="fid" value="0" checked>None</label>
<p><button id="import" class="btn btn-primary" type="button">Import</button> <button id="reset" class="btn btn-primary" type="button">Reset</button></p>
<hr />

<p id="customRespect" hidden>
Respect: <span id="TotRespect" class="font-weight-bold">0</span><br/>
Core Respect in use: <span id="coreTot" class="font-weight-bold">0</span><br/>
Available Respect: <span id="availTot" class="font-weight-bold">0</span>
</p>

<div class="container">
<div class="row">
<div class="col border border-dark rounded-top shadow pt-1 mb-2 px-0 mr-2 blocks-blue">
<p class="font-weight-light">Criminality:<br/><span id="crimTot" class="font-weight-bold">0</span><br/><span class="badge badge-warning" id="br3" hidden>Branch: </span></p>
</div>
<div class="col border border-dark rounded-top shadow pt-1 mb-2 px-0 ml-2 blocks-blue">
<p class="font-weight-light">Fortitude:<br/><span id="fortTot" class="font-weight-bold">0</span><br/><span class="badge badge-warning" id="br4" hidden>Branch: </span></p>
</div>
</div>
<div class="row">
<div class="col border border-dark rounded-top shadow pt-1 mb-2 px-0 mr-2 blocks-blue">
<p class="font-weight-light">Voracity:<br/><span id="vorTot" class="font-weight-bold">0</span><br/><span class="badge badge-warning" id="br5" hidden>Branch: </span></p>
</div>
<div class="col border border-dark rounded-top shadow pt-1 mb-2 px-0 ml-2 blocks-blue">
<p class="font-weight-light">Toleration:<br/><span id="tolTot" class="font-weight-bold">0</span><br/><span class="badge badge-warning" id="br6" hidden>Branch: </span></p>
</div>
</div>
<div class="row">
<div class="col border border-dark rounded-top shadow pt-1 mb-2 px-0 mr-2 blocks-blue">
<p class="font-weight-light">Excursion:<br/><span id="excurTot" class="font-weight-bold">0</span><br/><span class="badge badge-warning" id="br7" hidden>Branch: </span></p>
</div>
<div class="col border border-dark rounded-top shadow pt-1 mb-2 px-0 ml-2 blocks-blue">
<p class="font-weight-light">Steadfast:<br/><span id="steadTot" class="font-weight-bold">0</span><br/><span class="badge badge-warning" id="br8" hidden>Branch: </span></p>
</div>
</div>
<div class="row">
<div class="col border border-dark rounded-top shadow pt-1 mb-2 px-1 mx-0 mr-2 blocks-blue">
<p class="font-weight-light">Aggression:<br/><span id="aggTot" class="font-weight-bold">0</span><br/><span class="badge badge-warning" id="br9" hidden>Branch: </span></p>
</div>
<div class="col border border-dark rounded-top shadow pt-1 mb-2 px-1 mx-0 ml-2 blocks-blue">
<p class="font-weight-light">Suppression:<br/><span id="supTot" class="font-weight-bold">0</span><br/><span class="badge badge-warning" id="br10" hidden>Branch: </span></p>
</div>
</div>
</div>

<hr />



<p>
Total Simulated: <span id="TotalSim" class="font-weight-bold">0</span><br />
<span id="leftoverR" hidden>Leftover Respect: <span id="leftover" class="font-weight-bold">0</span></span>
</p>

<button id="validate" class="btn btn-primary" type="button" hidden>Validate</button>
</div><!-- container -->

      </div>
      </div>

      </div>



      <div class="col-lg-4 col-md-6">


            <div class="card border border-dark shadow mb-4">
                <div class="card-header p-0"><button class="btn btn-link btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseExc">
           Excursion
          </button></div><p class="pt-2">Excursion Respect: <span id="excurTot" class="font-weight-bold">0</span></p>
          <div class="mb-3"><span class="recommended badge shadow" hidden>Recommended Branch: <span id="base7r" class="font-weight-bold">N/A</span></span></div>
          <div id="collapseExc" class="collapse">
          <div class="card-body h-100 pt-0">

    <p class="mb-0">Branch Number:</p>
      <label class="radio-inline px-1"><input type="radio" name="base7" data-num="1" value="1" checked>1</label>
    <label class="radio-inline px-1"><input type="radio" name="base7" data-num="2" value="2">2</label>
    <label class="radio-inline px-1"><input type="radio" name="base7" data-num="3" value="4">3</label>
    <label class="radio-inline px-1"><input type="radio" name="base7" data-num="4" value="8">4</label>
    <label class="radio-inline px-1"><input type="radio" name="base7" data-num="5" value="16">5</label>
    <label class="radio-inline px-1"><input type="radio" name="base7" data-num="6" value="32">6</label>


  <div class="container">
  <div class="row">
  <div class="col-auto order-3">
  <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Hunting: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="31" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="31R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-5">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Overseas Banking: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="32" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="5"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="32R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-1">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Travel Capacity: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="33" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="33R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-2">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Travel Cost: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="34" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="5"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="34R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-4">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Rehab Cost: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="35" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="35R">0</span></label>
       </div>
       </div>

  </div> <!-- row -->
  </div>
          </div> <!-- card body -->
          </div>
         </div> <!-- card -->

          <div class="card border border-dark shadow mb-4">
                <div class="card-header p-0"><button class="btn btn-link btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseSte">
           Steadfast
          </button></div><p class="pt-2">Steadfast Respect: <span id="steadTot" class="font-weight-bold">0</span></p>
          <div class="mb-3"><span class="recommended badge shadow" hidden>Recommended Branch: <span id="base8r" class="font-weight-bold">N/A</span></span></div>
          <div id="collapseSte" class="collapse">
          <div class="card-body h-100 pt-0">

      <p class="mb-0">Branch Number:</p>
      <label class="radio-inline px-1"><input type="radio" name="base8" data-num="1" value="1" checked>1</label>
    <label class="radio-inline px-1"><input type="radio" name="base8" data-num="2" value="2">2</label>
    <label class="radio-inline px-1"><input type="radio" name="base8" data-num="3" value="4">3</label>
    <label class="radio-inline px-1"><input type="radio" name="base8" data-num="4" value="8">4</label>
    <label class="radio-inline px-1"><input type="radio" name="base8" data-num="5" value="16">5</label>
    <label class="radio-inline px-1"><input type="radio" name="base8" data-num="6" value="32">6</label>



      <div class="container">
    <div class="row">

    <div class="col-auto order-1">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Strength: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="36" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-lowmax="10" data-midmax="15" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="36R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-2">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Speed: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="37" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-lowmax="10" data-midmax="15" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="37R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-3">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Defense: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="38" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-lowmax="10" data-midmax="15" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="38R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-4">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Dexterity: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="39" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-lowmax="10" data-midmax="15" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="39R">0</span></label>
       </div>
       </div>


    </div>
    </div>
            </div> <!-- card body -->
            </div>
           </div> <!-- card -->

           <div class="card border border-dark shadow mb-4">
                <div class="card-header p-0"><button class="btn btn-link btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseAgg">
           Aggression
          </button></div><p class="pt-2">Aggression Respect: <span id="aggTot" class="font-weight-bold">0</span></p>
          <div class="mb-3"><span class="recommended badge shadow" hidden>Recommended Branch: <span id="base9r" class="font-weight-bold">N/A</span></span></div>
          <div id="collapseAgg" class="collapse">
          <div class="card-body h-100 pt-0">

      <p class="mb-0">Branch Number:</p>
      <label class="radio-inline px-1"><input type="radio" name="base9" data-num="1" value="1" checked>1</label>
    <label class="radio-inline px-1"><input type="radio" name="base9" data-num="2" value="2">2</label>
    <label class="radio-inline px-1"><input type="radio" name="base9" data-num="3" value="4">3</label>
    <label class="radio-inline px-1"><input type="radio" name="base9" data-num="4" value="8">4</label>
    <label class="radio-inline px-1"><input type="radio" name="base9" data-num="5" value="16">5</label>
    <label class="radio-inline px-1"><input type="radio" name="base9" data-num="6" value="32">6</label>


    <div class="container">
    <div class="row">

    <div class="col-auto order-3">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Hospitalization: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="40" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="40R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-5">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Damage: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="41" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="41R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-1">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Strength: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="42" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="42R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-2">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Speed: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="43" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="43R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-4">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Accuracy: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="44" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="44R">0</span></label>
       </div>
       </div>

            </div>
            </div>
            </div> <!-- card body -->
            </div>
           </div> <!-- card -->


           <div class="card border border-dark shadow mb-4">
                <div class="card-header p-0"><button class="btn btn-link btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseSup">
           Suppression
          </button></div><p class="pt-2">Suppression Respect: <span id="supTot" class="font-weight-bold">0</span></p>
          <div class="mb-3"><span class="recommended badge shadow" hidden>Recommended Branch: <span id="base10r" class="font-weight-bold">N/A</span></span></div>
          <div id="collapseSup" class="collapse">
          <div class="card-body h-100 pt-0">

      <p class="mb-0">Branch Number:</p>
      <label class="radio-inline px-1"><input type="radio" name="base10" data-num="1" value="1" checked>1</label>
    <label class="radio-inline px-1"><input type="radio" name="base10" data-num="2" value="2">2</label>
    <label class="radio-inline px-1"><input type="radio" name="base10" data-num="3" value="4">3</label>
    <label class="radio-inline px-1"><input type="radio" name="base10" data-num="4" value="8">4</label>
    <label class="radio-inline px-1"><input type="radio" name="base10" data-num="5" value="16">5</label>
    <label class="radio-inline px-1"><input type="radio" name="base10" data-num="6" value="32">6</label>


    <div class="container">
    <div class="row">

    <div class="col-auto order-4">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Max Life: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="45" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="45R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-1">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Defense: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="46" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="46R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-2">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Dexterity: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="47" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="20"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="47R">0</span></label>
       </div>
       </div>

       <div class="col-auto order-3">
       <div class="form-group border border-dark shadow pt-1 px-3 mb-3 blocks">
          <label>Escape: <span>0</span></label>
          <div class="input-group">
              <div class="input-group-btn">
                  <button id="down" class="btn btn-danger" data-min="0" disabled><span class="fas fa-minus"></span></button>
              </div>
              <input type="text" class="upgval form-control input-number" data-num="48" value="0" />
              <div class="input-group-btn">
                  <button id="up" class="btn btn-success" data-max="10"><span class="fas fa-plus"></span></button>
              </div>
          </div>
          <label>Total: <span id="48R">0</span></label>
       </div>
       </div>

            </div>
            </div>
            </div> <!-- card body -->
            </div>
           </div> <!-- card -->

      </div> <!-- col -->


  </div> <!-- row -->

</div> <!-- container -->

</div>
</div>


<script src="js/respect_sim.js"></script>




<?php
include('footer.php');
?>
