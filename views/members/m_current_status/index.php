<?php  
$user_type = str_replace(' ', '', $this->utype);
// print_r($this->get_cdata["all_area"]);
// echo $this->get_cdata["report_data"]["total_houses"];
// print_r($this->get_cdata["report_data"]);
//echo "<pre>";
//print_r($this->get_cdata["report_data"]);
//die();
?>
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                          

                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
              <div class="card">
                  <div class="card-header">
                   <?php 
                        if ($user_type != "Manager") {
                          echo "<h5 class=' text-center text-danger'>You Don't Have Permission To View This Page</h5>";
                          die();
                        }
                    ?>
                    <h3>Today Status</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?php  
                      if (count($this->get_cdata["all_zone"]) > 0 ) {
                    ?> 
                    <form action="<?=URL?><?=$user_type?>/m_current_status/index" method="POST">
                        <div class="row">
                            <div class="col-sm-3">
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
                            <div class="col-sm-3">
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
                                                 
                          <div class="col-sm-3">
                            <div class="form-group">
                              <input type="hidden" name="user_area_all[]" id="user_area_all">
                              <input type="hidden" name="user_locality_all[]" id="user_locality_all">
                              <input type="hidden" name="user_tl_all[]" id="user_tl_all">
                              <button type="submit" class="btn btn-primary">
                                  Search
                              </button>
                              <button type="submit" class="btn btn-primary" formaction="<?=URL?><?=$user_type?>/m_current_status/mapview">
                                  Map
                              </button>
                            </div>
                          </div>
                        </div>
                    </form>
                    <hr>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Locality</th>
                          <th>Total Houses</th>
                          <th>Collected</th>
                          <th>Not Avilable</th>
                          <th>Pending</th>
                          <th>Other</th>
                          <th>Status</th>
                          <th>Attendance</th>
                          <th>Management Attention</th>
                        </tr>
                      </thead>
                      <?php  
                        foreach ($this->get_cdata["report_data"]  as $tbl_data) {
                          foreach ($tbl_data as $zone_data) {
                            foreach ($zone_data as $area_data) {
                              foreach ($area_data as $local_data) {
                      ?>
                        <tr>
                          <td><?=$local_data["locality"]?></td>
                          <td><?=$local_data["total_houses"]?></td>
                          <td><?=$local_data["total_collected"]?></td>
                          <td><?=$local_data["total_na"]?></td>
                          <td><?=(($local_data["total_houses"])-($local_data["total_collected"]-$local_data["total_na"]-$local_data["total_others"]))?></td>
                          <td><?=$local_data["total_others"]?></td>
                          <td>Status</td>
                          <td><?=$local_data["today_active"]?> <span class="text-primary">(<?=intval(($local_data["today_active"]*100)/$local_data["total_se"])?> %)</span></td>
                          <td>For Productivity</td>

                        </tr>
                      <?php
                              }
                            }
                          }
                        }
                      ?>
                      <tbody>
                      </tbody>                      
                    </table>
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
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
<!-- /.content-wrapper -->