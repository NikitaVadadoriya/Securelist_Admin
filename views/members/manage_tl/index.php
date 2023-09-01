<?php  
$user_type = str_replace(' ', '', $this->utype);
$tl_list = $this->TL_list;
$zone_list = $this->zone_list;
//print_r($zone_list);  
//die();
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Supervisor</h1>
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
      <form  action="<?=URL?><?=$user_type?>/manage_tl/add" method="post">
        <div class="card-body">
          <h5 class="mb-2">General Info</h5>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_fname">User First Name</label>
                <input type="text" class="form-control" id="user_fname" name="user_fname" placeholder="Enter First Name" required>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_lname">User Last Name</label>
                <input type="text" class="form-control" id="user_lname" name="user_lname" placeholder="Enter Last Name" required>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_mail">User Email Address</label>
                <input type="email" class="form-control" id="user_mail" name="user_mail" placeholder="Enter Email Address" required>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_phone">User Phone Number</label>
                <input type="number" class="form-control" id="user_phone" name="user_phone" placeholder="Enter Phone Number" required>
              </div>
            </div>
          </div>
          <?php  
            if ($user_type == "Manager") {
          ?>          
          <h5 class="mb-2">Assign Under </h5>
          <div class="row">            
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_city">Select Area</label>
                <select class="form-control select2" name="user_area" id="user_area" style="width: 100%;" onchange="get_supervisor(this,1)">
                  <option selected="selected" value="0">Select Zone first</option>
                  <?php 
                  foreach ($zone_list as $zone) { ?>
                    <option value="<?=$zone['id']?>"><?=$zone['zone']?></option>
                  <?php }
                  ?>
                </select>
              </div>
            </div>            
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_zone">Select Supervisor</label>
                <select class="form-control select2" name="supervisor" id="supervisor" style="width: 100%;" required="true">
                  <option selected="selected" value="0">Select Aear Or Manager first</option>
                  <?php  
                    foreach ($this->manager_list["city"] as $city_list) {
                  ?>
                    <option value="<?=$city_list["id"]?>"><?=$city_list["city"]?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
            </div>
          </div>    
          <?php
            }
          ?>
          <h5 class="mb-2">Assign To Area (Optional)</h5>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_city">Select Area</label>
                <select class="form-control select2" name="user_locality" id="user_locality" style="width: 100%;">
                  <option selected="selected" value="0">Select Zone first</option>
                  
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
  <div class="col-md-12">
    <div class="card card-default">
      <div class="card-body">
       <table id="datatable1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Sr No.</th>
            <th>User Full Name</th>
            <th>Under User Name</th>
            <th>User Mail</th>
            <th>User Contact</th>
            <th>Zone</th>
            <th>Area</th>
            <th>Locality</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php  
          foreach ($this->TL_list["user_data"] as $tl_list) {
            $i=1;
            ?>
            <tr>
              <td><?=$i?></td>
              <td><?php echo $tl_list["user_fname"] . " " . $tl_list["user_lname"]?></td>
              <td><?php echo $tl_list["underfname"] . " " . $tl_list["underlanme"]?></td>
              <td><?=$tl_list["user_mail"]?></td>
              <td><?=$tl_list["user_contact"]?></td>
              <td>
                <?php  
                if (isset($tl_list["zone_name"])) {
                  echo $tl_list["zone_name"];
                }else{
                  echo "Not Assgined To Any Locality";
                }
                ?>
              </td>
              <td>
                <?php  
                if (isset($tl_list["area_name"])) {
                  echo $tl_list["area_name"];
                }else{
                  echo "Not Assgined To Any Locality";
                }
                ?>
              </td>
              <td>
                <?php  
                if (isset($tl_list["localitie_name"])) {
                  echo $tl_list["localitie_name"];
                }else{
                  echo "Not Assgined To Any Locality";
                }
                ?>
              </td>
              <td><?php  
              if ($tl_list["status"] == 1) {
              ?>
                <p class='text-success'>Active</p>
              <?php
              }else{
              ?>
                <p class='text-danger'>Deactived</p>
              <?php
              }
              ?></td>
              <td>
                <a class="btn btn-primary btn-sm" href="<?=URL?><?=admin_link?>/add_teamleader/edit/<?=urlencode(base64_encode($tl_list["user_mail"]))?>" data-toggle="tooltip" title="Edit User">
                  <i class="fas fa-edit"></i>
                </a>
               <!--  <a class="btn btn-danger btn-sm" href="<?=URL?><?=admin_link?>/add_teamleader/delete" data-toggle="tooltip" title="Deactivate User">
                  <i class="fas fa-user-times"></i>
                </a> -->
              </td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper