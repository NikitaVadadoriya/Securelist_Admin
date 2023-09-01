<?php  
$user_type = str_replace(' ', '', $this->utype);
// print_r($this->get_cdata["all_area"]);
// echo $this->get_cdata["report_data"]["total_houses"];
// print_r($this->get_cdata["report_data"]);
?>
<style>
   #wrapper { position: relative; }
   #over_map { position: absolute; top: 30px; right: 100px; z-index: 99; }
   .map_div{
    display: inline-block;
   }
</style>
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                          <h1>Today Status</h1>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
              <div class="card">
                  <!-- <div class="card-header">
                   <?php 
                        if ($user_type != "Manager") {
                          echo "<h5 class=' text-center text-danger'>You Don't Have Permission To View This Page</h5>";
                          die();
                        }
                    ?>
                  </div> -->
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?php 
                        if ($user_type != "Manager") {
                          echo "<h5 class=' text-center text-danger'>You Don't Have Permission To View This Page</h5>";
                          die();
                        }
                    ?>
                    <?php  
                      if (count($this->get_cdata["all_zone"]) > 0 ) {
                    ?> 
                    <form action="<?=URL?><?=$user_type?>/m_current_status/index" method="POST">
                        <div class="row">
                            <div class="col-sm-2">
                              <div class="form-group">
                                <select class="form-control select2" name="user_zone[]" data-placeholder="Select Zone" style="width: 100%" id="user_zone" multiple onchange="get_area(this);">
                                  <option  value="0">All</option>  
                                  <?php  
                                    foreach ($this->get_cdata["all_zone"] as $l_data) {
                                  ?>
                                    <option  value="<?=$l_data["id"]?>" <?= @$_POST["area"] == $l_data["id"] ? 'selected="selected' : '' ?>><?=$l_data["zone"]?></option>  
                                  <?php
                                    }
                                  ?>                                     
                                </select>                          
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group">
                                <select class="form-control select2" name="user_area[]" data-placeholder="Select Zone" style="width: 100%" id="user_area" multiple onchange="get_locality(this);">
                                </select>                          
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select class="form-control select2" name="user_locality[]" data-placeholder="Select Locality" style="width: 100%" id="user_locality" multiple>
                                  <option  value="invalid">All</option>  
                                </select>                          
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select class="form-control select2" name="user_supervisor[]" data-placeholder="Select Supervisor" style="width: 100%" id="user_supervisor" multiple>
                                  <option  value="invalid">All</option>  
                                </select>                          
                              </div>
                            </div>
                                                 
                          <div class="col-sm-2">
                            <div class="form-group">
                              <input type="hidden" name="user_area_all[]" id="user_area_all">
                              <input type="hidden" name="user_locality_all[]" id="user_locality_all">
                              <input type="hidden" name="user_tl_all[]" id="user_tl_all">
                              <button type="submit" class="btn btn-primary">
                                  Search
                              </button>
                              <button type="submit" class="btn btn-primary" formaction="<?=URL?><?=$user_type?>/m_current_status/mapview">
                                  Search
                              </button>
                            </div>
                          </div>
                        </div>
                    </form>                      
                    
                    <?php                                
                      }else{
                    ?>
                      <div class="col-sm-12">
                        <h1>You Are Not Assinged To Any Area</h1>
                      </div>
                    <?php
                      }
                    ?>
                  </div>

                  <!-- /.card-body -->
              </div>
              <div class="card">
                 <!-- <div class="card-header">
                 <?php 
                      if ($user_type != "Manager") {
                        echo "<h5 class=' text-center text-danger'>You Don't Have Permission To View This Page</h5>";
                        die();
                      }
                  ?>
                </div> -->
                <div class="card-body">
                  <?php 
                      if ($user_type != "Manager") {
                        echo "<h5 class=' text-center text-danger'>You Don't Have Permission To View This Page</h5>";
                        die();
                      }
                  ?>
                  <div>
                    <div id="googleMap" style="height:500px;z-index: 0; outline: none;"></div>
                  </div>
                  <div id="over_map">
                    <div class="map_back bg-white p-2">
                      <h6 class="map_div">H: 2233 | S: 2424</h6>&nbsp;&nbsp;
                      <div class="map_div bg-danger p-1">1234</div>
                      <div class="map_div bg-success p-1">1234</div>
                      <div class="map_div bg-warning p-1">1234</div>
                    </div>
                  </div>
                </div>
              </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
<!-- /.content-wrapper -->