<?php  
  $supervisor = $this->supervisor_detail["supervisor_data"];
  
?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit Manager</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
               <?php $this->check_errors(); ?>
                <div class="col-md-12">
                    <div class="card card-default">
                     
                      <!-- form start -->
                      <form  action="<?=URL?><?=admin_link?>/add_supervisor/edit_user" method="post">
                        <div class="card-body">
                          <h5 class="mb-2">Genral Info</h5>
                          <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_fname">User Frist Name</label>
                                <input type="text" class="form-control" id="user_fname" name="user_fname" value="<?=$supervisor[0]["user_fname"]?>" placeholder="Enter First Name" required>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_lname">User Last Name</label>
                                <input type="text" class="form-control" id="user_lname" name="user_lname" value="<?=$supervisor[0]["user_lname"]?>"  placeholder="Enter Last Name" required>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_mail">User Email Address</label>
                                <input type="email" class="form-control" id="user_mail" name="user_mail" value="<?=$supervisor[0]["user_mail"]?>"  placeholder="Enter Email Address" required readonly="true" >
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_phone">User Phone Number</label>
                                <input type="number" class="form-control" id="user_phone" name="user_phone" value="<?=$supervisor[0]["user_contact"]?>"  placeholder="Enter Phone Number" required>
                              </div>
                            </div>
                          </div>
                          <h5 class="mb-2">Assign Under</h5>
                          <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_city">Select City</label>
                                <select class="form-control select2" name="user_city" id="user_city" style="width: 100%;" onchange="get_zone(this,0);">
                                  <option selected="selected" value="0">Select City</option>
                                  <?php  
                                    foreach ($this->supervisor_detail["city_data"] as $city_list) {
                                      if ($city_list["id"] == $supervisor[0]["city_id"]) {
                                        $class_tag ='selected="selected"';
                                      }else{
                                        $class_tag ='';
                                      }
                                  ?>
                                    <option value="<?=$city_list["id"]?>" <?=$class_tag?>><?=$city_list["city"]?></option>
                                  <?php
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_zone">Select Zone</label>
                                <select class="form-control select2" name="user_zone" id="user_zone" style="width: 100%;" onchange="get_manager_and_area(this,0);">
                                  <option selected="selected">Select City first</option>
                                  <?php  
                                    foreach ($this->supervisor_detail["zone_info"] as $zone_list) {
                                      if ($zone_list["id"] == $supervisor[0]["zone_name"]) {
                                        $class_tag ='selected="selected"';
                                      }else{
                                        $class_tag ='';
                                      }
                                  ?>
                                    <option value="<?=$zone_list["id"]?>" <?=$class_tag?>><?=$zone_list["zone"]?></option>
                                  <?php
                                    }
                                  ?>
                                </select>
                                
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_zone">Select Manager</label>
                                <select class="form-control select2" name="manager" id="manager" style="width: 100%;" required="true">
                                  <option selected="selected" value="0">Select Zone first</option>
                                  <?php  
                                    foreach ($this->supervisor_detail["manager"] as $manager_list) {
                                      if ($manager_list["user_id"] == $supervisor[0]["underid"]) {
                                        $class_tag ='selected="selected"';
                                      }else{
                                        $class_tag ='';
                                      }
                                  ?>
                                    <option value="<?=$manager_list["user_id"]?>" <?=$class_tag?>><?=$manager_list["user_fname"]." ".$manager_list["user_lname"]?></option>
                                  <?php
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div>    
                          <h5 class="mb-2">Assign To Area (Optional)</h5>
                            <div class="row">
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label for="user_city">Select Area</label>
                                  <select class="form-control select2" name="user_area" id="user_area" style="width: 100%;">
                                    <option selected="selected" value="0">Select Zone first</option>
                                    <?php  
                                    foreach ($this->supervisor_detail["area_info"] as $area_list) {
                                      if ($area_list["id"] == $supervisor[0]["area_name"]) {
                                        $class_tag ='selected="selected"';
                                      }else{
                                        $class_tag ='';
                                      }
                                  ?>
                                    <option value="<?=$area_list["id"]?>" <?=$class_tag?>><?=$area_list["area"]?></option>
                                  <?php
                                    }
                                  ?>
                                  </select>
                                </div>
                              </div>
                            </div>                      
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                    </div>
                </div>                             
            </section>
            <!-- /.content -->
        </div>
<!-- /.content-wrapper