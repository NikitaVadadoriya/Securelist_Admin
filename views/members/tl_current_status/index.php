<?php  
$user_type = str_replace(' ', '', $this->utype);
// echo $this->get_cdata["report_data"]["total_houses"];
// print_r($this->get_cdata["report_data"]);
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
                        if ($user_type != "TeamLeader") {
                          echo "<h5 class=' text-center text-danger'>You Don't Have Permission To View This Page</h5>";
                          die();
                        }
                    ?>
                    <h3>Today Status</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?php  
                      if (count($this->get_cdata["all_locality"]) > 0 ) {
                    ?> 
                    <form action="<?=URL?><?=$user_type?>/tl_current_status/index" method="POST">
                        <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select class="form-control select2" name="user_locality[]" data-placeholder="Select Locality" style="width: 100%" id="user_locality" multiple>
                                  <option  value="0">All</option>  
                                  <?php  
                                    foreach ($this->get_cdata["all_locality"] as $l_data) {
                                  ?>
                                    <option  value="<?=$l_data["id"]?>" <?= @$_POST["user_locality"] == $l_data["id"] ? 'selected="selected' : '' ?>><?=$l_data["locality"]?></option>  
                                  <?php
                                    }
                                  ?>                         
                                </select>                          
                              </div>
                            </div>                          
                          <div class="col-sm-3">
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary">
                                  Search
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
                      ?>
                        <tr>
                          <td><?=$tbl_data["locality"]?></td>
                          <td><?=$tbl_data["total_houses"]?></td>
                          <td><?=$tbl_data["total_collected"]?></td>
                          <td><?=$tbl_data["total_na"]?></td>
                          <td><?=(($tbl_data["total_houses"])-($tbl_data["total_collected"]-$tbl_data["total_na"]-$tbl_data["total_others"]))?></td>
                          <td><?=$tbl_data["total_others"]?></td>
                          <td>Status</td>
                          <td><?=$tbl_data["today_active"]?> <span class="text-primary">(<?=(($tbl_data["today_active"]*100)/$tbl_data["total_se"])?> %)</span></td>
                          <td>For Productivity</td>

                        </tr>
                      <?php
                        }
                      ?>
                      <tbody>
                      </tbody>                      
                    </table>
                    <?php                                
                      }else{
                    ?>
                      <div class="col-sm-12">
                        <h1>You Are Not Assinged To Any Locality</h1>
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