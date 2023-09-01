<?php  
  $manager = $this->manage_detail["manager_data"];
  
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
                      <form  action="<?=URL?><?=admin_link?>/add_manager/edit_user" method="post">
                        <div class="card-body">
                          <h5 class="mb-2">Genral Info</h5>
                          <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_fname">User Frist Name</label>
                                <input type="text" class="form-control" id="user_fname" name="user_fname" value="<?=$manager[0]["user_fname"]?>" placeholder="Enter First Name" required>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_lname">User Last Name</label>
                                <input type="text" class="form-control" id="user_lname" name="user_lname" value="<?=$manager[0]["user_lname"]?>"  placeholder="Enter Last Name" required>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_mail">User Email Address</label>
                                <input type="email" class="form-control" id="user_mail" name="user_mail" value="<?=$manager[0]["user_mail"]?>"  placeholder="Enter Email Address" required readonly="true" >
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_phone">User Phone Number</label>
                                <input type="number" class="form-control" id="user_phone" name="user_phone" value="<?=$manager[0]["user_contact"]?>"  placeholder="Enter Phone Number" required>
                              </div>
                            </div>
                          </div>
                          <h5 class="mb-2">Assign To Zone (Optional)</h5>
                          <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="user_city">Select City</label>
                                <select class="form-control select2" name="user_city" id="user_city" style="width: 100%;" onchange="get_zone(this,0);">
                                  <option selected="selected" value="0">Select City</option>
                                  <?php  
                                    foreach ($this->manage_detail["city_data"] as $city_list) {
                                      if ($city_list["id"] == $manager[0]["city_id"]) {
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
                                <select class="form-control select2" name="user_zone" id="user_zone" style="width: 100%;">
                                  <option selected="selected">Select City first</option>
                                  <?php  
                                    foreach ($this->manage_detail["zone_info"] as $zone_list) {
                                      if ($zone_list["id"] == $manager[0]["zone_name"]) {
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