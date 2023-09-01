
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Manager</h1>
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
      <form  action="<?=URL?><?=admin_link?>/add_manager/add" method="post">
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
          <h5 class="mb-2">Assign To Zone (Optional)</h5>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_city">Select City</label>
                <select class="form-control select2" name="user_city" id="user_city" style="width: 100%;" onchange="get_zone(this,0);">
                  <option selected="selected" value="0">Select City</option>
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
            <div class="col-sm-3">
              <div class="form-group">
                <label for="user_zone">Select Zone</label>
                <select class="form-control select2" name="user_zone" id="user_zone" style="width: 100%;">
                  <option selected="selected">Select City first</option>
                  
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
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php  
          foreach ($this->manager_list["user_data"] as $manager) {
            $i=1;
            ?>
            <tr>
              <td><?=$i?></td>
              <td><?php echo $manager["user_fname"] . " " . $manager["user_lname"]?></td>
              <td><?php echo $manager["underfname"] . " " . $manager["underlanme"]?></td>
              <td><?=$manager["user_mail"]?></td>
              <td><?=$manager["user_contact"]?></td>
              <td>
                <?php  
                if (isset($manager["zone_name"])) {
                  echo $manager["zone_name"];
                }else{
                  echo "Not Assgined To Any Zone";
                }
                ?>
              </td>
              <td><?php  
              if ($manager["status"] == 1) {
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
                <a class="btn btn-primary btn-sm" href="<?=URL?><?=admin_link?>/add_manager/edit/<?=urlencode(base64_encode($manager["user_mail"]))?>" data-toggle="tooltip" title="Edit User">
                  <i class="fas fa-edit"></i>
                </a>
               <!--  <a class="btn btn-danger btn-sm" href="<?=URL?><?=admin_link?>/add_manager/delete" data-toggle="tooltip" title="Deactivate User">
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