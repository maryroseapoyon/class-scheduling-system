<header>
<link rel="stylesheet" href="<?php echo base_url('assets/css/circle.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/circle-style.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/range-slider-style.css'); ?>">


</header>


<div class="animated fadeIn">
  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
            <h1>Generate Schedule</h1>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="page-header float-right">
          <div class="page-title">
              <ol class="breadcrumb text-right">
                  <li><a href="<?php echo site_url('welcome_admin');?>">Home</a></li>
                  <li><a href="#">Data</a></li>
                  <li class="active">Generate</li>
              </ol>
          </div>
      </div>
    </div>
  </div>

<div class="content mt-3">
    <div class="col-sm-12 col-lg-12">

      <div class="col-md-12" id="hidme" style="">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Setup Scheduling Session</strong>
                </div>
                <div class="card-body">
                     <div class="row">
                        <div class="col-lg-12">
                          <div class="card-body">
                            <div class="default-tab">
                              <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="nav-profile" aria-selected="false">Algorithm Settings</a>
                                </div>
                              </nav>

                              <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="nav-home-tab">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="card">
                                        <div class="card-body">
                                          <div class="row">
                                            <div class="col-md-4">
                                              <h6> Mutation Probability </h6>
                                              <br>
                                              <p> The probability of a bad schedule to correctly move it's classes randomly each generation </p>
                                              <div class="range-slider" id="mutation-prob-slider">
                                                  <input class="range-slider__range" type="range" value="100" min="0" max="100" step="10" id="mutation-prob-range">
                                                  <span class="range-slider__value" id="mutation-prob-val">0</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                              <h6> Mutation Size </h6>
                                                <br>
                                                <p> The portion of mutating schedule's bad classes randomly each generation. </p>
                                                <div class="range-slider" id="mutation-size-slider">
                                                  <input class="range-slider__range" type="range" value="10" min="0" max="100" step="10" id="mutation-size-range">
                                                  <span class="range-slider__value" id="mutation-size-val">0</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6> Cross Over Probability </h6>
                                                <br>
                                                <p> The probability of two best schedules to clone/ mix the positions of its classes. </p>
                                                <div class="range-slider" id="crossover-prob-slider">
                                                  <input class="range-slider__range" type="range" value="100" min="0" max="100" step="10" id="crossover-prob-range">
                                                  <span class="range-slider__value" id="crossover-prob-val">0</span>
                                                </div>
                                            </div>
                                          </div>
                                          <hr>
                                          <div class="row">
                                            <div class="col-md-4">
                                              <h6> Cross Over Points</h6>
                                              <br>
                                              <p> The number of part to combine alternately from the best schedules. </p>
                                              <div class="range-slider" id="crossover-points-slider">
                                                  <input class="range-slider__range" type="range" value="4" min="0" max="20" step="2" id="crossover-points-range">
                                                  <span class="range-slider__value" id="crossover-points-val">0</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                              <h6> Sample Size </h6>
                                                <br>
                                                <p> The number of schedule instances to test. </p>
                                               <div class="range-slider" id="sample-size-slider">
                                                  <input class="range-slider__range" type="range" value="10" min="0" max="100" step="10" id="sample-size-range">
                                                  <span class="range-slider__value" id="sample-size-val">0</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6> Generation Interval</h6>
                                                <br>
                                                <p> The limit of continuously having no best results has been reached, the user will be interrupted for an exit confirmation. </p>
                                                <div class="range-slider" id="gen-interval-slider">
                                                  <input class="range-slider__range" type="range" value="1000" min="0" max="10000" step="100" id="gen-interval-range">
                                                  <span class="range-slider__value" id="gen-interval-val">0</span>
                                                </div>
                                            </div>
                                          </div>
                                       </div>
                                       <div class="card-footer" style="border-color:transparent; background-color: transparent;">
                                          <button type="button" class="btn btn-info" id="submit-data">Submit</button> 
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                       </div>
                </div>
            </div>
        </div>
  </div>

      <div class="col-md-12" id="hidthis" style="display:none;">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Stimulate Scheduling</strong>
                </div>
                <div class="card-body">
                     <div class="row">
                     	<div class="col-md-4">
                     		 <div id="idd" class="c100 big">
			                    <span id="perc">0%</span>
			                    <div class="slice">
			                        <div class="bar"></div>
			                        <div class="fill"></div>
			                    </div>
			                </div>
                        <h4 id="gencount" class="col-md-6">Generation:</h4>
                     	</div>

                     	<div class="col-lg-6">
                            <div class="card-body">
                            	<h4><center>Alert</center></h4>
                            	<hr>
                              <div id="alertt"><center>Please Wait...</center></div>
                              <hr>
                               	<div class="card-body">
                                  <center>
                                    <button style="display:none;"id="schedbtn" type="button" class="btn btn-success">View Result</button>
                                    <button id="fstop" type="button" class="btn btn-danger">Force Stop</button>
                                  </center>
                        </div>
                       </div>
                     </div>
                </div>
            </div>
        </div>
	</div>
</div>


